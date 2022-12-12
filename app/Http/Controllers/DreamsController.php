<?php

namespace App\Http\Controllers;

use App\Models\Dream;
use App\Models\Notification;
use App\Models\Replay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use App\Models\User;
use App\Models\Category;

class DreamsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    
    {
        return view('dreams');
    }

    public function getDreamsList(Request $request)
    {
        $data = Dream::orderBy('created_at', 'DESC')->get();

        return DataTables::of($data)
              
                    ->addColumn('cat', function ($data) {
                                
                        return $data->cat->name;
                    
                    })
                    ->addColumn('status2', function ($data) {
                                    
                        $f = 'لا';
                        if ($data->featured == 1) {
                            $f = 'نعم';
                        }
                        return $f;
                    
                    })

                    ->addColumn('has', function ($data) {
                                    
                        $f = 'لا';
                        if ($data->hasreplay == 1) {
                            $f = 'نعم';
                        }
                        return $f;
                    
                    })
                    ->addColumn('client', function ($data) {
                                    
                        
                        return ( $data->usr_id != 0 ) ? $data->client->name :'لا احد';
                        // return  $data->usr_id ;
                    
                    })
                    ->addColumn('opened', function ($data) {
                                    
                        $f = 'لا';
                        if ($data->opened == 0) {
                            $f = 'نعم';
                        }
                        return $f;
                    
                    })
                    ->addColumn('action', function ($data) {
                    if ($data->name == 'Super Admin') {
                        return '';
                    }
                    if (Auth::user()->can('manage_user')) {
                        return '<div class="table-actions">
                        <a title="حجز الحلم" href="'.url('dreams/order/'.$data->id).'"><i class="ik ik-plus f-16 text-red"></i></a>
                                    <a title="عرض وتعديل الحلم " href="'.url('dreams/'.$data->id).'" ><i class="ik ik-edit-2 f-16 mr-15 text-green"></i></a>
                                    <a title="تحديد ك حلم مميز " href="'.url('dreams/'.$data->id.'/f').'" ><i class="ik ik-star f-16 mr-15 text-green"></i></a>
                                    <a title="حذف الحلم " href="'.url('dreams/delete/'.$data->id).'"><i class="ik ik-trash-2 f-16 text-red"></i></a>
                                    <a title="فتح و اغلاق الحلم" href="'.url('dreams/open/'.$data->id).'"><i class="ik ik-lock f-16 text-blue"></i></a>
                                    
                                    </div>';
                                } elseif (Auth::user()->can('tafseer')) {
                                    return '<div class="table-actions">
                                    <a title="" href="'.url('dreams/'.$data->id).'" ><i class="ik ik-edit-2 f-16 mr-15 text-green"></i></a>
                                    <a title="" href="'.url('dreams/order/'.$data->id).'"><i class="ik ik-trash-2 f-16 text-red"></i></a>
                                    <a title="فتح و اغلاق الحلم" href="'.url('dreams/open/'.$data->id).'"><i class="ik ik-lock f-16 text-blue"></i></a>
                                    </div>';
                        } else {
                        return '';
                    }
                })
                ->rawColumns(['status2','opened','permissions','action','has','client'])
                ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    function openDream( $id ){
        $dream = Dream::find( $id );

        if( $dream->opened == 1 ){
            $dream->opened = 0;
            $dream->save();
        }else{
            $dream->opened = 1;
            $dream->save();
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dream = Dream::find($id);
        $cats = Category::all();

        return view('dream',compact('dream','cats'));
    }
    function changeCat( Request $request ){

        $cats = Category::all();
        $dream = Dream::find( $request->dream_id );
        $dream->category_id = $request->category_id;
        $dream->save();
        return view('dream',compact('dream','cats'));

    }

    public function markf($id)
    {
        $dream = Dream::find($id);
        if( $dream->featured == 0 ){
            $dream->featured = 1 ;
        }else{
            $dream->featured = 0;
        }

        $dream->save();

        return redirect()->back();
    }

    public function order($id)
    {

        $dream = Dream::find($id);
        $dream->usr_id = Auth::user()->id;
        $dream->save();
        

        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $c = Dream::find($id);
        $c->delete();
        return redirect()->back();
    }

    public function addReplay( Request $request ){ 
        $r = new Replay();
        $r->content = $request->content;
        $r->user_id = $request->user_id;
        $r->dream_id = $request->dream_id;
        $r->side = 'left';
        $r->save();
        
        $dream = Dream::find($request->dream_id);
        $dream->hasreplay = 1;
        $dream->save();

        if( !empty( $request->status ) ){
            $dream->status = 1;
            $dream->save();
            $dream->opened = 0;
            $dream->save();
            sendNoti($dream->user_id,'مرحبا ','لقد تم تفسير حلمك','dream',$dream->id);
            
            $note = new Notification();
            $note->title = 'مرحبا';
            $note->content = 'لقد تم تفسير حلمك';
            $note->user_id = $dream->user_id;
            $note->route ='dream';
            $note->dream_id =$dream->id;
            $note->save();
        }else{

            sendNoti($dream->user_id,'مرحبا ','الموول بحاجه الي مزيد من المعلومات لتفسير حلمك','chat',$dream->id);
            $note = new Notification();
            $note->title = 'مرحبا';
            $note->content = 'الموول بحاجه الي مزيد من المعلومات لتفسير حلمك';
            $note->user_id = $dream->user_id;
            $note->route ='chat';
            $note->dream_id =$dream->id;
            $note->save();

            $dream->opened = 1;

            $dream->save();
        }
        
       
        return redirect()->back();
    }
}



function sendNoti($user_id,$title,$body,$route,$id){

    $user = User::find($user_id);


    $token = $user->token;  
        $from = "AAAA53N59_0:APA91bF27-YuWlYtfLoFYPDzsTqzL7VZvkTD5VsU3Gz9kh2thHQrn0HLm3lG4oedlPBNsqR61th11zgCkb_zHuJwm96oZzm0UBkHItKKgkcYF5YvawN32URY2lZTLMg8GcYMmccdDJC8";
        $msg = array
              (
                'body'  => $body,
                'title' => $title,
                'receiver' => 'Alaa',
                
                //'icon'  => "https://wecan.jo/wp-content/uploads/2020/06/logowecan.jpg",/*Default Icon*/
                'sound' => 'mySound'/*Default sound*/
              );

        $fields = array
                (
                    'to'        => $token,
                    'notification'  => $msg,
                    'data' => array (
                            "route" => $route,
                            "id" => $id,
                    )
                );
                

        $headers = array
                (
                    'Authorization: key=' . $from,
                    'Content-Type: application/json'
                );
        //#Send Reponse To FireBase Server 
        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch );
        //dd($result);
        curl_close( $ch );

}
