<?php

namespace App\Http\Controllers;
use App\Traits\ResponseTrait;
use App\Models\Dream;
use App\Http\Resources\DreamRecource;
use App\Http\Resources\ExplainRecource;
use App\Models\Category;
use App\Models\Replay;
use Illuminate\Http\Request;
use Auth;
use Requests;

class DreamController extends Controller
{
    use ResponseTrait;

    function notes(){
        $user = Auth::user();
        $notes = $user->notes();

        return $this->returnData( $this->success,'data',$user->notes()->get(),'success' );
    }
    function recent(){
        $dreams = Dream::where('status',1)->orderBy('id','desc')->paginate(10);

       
        return $this->returnData( $this->success,'data',DreamRecource::collection($dreams->getCollection()),'success' );


    }

    function frecent(){
        $dreams = Dream::where('featured',1)->orderBy('id','desc')->paginate(10);

       
        return $this->returnData( $this->success,'data',DreamRecource::collection($dreams->getCollection()),'success' );


    }

    function search( $keyword ){

        $dreams = Dream::where('status',1)->where('name','LIKE','%'.$keyword.'%')->get();

        return $this->returnData( $this->success,'data',DreamRecource::collection($dreams),'success' );


    }

    function categories( ){
        $cats = Category::all();

        return $this->returnData( $this->success,'data',$cats,'success' );


    }

    function category_dreams( $id ){
        $cats = Category::find($id);

        return $this->returnData( $this->success,'data',DreamRecource::collection($cats->dreams),'success' );
    }

    function user_dreams(){
        $cats = Auth::user();

        return $this->returnData( $this->success,'data',DreamRecource::collection($cats->dreams),'success' );
    }

    function user_dreams_request(){
        $cats = Auth::user();

        return $this->returnData( $this->success,'data',DreamRecource::collection($cats->dreams->where('status',0)),'success' );
    }

    function user_dreams_done(){
        $cats = Auth::user();

        return $this->returnData( $this->success,'data',DreamRecource::collection($cats->dreams->where('status',1)),'success' );
    }

    function add_new_dream( Request $request ){
        $d = new Dream();

        $d->name = $request->name;
        $d->content = $request->content;
        $d->category_id = $request->category_id;
        $d->user_id = Auth::user()->id;

        $d->age = $request->age;
        $d->sex = $request->sex;
        $d->social_status = $request->social_status;
        $d->health_status = $request->health_status;
        $d->brothers = $request->brothers;
        $d->physical_condition = $request->physical_condition;
        $d->parents = $request->parents;
        $d->time = $request->time;
        $d->kids = $request->kids;

        $d->save();

        $points = (int)Auth::user()->points;

        $points  -= 26;

        $user = Auth::user();

        $user->points = $points;

        $user->save();

        $replay_content = 'الجنس:' . $request->sex .'  ' . 'العمر:' . $request->age .'  ' . 'الحالة الاجتماعيه:' . $request->social_status .'  ' . 'الحالة الصحية:' . $request->health_status .'  ' .  'الحالة المادية:' . $request->physical_condition ; 

        $r=new Replay();
        $r->content = $replay_content;
        $r->user_id = Auth::user()->id;
        $r->dream_id = $d->id;
        $r->side = 'right';
        $r->save();

        $r=new Replay();
        $r->content = $request->name;
        $r->user_id = Auth::user()->id;
        $r->dream_id = $d->id;
        $r->side = 'right';
        $r->save();

        $r=new Replay();
        $r->content = $request->content;
        $r->user_id = Auth::user()->id;
        $r->dream_id = $d->id;
        $r->side = 'right';
        $r->save();

        return $this->returnData( $this->success,'data',ExplainRecource::make(Dream::find($d->id)),'success' );



    }

    function replay( Request $request ){
        
        $d = Dream::find($request->dream_id);
        $d->hasreplay = 1;
        $d->save();
        $r=new Replay();
        $r->content = $request->content;
        $r->user_id = Auth::user()->id;
        $r->dream_id = $request->dream_id;
        $r->side = 'right';
        $r->save();

        return $this->returnData( $this->success,'data',ExplainRecource::make(Dream::find($d->id)),'success' );



    }

    function view_dream($id){
        $cats = Dream::find($id);

        return $this->returnData( $this->success,'data',ExplainRecource::make($cats),'success' );
    }

    function chat($id){
        $cats = Dream::find($id);

        return response()->json([
            'status' => true,
            'code' => $this->success,
            'msg' => 'success',
            'opened' => $cats->opened,
            'data' => $cats->replays,
        ], 200);

        //return $this->returnData( $this->success,'data',$cats->replays,'success' );
    }
    //TODO 
    function update_view(Request $request){
        $cats = Dream::find($request->dream_id);
        $cats->views+=1;
        $cats->save();

        return $this->returnData( $this->success,'data',ExplainRecource::make($cats),'success' );
    }

    function update_points(Request $request){
        $cats = Auth::user();
        $cats->points+=$request->points;
        $cats->save();

        return response(['status' => true,'code' => 200,'msg' => 'success', 'data' => [
            'user' => $cats
        ]]);
    }

    public function update_token( Request $request ){
        $user = Auth::user();
        $user->token = $request->token;
        $user->save();

        $accessToken = $user->createToken('authToken')->accessToken;

            return response(['status' => true,'code' => 200,'msg' => 'success', ]);
    }
}
