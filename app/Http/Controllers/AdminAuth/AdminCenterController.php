<?php

namespace App\Http\Controllers\AdminAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Notification;
use App\Center;
use App\CenterDoc;
use App\CenterJobRole;
use App\Mail\TCRejectMail;
use App\Mail\TCConfirmationMail;
use Crypt;
use Mail;
use DB;


class AdminCenterController extends Controller 
{
    public function __construct()
    {
        $this->middleware(['admin','prevent-back-history']);
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    public function centers(){ 

        $data=Center::all();
        return view('admin.centers.centers')->with(compact('data'));
    }

    public function centerView($id){

        $centerData=Center::findOrFail($id);
        $tcdata=DB::table('centers AS c')
        ->join('state_district AS s','c.state_district','=','s.id')
        ->join('parliament AS p','c.parliament','=','p.id')
        ->where('c.id',$id)->first();

        $tc_target=CenterJobRole::where([['tc_id','=',$id]])->get();

        $classroom=DB::table('center_docs')->where([['tc_id','=',$id],['room','=','class']])->get();
        $lab=DB::table('center_docs')->where([['tc_id','=',$id],['room','=','lab']])->get();
        $equip=DB::table('center_docs')->where([['tc_id','=',$id],['room','=','equip']])->get();
        $wash=DB::table('center_docs')->where([['tc_id','=',$id],['room','=','wash']])->get();
        
            return view('admin.centers.center-verify')->with(compact('centerData','tcdata','tc_target','classroom','lab','equip','wash'));
        
    }
    public function centerAccept($id){
        $center_id = Crypt::decrypt($id); 
        $center=Center::findOrFail($center_id);

        $data=DB::table('centers')
        ->select(\DB::raw('SUBSTRING(tc_id,3) as tc_id'))
        ->where("tc_id", "LIKE", "TC%")->get();
        $year = date('Y');
        if (count($data) > 0) {

            $priceprod = array();
                foreach ($data as $key=>$data) {
                    $priceprod[$key]=$data->tc_id;
                }
                $lastid= max($priceprod);
               
                $new_tcid = (substr($lastid, 0, 4)== $year) ? 'TC'.($lastid + 1) : 'TC'.$year.'000001' ;
            //dd($new_tpid);
        } else {
            $new_tcid = 'TC'.$year.'000001';
        }
        $center_password = str_random(8);
        $center->tc_id=$new_tcid;
        $center->password=Hash::make($center_password);
        $center->status=1;
        $center->ind_status=1;
        $center->verified=1;
        $center->save();

         /* Notification For Partner */
         $notification = new Notification;
         $notification->rel_id = $center->id;
         $notification->rel_with = 'center';
         $notification->title = 'Account Activated';
         $notification->message = "Your Profile has been <span style='color:blue;'>Approved</span>.";
         $notification->save();
         /* End Notification For Partner */
         $center['password']=$center_password;
         Mail::to($center['email'])->send(new TCConfirmationMail($center));

         alert()->success('Center Accepted', 'Done')->autoclose(2000);
         return Redirect()->back();

    }

    public function centerReject(Request $request){
        $data=Center::findOrFail($request->id);
        $data['note'] = $request->note;
        Mail::to($data->email)->send(new TCRejectMail($data));
        $data->delete();
        return response()->json(['status' => 'done'],200);
    }
    
    public function centerEdit($id){
     $center_id = Crypt::decrypt($id); 
     $center=Center::findOrFail($center_id);
     $states=DB::table('state_district')->get();
     $parliaments=DB::table('parliament')->get();

     return view('admin.centers.center-edit')->with(compact('center','states','parliaments'));

    }

    public function centerDetailsUpdate(Request $request){
        $center=Center::findOrFail($request->centerid);
        $center_doc_class=CenterDoc::where([['tc_id','=',$request->centerid],['room','=','class']])->get();
        $center_doc_lab=CenterDoc::where([['tc_id','=',$request->centerid],['room','=','lab']])->get();
        $center_doc_equip=CenterDoc::where([['tc_id','=',$request->centerid],['room','=','equip']])->get();
        $center_doc_wash=CenterDoc::where([['tc_id','=',$request->centerid],['room','=','wash']])->get();

        $center->spoc_name = $request->spoc_name;
        $center->email = $request->email;
        $center->mobile = $request->mobile;
        $center->center_name = $request->center_name;
        $center->center_address = $request->center_address;
        $center->landmark = $request->landmark;
        $center->addr_proof = $request->addr_proof;
        if($request->hasFile('addr_doc')){
            Storage::disk('myDisk')->delete($center->addr_doc);
            $center->addr_doc = Storage::disk('myDisk')->put('/centers', $request['addr_doc']);
            }
        $center->state_district = $request->state_district;
        $center->parliament = $request->parliament;
        $center->city = $request->city;
        $center->block = $request->block;
        $center->pin = $request->pin;

        if($request->hasFile('center_front_view')){
            Storage::disk('myDisk')->delete($center->center_front_view);
            $center->center_front_view = Storage::disk('myDisk')->put('/centers', $request['center_front_view']);
            }
        if($request->hasFile('center_back_view')){
            Storage::disk('myDisk')->delete($center->center_back_view);
            $center->center_back_view = Storage::disk('myDisk')->put('/centers', $request['center_back_view']);
            }
        if($request->hasFile('center_right_view')){
            Storage::disk('myDisk')->delete($center->center_right_view);
            $center->center_right_view = Storage::disk('myDisk')->put('/centers', $request['center_right_view']);
        }
        if($request->hasFile('center_left_view')){
            Storage::disk('myDisk')->delete($center->center_left_view);
            $center->center_left_view = Storage::disk('myDisk')->put('/centers', $request['center_left_view']);
            }

           
        if($request->hasFile('class_room')){
            foreach ($center_doc_class as  $doc) {
                Storage::disk('myDisk')->delete($doc->doc);
               
            }
            CenterDoc::where([['tc_id','=',$request->centerid],['room','=','class']])->delete();
            foreach ($request->class_room as $class) {
               $class_doc=new CenterDoc;
               $class_doc->tc_id=$request->centerid;
               $class_doc->room='class';
               $class_doc->doc=Storage::disk('myDisk')->put('/centers', $class);
               $class_doc->save();
            }
           
            }
        if($request->hasFile('lab_room')){
            foreach ($center_doc_lab as  $doc) {
                Storage::disk('myDisk')->delete($doc->doc);
               
            }
            CenterDoc::where([['tc_id','=',$request->centerid],['room','=','lab']])->delete();
            foreach ($request->lab_room as $lab) {
               $class_doc=new CenterDoc;
               $class_doc->tc_id=$request->centerid;
               $class_doc->room='lab';
               $class_doc->doc=Storage::disk('myDisk')->put('/centers', $lab);
               $class_doc->save();
            }
           
            }
        if($request->hasFile('equipment_room')){
            foreach ($center_doc_equip as  $doc) {
                Storage::disk('myDisk')->delete($doc->doc);
               
            }
            CenterDoc::where([['tc_id','=',$request->centerid],['room','=','equip']])->delete();
            foreach ($request->equipment_room as $equip) {
               $class_doc=new CenterDoc;
               $class_doc->tc_id=$request->centerid;
               $class_doc->room='equip';
               $class_doc->doc=Storage::disk('myDisk')->put('/centers', $equip);
               $class_doc->save();
            }
           
            }
        if($request->hasFile('wash_room')){
            foreach ($center_doc_wash as  $doc) {
                Storage::disk('myDisk')->delete($doc->doc);
               
            }
            CenterDoc::where([['tc_id','=',$request->centerid],['room','=','wash']])->delete();
            foreach ($request->wash_room as $wash) {
               $class_doc=new CenterDoc;
               $class_doc->tc_id=$request->centerid;
               $class_doc->room='wash';
               $class_doc->doc=Storage::disk('myDisk')->put('/centers', $wash);
               $class_doc->save();
            }
           
            }

            if($request->hasFile('bio_room')){
                $center->biometric = Storage::disk('myDisk')->put('/centers', $request['bio_room']);
                }
            if($request->hasFile('drink_room')){
                $center->drinking = Storage::disk('myDisk')->put('/centers', $request['drink_room']);
                }
            if($request->hasFile('safety')){
                $center->safety = Storage::disk('myDisk')->put('/centers', $request['safety']);
                }

                 /* Notification For center */
                $notification = new Notification;
                $notification->rel_id = $center->id;
                $notification->rel_with = 'center';
                $notification->title = 'Account Updated';
                $notification->message = "Your Profile has been <span style='color:blue;'>Updated</span>.";
                $notification->save();
                /* End Notification For center */
                 /* Notification For Partner */
                $notification = new Notification;
                $notification->rel_id = $center->tp_id;
                $notification->rel_with = 'partner';
                $notification->title = 'Account Updated';
                $notification->message = "Your Center has been <span style='color:blue;'>Updated</span>.";
                $notification->save();
                /* End Notification For Partner */

            $center->save();
            alert()->success('Center Details Updated', 'Done')->autoclose(2000);
            return Redirect()->back();
    }

    public function centerDeactive(Request $request){
        $center=Center::findOrFail($request->id);
        $center->status=0;
        $center->save();

        foreach ($center->trainers as $trainer) {
            $trainer->ind_status = 0;
            $trainer->save();
        }

        return response()->json(['status' => 'done'],200);
    }
    public function centerActive($id){
        $id=Crypt::decrypt($id);
        $center=Center::findOrFail($id);
        $center->status=1;
        $center->save();

        foreach ($center->trainers as $trainer) {
            $trainer->ind_status =1;
            $trainer->save();
        }

        alert()->success('Center Activated', 'Done')->autoclose(2000);
            return Redirect()->back();
    }
}
