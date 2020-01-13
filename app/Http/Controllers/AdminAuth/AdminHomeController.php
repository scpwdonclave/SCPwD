<?php

namespace App\Http\Controllers\AdminAuth;

use DB;
use Crypt;
use App\Agency;
use App\Center;
use App\Scheme;
use App\Sector;
use App\Holiday;
use App\JobRole;
use App\Partner;
use App\Candidate;
use Carbon\Carbon;
use App\Department;
use App\Expository;
use App\CandidateMark;
use App\BatchAssessment;
use App\JobQualification;
use App\Helpers\AppHelper;
use App\CenterCandidateMap;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminHomeController extends Controller
{
    
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('admin');
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    public function profile(){
        $admin = $this->guard()->user();
        return view('common.profile')->with(compact('admin'));
    }

    public function profile_update(Request $request){


        $admin = $this->guard()->user();
        if ($admin->name == $request->name && $admin->email == $request->email && is_null($request->password)) {
            alert()->info("You Have not changed any value", 'Abort')->autoclose(3000);
            return redirect()->back();
        } else {
            $request->validate([
                'name' => 'required', 
                'password' => 'nullable',
                'email' => [
                    'required',
                    'email',
                    'unique:admins,email,'.$this->guard()->user()->id,
                    'unique:partners,email',
                    'unique:centers,email',
                    'unique:trainer_statuses,email',
                    'unique:agencies,email',
                    'unique:assessors,email',
                    'unique:candidates,email',
                ],
            ]);
            if (!is_null($request->password)) {
                $admin->password =  Hash::make($request->password);
            }
            $admin->name = $request->name;
            $admin->email = $request->email;
            $admin->save();
            
            alert()->success("Your <span style='color:blue'>Profile</span> has been <span style='color:blue'>Updated</span>",'Awesome')->html()->autoclose('4000');
            return redirect()->back();
        }

    }


    public function dashboard(){

        $test=[
            'period'=> '2011',
            'Project1'=> 0,
            'Project2'=> 0,
            'Project3'=> 115
        
        
    ];

    $data = [ 
        'partners' => Partner::all(),
        'centers' => Center::all(),
        'candidates' => Candidate::all(),
       
    ];
    $test=json_encode($test);
    $rr=array();
    $rr[0]=$test;
    
      

    //         $chart = [ 
    //             'partners' => Partner::where('pending_verify',0)->get(),
    //             'centers' => Center::where('verified',1)->get(),
    //             'candidates' => CenterCandidateMap::all(),
            
    //         ];
    //     $fyear =( date('m') > 3) ? date('Y') : (date('Y')-1);
    //     // $fyear1 =( date('m') > 3) ? date('y').'-'.(date('y')+1) : (date('y')-1).'-'.date('y');
    //     // dd($fyear1);
    //     $res=$res1=$res2=[];
       
        
    //    foreach ($chart as $key => $query) {
          
       
        
    //     // $query = DB::table('partners')
    //     //  ->select(\DB::raw('SUBSTRING(tp_id,3,4) as tp_id'))
    //     // ->groupBy(DB::raw('MONTH(created_at)'))
    //     // ->where(DB::raw('SUBSTRING(tp_id,3,4)'), '=', $fyear)
    //     // ->select('created_at', DB::raw('count(*) as total'),DB::raw('MONTHNAME(created_at) as month'))
    //     // ->get();
    //     $apr=$may=$jun=$jul=$aug=$sep=$oct=$nov=$dec=$jan=$feb=$mar=0;
    //     foreach ($query as $value) {
    //         if(Carbon::parse($value->created_at)->format('m')>3){
    //             $fyr=Carbon::parse($value->created_at)->format('Y');
    //         }else{
    //             $fyr=(Carbon::parse($value->created_at)->format('Y')-1);

    //         }

    //         if($fyear==$fyr){
    //             switch (Carbon::parse($value->created_at)->format('m')) {
    //                 case 4:
    //                     $apr=$apr+1;
    //                     break;
    //                 case 5:
    //                     $may=$may+1;
    //                     break;
    //                 case 6:
    //                     $jun=$jun+1;
    //                     break;
    //                 case 7:
    //                     $jul=$jul+1;
    //                     break;
    //                 case 8:
    //                     $aug=$aug+1;
    //                     break;
    //                 case 9:
    //                     $sep=$sep+1;
    //                     break;
    //                 case 10:
    //                     $oct=$oct+1;
    //                     break;
    //                 case 11:
    //                     $nov=$nov+1;
    //                     break;
    //                 case 12:
    //                     $dec=$dec+1;
    //                     break;
    //                 case 1:
    //                     $jan=$jan+1;
    //                     break;
    //                 case 2:
    //                     $feb=$feb+1;
    //                     break;
    //                 case 3:
    //                     $mar=$mar+1;
    //                     break;
    //                 }  
    //             }
    //         }
    //         if($key=='partners'){
    //             $res=[$apr,$may,$jun,$jul,$aug,$sep,$oct,$nov,$dec,$jan,$feb,$mar];
    //         }else if($key=='centers'){
    //             $res1=[$apr,$may,$jun,$jul,$aug,$sep,$oct,$nov,$dec,$jan,$feb,$mar];

    //         }else if($key=='candidates'){
    //             $res2=[$apr,$may,$jun,$jul,$aug,$sep,$oct,$nov,$dec,$jan,$feb,$mar];

    //         }
    //     }

        // Start New portion Graph
        $finyear =( date('m') > 3) ? date('y')."-".(date('y') + 1) : (date('y')-1)."-".date('y');
        $res=$res1=$res2=[];
        $mnarr=["April", "May", "June", "July","August","September","October","November","December","January","February","March"];
        foreach ($mnarr as $key => $month) {
            $prtnr=Partner::select(DB::raw('count(*) as total'))->where([['pending_verify','=',0],['f_month','=',$month],['f_year','=',$finyear]])->first();
            $cntr=Center::select(DB::raw('count(*) as total'))->where([['verified','=',1],['f_month','=',$month],['f_year','=',$finyear]])->first();
            $candidate=CenterCandidateMap::select(DB::raw('count(*) as total'))->where([['f_month','=',$month],['f_year','=',$finyear]])->first();
            array_push($res,$prtnr->total);
            array_push($res1,$cntr->total);
            array_push($res2,$candidate->total);
        
        }
        
        //End New Portion Graph

        $states=DB::table('state_district')->groupBy('state')->get();
        $stack = array();
        foreach ($states as $key => $state) {
            $tp_count=$tc_count=$aa_count=$can_count=0;
        $st_dist_id=DB::table('state_district')->select('id')->where('state','=',$state->state)->get();

        foreach ($st_dist_id as  $ids) {
            $partner=Partner::where([['state_district','=',$ids->id],['pending_verify','=',0]])->get();
            $center=Center::where([['state_district','=',$ids->id],['verified','=',1]])->get();
            $agency=Agency::where('state_district',$ids->id)->get();
            $candidate=CenterCandidateMap::where('state_district',$ids->id)->get();
            $tp_count=$tp_count+ count($partner);
            $tc_count=$tc_count+ count($center);
            $aa_count=$aa_count+ count($agency);
            $can_count=$can_count+ count($candidate);
        }
        
        $stack[$state->state]=[$tp_count,$tc_count,$aa_count,$can_count];
        }

        $tc_number=Center::select(DB::raw('count(*) as total'))->where([['f_year','=',$finyear],['status','=',1],['verified','=',1]])->first();
        $tp_number=Partner::select(DB::raw('count(*) as total'))->where([['f_year','=',$finyear],['status','=',1],['complete_profile','=',1],['pending_verify','=',0]])->first();
        
        $exams=BatchAssessment::where('f_year','=',$finyear)->get();
        $can_pass=$can_fail=0;
        foreach ($exams as $exam) {
            foreach ($exam->candidateMarks as  $candidate) {
                if($candidate->passed){
                    $can_pass=$can_pass+1; 
                }else{
                    $can_fail=$can_fail+1;  
                }
            }
            
        }
        

        $conclu=[$tc_number->total,$tp_number->total,count($exams),$can_pass,$can_fail];
        
       
        return view('admin.home')->with($data)->with($rr)->with(compact('res','res1','res2','stack','conclu','mnarr','finyear'));
    }
    
    public function job_roles(){

        $sectors = Sector::all();
        $expositories = Expository::all();
        $jobroles = JobRole::all();
        return view('admin.dashboard.jobroles')->with(compact('sectors','expositories','jobroles'));
    }
    
    public function job_roles_action(Request $request){
        if ($request->has('sector')) {
            return $this->dispatchNow(new \App\Jobs\AddSector($request));
        } else if ($request->has('sector_id')) {
            return $this->dispatchNow(new \App\Jobs\AddJobRole($request));
        } else if ($request->has('expository')) {
            return $this->dispatchNow(new \App\Jobs\AddExpository($request));
        } else if ($request->has('section')) {
            switch ($request->section) {
                case 'Sector':
                    return $this->dispatchNow(new \App\Jobs\RemoveSector($request));
                break;
                case 'Expository':
                    return $this->dispatchNow(new \App\Jobs\RemoveExpository($request));
                break;
                case 'JobRole':
                    return $this->dispatchNow(new \App\Jobs\RemoveJobRole($request));
                break;    
                case 'JobQualification':
                    return $this->dispatchNow(new \App\Jobs\RemoveJobQualification($request));
                break;    
                default:
                    return abort(404);
                    break;
            }
        }
        return abort(404);
    }


    public function jobroleQualification(Request $request){

        if ($id=AppHelper::instance()->decryptThis($request->data)) { 
            $jobrole = JobRole::findOrFail($id);   
            $qualificationRow = [[]];
            $qualificationArray = [];
            foreach ($jobrole->qualifications as $qualification) {
                $qualificationRow[0] = $qualification->qualification;
                $qualificationRow[1] = $qualification->sector_exp;
                $qualificationRow[2] = $qualification->teaching_exp;
                $qualificationRow[3] = '<form id="removeform_JobQualification_'.$qualification->id.'" action="#" method="post"> <input type="hidden" name="data" value="'.$qualification->id.','.$qualification->qualification.'"><button type="submit" class="btn btn-simple btn-danger btn-icon btn-icon-mini btn-round"><i class="zmdi zmdi-delete"></button></form>';
                // $qualificationRow[3] = '<button type="button" onclick="popup(\''.Crypt::encrypt($qualification->id).',job'.'\')" class="btn btn-simple btn-danger btn-icon btn-icon-mini btn-round"><i class="zmdi zmdi-delete"></button>';
                array_push($qualificationArray, $qualificationRow);
            }
            return response()->json(['success' => true, 'qualifications' => $qualificationArray],200);
        }
    }

    public function jobroleAddQualification(Request $request)
    {
        $request->validate([
            'jobid' => 'required',
            'qualification' => 'required',
            'sector_exp' => 'required',
            'teaching_exp' => 'required',
        ]);

        if ($id=AppHelper::instance()->decryptThis($request->jobid)) {
            $job = JobQualification::where([['job_id',$id],['qualification',$request->qualification]])->first();
            if ($job) {
                alert()->error("This Qualification Details already <span style='color:red;'>Persent</span> for This Jobrole", "Aborted")->html()->autoclose(4000);
                return redirect()->back();
            } else {
                $job = new jobQualification;
                $job->job_id = $id;
                $job->qualification = $request->qualification;
                $job->sector_exp = $request->sector_exp;
                $job->teaching_exp = $request->teaching_exp;
                $job->save();
                alert()->success("Qualification Details are <span style='color:blue;'>Added</span> to the Jobrole", "Job Done")->html()->autoclose(4000);
                return redirect()->back();
            }
            
        }
    }


    public function scheme(){
        $schemes = Scheme::all();
        $departments = Department::all();
        return view('admin.dashboard.scheme')->with(compact('schemes','departments'));
    }

    public function scheme_action(Request $request){
        if ($request->has('scheme')) {
            return $this->dispatchNow(new \App\Jobs\AddScheme($request));
        } else if ($request->has('name') || $request->has('id')) {
            return $this->dispatchNow(new \App\Jobs\UpdateScheme($request));
        }
    }

    public function holiday(){
        $holidays = Holiday::all();
        return view('admin.dashboard.holiday')->with(compact('holidays'));
    }
    public function holidayInsert(Request $request){
        
        $holiday = new Holiday;
        $holiday->holiday_name=$request->holiday_name;
        $holiday->holiday_date=$request->holiday_date;
        $holiday->save();
        alert()->success("Holiday Added <span style='color:blue;'>Successfully</span>", "Done")->html()->autoclose(4000);
        return Redirect()->back();
        
    }

    public function holidayDelete(Request $request){
        $data=Holiday::findOrFail($request->id);
        $data->delete();
        return response()->json(['status' => 'done'],200);
    }

    public function department(){
        $departments = Department::all();
        return view('admin.dashboard.department')->with(compact('departments')); 
    }

    public function departmentInsert(Request $request){
        
        $department = new Department;
        $department->dept_name=$request->dept_name;
        $department->dept_address=$request->dept_address;
        $department->save();
        alert()->success("Department Added <span style='color:blue;'>Successfully</span>", "Done")->html()->autoclose(4000);
        return Redirect()->back();
    }

    public function departmentDelete(Request $request){
        $data=Department::findOrFail($request->id);
       $scheme=Scheme::where('dept_id',$request->id)->first();
        if(!is_null($scheme)){
            return response()->json(['status' => 'fail'],200);

        }else{
            $data->delete();
            return response()->json(['status' => 'done'],200);

        }
    }
}
