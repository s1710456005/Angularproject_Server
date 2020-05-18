<?php

namespace App\Http\Controllers;

use App\Shoppinglist;
use App\Unit;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Status;
use App\User;
use App\Message;
use App\Shoppingitem;
use Psy\Util\Json;

class ShoppinglistController extends Controller
{
    /**
     * overview of the shoppinglists
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index(){
        $shoppinglists = Shoppinglist::with(['status','user','volunteer', 'shoppingitems','messages','bills'])->get();
        return $shoppinglists;
    }

    public function getAllUnits(){
        $units = Unit::all();
        return $units;
    }

    /**
     * detail view of one shoppinglist
     * @param Shoppinglist $shoppinglist
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Shoppinglist $shoppinglist){
        //find by id is done by passed variable already.. do only need to return the view
        return view('shoppinglists.show', compact('shoppinglist'));
    }

    /**
     * detail view of one shoppinglist - return one shopping list by passed id
     * @param $id
     * @return Shoppinglist
     */
    public function findById(string $id):Shoppinglist{
        $shoppinglist = Shoppinglist::where('id', (int)$id)
            ->with(['status','user','volunteer','shoppingitems.unit','messages.user','bills'])
            ->first();
        return $shoppinglist;
    }


    /**
     * create a new shoppinglist and save it to db, it is used if a shoppinglist is completely new generated
     * @param Request $request
     * @return JsonResponse
     */
    public function save(Request $request):JsonResponse{
        $request = $this->parseRequest($request);

        //transaction to save the model including all relations of shoppinglist
        DB::beginTransaction();
        try{
            //$shoppinglist = Shoppinglist::create($request->all());
            //TODO after authentification, remove hardcoded userid
            $shoppinglist = Shoppinglist::create(['title'=>$request['title'],
                'deadline'=>$request['deadline'],
                'user_id'=>$request['user_id'],
                'status_id'=>1]);

            if (isset($request['shoppingitems']) && is_array($request['shoppingitems'])) {
                foreach ($request['shoppingitems'] as $shoppingitemReqVal ) {
                    $shoppingitem = Shoppingitem::create([
                        'shoppinglist_id'=>$shoppinglist->id,
                            'unit_id'=>$shoppingitemReqVal['unit']['id']==null?1:$shoppingitemReqVal['unit']['id'],
                            'title'=>$shoppingitemReqVal['title'],
                            'quantity'=>$shoppingitemReqVal['quantity'],
                            'price'=>$shoppingitemReqVal['price']]);
                    $shoppinglist->shoppingitems()->save( $shoppingitem );
                }
            }
            //if exist, save message to the shoppinglist
            if (isset($request['messages']) && is_array($request['messages'])) {
                foreach ($request['messages'] as $messageReqVal ) {
                    $message = Message::create([
                        'shoppinglist_id'=>$shoppinglist->id,
                        'messagetext'=>$messageReqVal['messagetext'],
                        'user_id'=>$messageReqVal['user_id']]);
                    $shoppinglist->messages()->save( $message );
                }
            }

            DB::commit();
            // return a vaild http response
            return response()->json( $shoppinglist , 201 );

        } catch (\Exception $e){
            // rollback all queries
            DB::rollBack();
            return response()->json( "saving shoppinglist failed: " . $e ->getMessage(), 420 );
        }
    }

    /**
     * updating the shoppinglist and all its items, if the item doesn't exist create a new one
     * @param Request $request
     * @param string $id, cast to int to search in db
     * @return JsonResponse
     */
    public function update(Request $request, string $id): JsonResponse{
        //transaction to save the model including all relations of shoppinglist
        DB::beginTransaction();
        try{
            $shoppinglist = Shoppinglist::with(['status','user','shoppingitems','messages','bills'])
                ->where('id', (int)$id)->first();
            if($shoppinglist!=null){
                $request = $this->parseRequest($request);
                $shoppinglist->update($request->all());
                if($request['status']['id'])
                    $shoppinglist->update(['status_id'=>$request['status']['id']]);
                if($request['volunteer']['id'])
                    $shoppinglist->update(['volunteer_id'=>$request['volunteer']['id']]);
                //if exist, save shoppingitems to the shoppinglist
                if (isset($request['shoppingitems']) && is_array($request['shoppingitems'])) {
                    //delete all old items that have been remove during update
                    //insert them again based on the request array
                    $shoppinglist->shoppingitems()->delete();
                    foreach ($request['shoppingitems'] as $shoppingitemReqVal ) {
                        //only shoppingitems that have been updated are considered
                        $shoppingitem = Shoppingitem::firstOrNew([
                            'unit_id'=>isset($shoppingitemReqVal['unit_id']) ?
                                $shoppingitemReqVal['unit_id'] :
                                $shoppingitemReqVal['unit']['id'],
                            'title'=>$shoppingitemReqVal['title'],
                            'quantity'=>$shoppingitemReqVal['quantity'],
                            'price'=>$shoppingitemReqVal['price'],
                        ]);
                        $shoppinglist->shoppingitems()->save($shoppingitem);
                    }
                }
                //if exist, save message to the shoppinglist
                if (isset($request['messages']) && is_array($request['messages'])) {
                    foreach ($request['messages'] as $messageReqVal ) {
                        $message = Message::firstOrNew([
                            'shoppinglist_id'=>$shoppinglist->id,
                            'messagetext'=>$messageReqVal['messagetext'],
                            'user_id'=>$messageReqVal['user_id']]);
                        $shoppinglist->messages()->save( $message );
                    }
                }
                $shoppinglist->save();
            }
            DB::commit();
            $shoppinglistResp = Shoppinglist::with(['status','user','shoppingitems','messages','bills'])
                ->where('id', (int)$id)->first();
            // return a vaild http response
            return response()->json( $shoppinglistResp , 201 );

        } catch (\Exception $e){
            // rollback all queries
            DB::rollBack ();
            return response()->json( "updating shoppinglist failed: " . $e ->getMessage(), 420 );
        }
    }

    /**
     * delete the shoppinglist
     * @param string $id
     * @return JsonResponse
     * @throws \Exception
     */
    public function delete(string $id):JsonResponse{
        $shoppinglist = Shoppinglist::where('id', (int)$id)->first();
        if($shoppinglist!=null){
            $shoppinglist->delete();
        }else{
            throw new \Exception("shoppinglist couldn't be deleted - it does not exist" );
        }

        return response()->json('shoppinglist ( id '.$id.' ) successfully deleted' , 200 );
    }

    /**
     * modify / convert values if needed
     * @param Request $request
     * @return Request
     */
    private function parseRequest ( Request $request ) : Request {
        // get date and convert it - its in ISO 8601, e.g. "2018-01-01T23:00:00.000Z"
        $date = new \DateTime ( $request -> deadline);
        $request [ 'deadline' ] = $date;
        return $request;
    }





}
