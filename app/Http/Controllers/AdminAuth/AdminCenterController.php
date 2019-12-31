<?php

namespace App\Http\Controllers\AdminAuth;

use DB;
use Auth;
use Mail;
use Crypt;
use Validator;
use App\Center;
use App\Reason;
use App\Candidate;
use App\CenterDoc;
use App\Mail\TCMail;
use App\Notification;
use App\CenterJobRole;
use App\PartnerJobrole;
use App\CenterCandidateMap;
use App\Events\TCMailEvent;
use App\Events\TPMailEvent;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Encryption\DecryptException;


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

    protected function decryptThis($id){
        try {
            return Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return abort(404);
        }
    }

    
    protected function writeNotification($relid,$relwith,$title,$msg){
        $notification = new Notification;
        $notification->rel_id = $relid;
        $notification->rel_with = $relwith;
        $notification->title = $title;
        $notification->message = $msg;
        $notification->save();
    }

    public function centers(){ 

        $data=Center::where('verified',1)->get();
        return view('admin.centers.centers')->with(compact('data'));
    }
    public function pendingCenters(){ 

        $data=Center::where('verified',0)->get();
        return view('admin.centers.pending-centers')->with(compact('data'));
    }

    public function centerView($id){

        if ($id = $this->decryptThis($id)) {
            $centerData=Center::findOrFail($id);
            $state_district=DB::table('centers AS c')
            ->join('state_district AS s','c.state_district','=','s.id')
            ->join('parliament AS p','c.parliament','=','p.id')
            ->where('c.id',$id)->first();
            $tc_target=CenterJobRole::where('tc_id',$id)->get();
            return view('common.view-center')->with(compact('centerData','state_district', 'tc_target'));
        }
        
    }
    // public function centerAccept($id){
    //     if ($center_id=$this->decryptThis($id)) {
    //         $center=Center::findOrFail($center_id);
    //         if($center->verified==1){
    //             alert()->error("Training center Account already <span style='color:blue;'>Approved</span>", "Done")->html()->autoclose(2000);
    //             return Redirect()->back(); 
    //         }
    //         $data=DB::table('centers')
    //         ->select(\DB::raw('SUBSTRING(tc_id,3) as tc_id'))
    //         ->where("tc_id", "LIKE", "TC%")->get();
    //         $year = date('Y');
    //         if (count($data) > 0) {
    
    //             $priceprod = array();
    //                 foreach ($data as $key=>$data) {
    //                     $priceprod[$key]=$data->tc_id;
    //                 }
    //                 $lastid= max($priceprod);
                   
    //                 $new_tcid = (substr($lastid, 0, 4)== $year) ? 'TC'.($lastid + 1) : 'TC'.$year.'000001' ;
    //             //dd($new_tpid);
    //         } else {
    //             $new_tcid = 'TC'.$year.'000001';
    //         }
    //         $center_password = str_random(8);
    //         $center->tc_id=$new_tcid;
    //         $center->password=Hash::make($center_password);
    //         $center->status=1;
    //         $center->verified=1;
    //         $center->save();
    
    //          /* Notification For Partner */
    //          $notification = new Notification;
    //          $notification->rel_id = $center->tp_id;
    //          $notification->rel_with = 'partner';
    //          $notification->title = 'TC has been Approved';
    //          $notification->message = "Training Center <br>(ID: <span style='color:blue;'>$new_tcid</span>) has been Approved";
    //          $notification->save();
    //          /* End Notification For Partner */
    //          $center['password']=$center_password;
    //          Mail::to($center['email'])->send(new TCConfirmationMail($center));
    
    //          alert()->success('Training Center has been Approved', 'Job Done')->autoclose(3000);
    //          return redirect()->back();
    //     }
    // }

    // public function centerReject(Request $request){
    //     $data=Center::findOrFail($request->id);
    //     $data['note'] = $request->note;
    //     Mail::to($data->email)->send(new TCRejectMail($data));
    //      /* Notification For Partner */
    //      $notification = new Notification;
    //      $notification->rel_id = $data->tp_id;
    //      $notification->rel_with = 'partner';
    //      $notification->title = 'Training Center Rejected';
    //      $notification->message = "Training Center (Spoc Name: <span style='color:blue;'>$data->spoc_name</span>) has been Rejected";
    //      $notification->save();
    //      /* End Notification For Partner */

    //      CenterDoc::where('tc_id',$request->id)->delete();
    //      CenterJobRole::where('tc_id',$request->id)->delete();
       
    //      $data->delete();
    //     return response()->json(['status' => 'done'],200);
    // }


    public function centerAction(Request $request)
    {
        if ($id=$this->decryptThis($request->id)) {
            $center = Center::findOrFail($id);
            if ($center->verified) {
                alert()->info('Training Center Already has been Approved', 'Attention')->autoclose(3000);
                return redirect()->back();
            } elseif (!$center->partner->status) {
                alert()->error('Please <span style="color:blue;">Re-Activate</span> TP of This TC Before you Proceed', 'Aborting')->html()->autoclose(5000);
                return redirect()->back();
            } else {
                $dataMail = collect();
                if ($request->action == 'accept') {
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
                        } else {
                            $new_tcid = 'TC'.$year.'000001';
                        }

                        $center_password = str_random(8);
                        $center->tc_id=$new_tcid;
                        $center->password=Hash::make($center_password);
                        $center->status= $center->verified = 1;
                        $center->save();

                        $this->writeNotification($center->tp_id,'partner','Training Center Approved',"Your Requested TC(SPOC Name: <span style='color:blue;'>$center->spoc_name</span>) has been <span style='color:blue;'>Approved</span>.");
                        alert()->success('Training Center has been Approved', 'Job Done')->autoclose(3000);
                
                        $dataMail->tag = 'tcaccept';
                        $dataMail->spoc_name = $center->spoc_name;
                        $dataMail->tp_name = $center->partner->spoc_name;
                        $dataMail->tc_id = $center->tc_id;
                        $dataMail->password = $center_password;
                        $dataMail->email = $center->email;
                        event(new TCMailEvent($dataMail));
                        $dataMail->email = $center->partner->email;
                        event(new TPMailEvent($dataMail));

                } elseif ($request->action == 'reject' && $request->reason != '') {
                    $this->writeNotification($center->tp_id,'partner','Training Center Rejected',"Your Requested TC(SPOC Name: <span style='color:blue;'>$center->spoc_name</span>) has been <span style='color:red;'>Rejected</span>.");
                    $spoc_name = $center->partner->spoc_name;
                    $tc_name = $center->spoc_name;
                    $email = $center->email;
                    DB::transaction(function() use ($center,$id){
                        foreach ($center->center_jobroles as $centerJob) {
                            $partnerJob = PartnerJobrole::find($centerJob->partnerjobrole->id);
                            $partnerJob->assigned = $partnerJob->assigned - $centerJob->target;
                            $partnerJob->save();
                        }
                        $center->center_docs()->delete();
                        $center->center_jobroles()->delete();
                        $center->delete();
                    });
                    alert()->success('Training Center Request has been Rejeted', 'job Done')->autoclose(3000);
                    
                    $dataMail->tag = 'tcreject';
                    $dataMail->spoc_name = $spoc_name;
                    $dataMail->email = $email;
                    $dataMail->tc_name = $tc_name;
                    $dataMail->reason = $request->reason;
                    event(new TPMailEvent($dataMail));
                
                } else {
                    alert()->error('Something went Wrong', 'Try Again')->autoclose(3000);
                }
                return redirect()->route('admin.tc.centers');
            }
        }
    }

    
    public function centerEdit($id){
        if ($id = $this->decryptThis($id)) {
            $data = [
                'center'=>Center::findOrFail($id),
                'states'=>DB::table('state_district')->get(),
                'parliaments'=>DB::table('parliament')->get(),
            ];
            return view('admin.centers.center-edit')->with($data);
        }
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
            alert()->success("Center Details <span style='color:blue;font-weight:bold'>Updated</span>", 'Done')->html()->autoclose(2000);
            return Redirect()->back();
    }

    // * Training Cenetr Activation Deactvation

    public function centerStatusAction(Request $request){
        if ($request->has('data')) {

            if ($id=$this->decryptThis($request->data)) {
                $data = explode(',',$id);
                $center = Center::find($data[0]);

                if ($center) {
                    $dataMail = collect();
                    if ($center->status) {
                        if (!is_null($request->reason) && $request->reason != '') {
                            $center->status = 0;
                            $center->save();
                            $reason = new Reason;
                            $reason->rel_id = $data[0];
                            $reason->rel_with = 'center';
                            $reason->reason = $request->reason;
                            $reason->save();

                            $dataMail->tag = 'tcdeactive'; // * Mailling Tag
                            $dataMail->reason = $request->reason; 
                            
                            $this->writeNotification($center->tp_id,'partner','Training Center Deactivated',"TC (ID: <span style='color:blue;'>$center->tc_id</span>) Account is now <span style='color:red;'>Dectivated</span>.");
                            $array = array('type' => 'success', 'message' => "Training Center Account is <span style='font-weight:bold;color:red'>Deactivated</span> now");
                        } else {
                            $array = array('type' => 'error', 'message' => "Deactivation Reason can not be <span style='font-weight:bold;color:red'>NULL</span>");
                        }
                    } else {
                        $center->status = 1;
                        $center->save();

                        $dataMail->tag = 'tcactive'; // * Mailling Tag

                        $this->writeNotification($center->tp_id,'partner','Training Center Activated',"TC (ID: <span style='color:blue;'>$center->tc_id</span>) Account is now <span style='color:blue;'>Activated</span>.");
                        $array = array('type' => 'success', 'message' => "Training Center Account is <span style='font-weight:bold;color:blue'>Activated</span> now");
                    }

                    $dataMail->spoc_name = $center->spoc_name;
                    $dataMail->email = $center->email;
                    $dataMail->tc_id = $center->tc_id;
                    if ($center->partner->status) {
                        event(new TCMailEvent($dataMail));
                        $dataMail->spoc_name = $center->partner->spoc_name;
                        $dataMail->email = $center->partner->email;
                        event(new TPMailEvent($dataMail));
                    }
                    return response()->json($array,200);
                } else {
                    return response()->json(array('type' => 'error', 'message' => "We Could not find this Training Center Account"),400);
                }

            } else {
                return response()->json(array('type' => 'error', 'message' => "Reqested Account is not Found"),400);
            }
        }        
    }

    // * End Training Partner Activation Deactvation



    // public function centerDeactive(Request $request){
    //     $center=Center::findOrFail($request->id);
    //     $center->status=0;
    //     $center->save();

    //     $reason = new Reason;
    //     $reason->rel_id = $center->id;
    //     $reason->rel_with = 'center';
    //     $reason->reason = $request->reason;
    //     $reason->save();

    //       /* Notification For Partner */
    //       $notification = new Notification;
    //       $notification->rel_id = $center->tp_id;
    //       $notification->rel_with = 'partner';
    //       $notification->title = 'Training Center Deactive';
    //       $notification->message = "One of Your Center has been <span style='color:blue;'>Deactivated</span>.";
    //       $notification->save();
    //       /* End Notification For Partner */

    //     return response()->json(['status' => 'done'],200);
    // }
    // public function centerActive($id){
        
    //     if ($id = $this->decryptThis($id)) {
    //         $center=Center::findOrFail($id);
    //         $center->status=1;
    //         $center->save();
    
    //          /* Notification For Partner */
    //          $notification = new Notification;
    //          $notification->rel_id = $center->tp_id;
    //          $notification->rel_with = 'partner';
    //          $notification->title = 'Training Center Active';
    //          $notification->message = "One of Your Center has been <span style='color:blue;'>Activated</span>.";
    //          $notification->save();
    //          /* End Notification For Partner */
    
    //         alert()->success('Center Activated', 'Done')->autoclose(2000);
    //         return redirect()->back();
    //     }
    // }

    public function candidates(){
        $candidates = DB::table('candidates  as cd')->join('center_candidate_maps AS ccm', 'ccm.cd_id', '=', 'cd.id')
            ->orderBy('ccm.id', 'desc')            
            ->get()->unique('cd_id')->pluck('id')->toArray();
        
        $data = [
            'admin'  => $this->guard()->user(),
            'candidates' => CenterCandidateMap::whereIn('id', $candidates)->get(),
        ];
        return view('common.candidates')->with($data);
    }

    public function view_candidate($id){
        if ($id = $this->decryptThis($id)) {
            $candidate = Candidate::findOrFail($id);
            $center_candidate= $candidate->centerlatest;
            $state_dist = DB::table('state_district')->where('id',$center_candidate->state_district)->first();
            return view('common.view-candidate')->with(compact('center_candidate','state_dist'));
        }
    }

    public function candidateStatusAction(Request $request)
    {
        if ($request->has('data')) {

            if ($id=$this->decryptThis($request->data)) {
                $data = explode(',',$id);
                $candidate = Candidate::find($data[0]);

                if ($candidate) {
                    if ($candidate->status) {
                        if (!is_null($request->reason) && $request->reason != '') {
                            $candidate->status = 0;
                            $candidate->save();
                            $reason = new Reason; 
                            $reason->rel_id = $candidate->id;
                            $reason->rel_with = 'candidate';
                            $reason->reason = $request->reason;
                            $reason->save();
                            $this->writeNotification($candidate->centerlatest->tc_id,'center','Candidate Deactivated',"Candidate (<span style='color:blue;'>$candidate->name</span>) is now <span style='color:red;'>Deactive</span>.");
                            $this->writeNotification($candidate->centerlatest->center->tp_id,'partner','Candidate Deactivated',"Candidate (<span style='color:blue;'>$candidate->name</span>) is now <span style='color:red;'>Dectivated</span>.");
                            $array = array('type' => 'success', 'message' => "Candidate is <span style='font-weight:bold;color:red'>Deactivated</span> now");
                        } else {
                            $array = array('type' => 'error', 'message' => "Deactivation Reason can not be <span style='font-weight:bold;color:red'>NULL</span>");
                        }
                    } else {
                        $candidate->status = 1;
                        $candidate->save();
                        $this->writeNotification($candidate->centerlatest->tc_id,'center','Candidate Activated',"Candidate (<span style='color:blue;'>$candidate->name</span>) is now <span style='color:red;'>Active</span>.");
                        $this->writeNotification($candidate->centerlatest->center->tp_id,'partner','Candidate Activated',"Candidate (<span style='color:blue;'>$candidate->name</span>) is now <span style='color:red;'>Active</span>.");
                        $array = array('type' => 'success', 'message' => "Candidate is <span style='font-weight:bold;color:blue'>Activated</span> now");
                    }
                    return response()->json($array,200);
                } else {
                    return response()->json(array('type' => 'error', 'message' => "We Could not find this Training Center Account"),400);
                }

            } else {
                return response()->json(array('type' => 'error', 'message' => "Reqested Account is not Found"),400);
            }
        } 
    }


    // public function candidateActive($id){
    //     if ($id=$this->decryptThis($id)) {
    //         $candidate=Candidate::findOrFail($id);
    //         $candidate->status=1;
    //         $candidate->save();
    
    //         /* Notification For Center */
    //         $notification = new Notification;
    //         $notification->rel_id = $candidate->tc_id;
    //         $notification->rel_with = 'center';
    //         $notification->title = 'Candidate Active';
    //         $notification->message = "One of Your Candidate has been <span style='color:blue;'>Activated</span>.";
    //         $notification->save();
    //         /* End Notification For Center */
    
    //         alert()->success('Candidate Activated', 'Done')->autoclose(2000);
    //         return redirect()->back();
    //     }
    // }

    // public function candidateDeactive(Request $request){

    //     $candidate=Candidate::findOrFail($request->id);
    //     $candidate->status=0;
    //     $candidate->save();

    //     $reason = new Reason;
    //     $reason->rel_id = $candidate->id;
    //     $reason->rel_with = 'candidate';
    //     $reason->reason = $request->reason;
    //     $reason->save();

    //      /* Notification For Center */
    //      $notification = new Notification;
    //      $notification->rel_id = $candidate->tc_id;
    //      $notification->rel_with = 'center';
    //      $notification->title = 'Candidate Deactive';
    //      $notification->message = "One of Your Candidate has been <span style='color:blue;'>Deactivated</span>.";
    //      $notification->save();
    //      /* End Notification For Center */

    //      return response()->json(['status' => 'done'],200);

    // }

    public function candidateEdit($id){
        if ($id = $this->decryptThis($id)) {
            $candidate=Candidate::findOrFail($id);
            $center=Center::where('id',$candidate->tc_id)->first();
            $states=DB::table('state_district')->get();
            return view('admin.centers.candidate-edit')->with(compact('candidate','center','states'));
        }
    }

    public function candidateUpdate(Request $request){
        $candidate=Candidate::findOrFail($request->candidate_id);

        $candidate->name = $request->name;
        $candidate->gender = $request->gender;
        $candidate->contact = $request->contact;
        $candidate->email = $request->email;
        $candidate->dob = $request->dob;
        $candidate->m_status = $request->m_status;

        $candidate->address = $request->address;
        $candidate->state_district = $request->state_district;
        $candidate->category = $request->category;
        $candidate->service = $request->service;
        $candidate->education = $request->education;
        $candidate->g_name = $request->g_name;
        $candidate->g_type = $request->g_type;

         /* Notification For center */
         $notification = new Notification;
         $notification->rel_id = $candidate->tc_id;
         $notification->rel_with = 'center';
         $notification->title = 'Candidate Updated';
         $notification->message = "One of Your Candidate has been <span style='color:blue;'>Updated</span>.";
         $notification->save();
         /* End Notification For center */

         $candidate->save();
         alert()->success('Candidate Details Updated', 'Done')->autoclose(2000);
         return Redirect()->back();
    }

    public function centerApi(Request $request){
        if ($request->has('checkredundancy')) {
            if ($request->has('id')) { 
                if (Center::where([[$request->section,$request->checkredundancy],['id','!=',$request->id]])->first()) {
                    return response()->json(['success' => false], 200);
                } else {
                    return response()->json(['success' => true], 200);
                }
            }
        }

    }
}
