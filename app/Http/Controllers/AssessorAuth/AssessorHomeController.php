<?php

namespace App\Http\Controllers\AssessorAuth;

use Auth;
use Carbon\Carbon;

use App\Notification;
use App\Helpers\AppHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AssessorHomeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['assessor','prevent-back-history']);
    }

    protected function guard()
    {
        return Auth::guard('assessor');
    }

    public function notifications()
    {
        $notifications = Notification::where([['rel_with','assessor'],['rel_id',$this->guard()->user()->id]])->get();
        return view('common.notifications')->with(compact('notifications'));
    }

    public function clearNotifications(Request $request)
    {   
        $request->validate([
            'dismiss'=>'required',
        ]);

        $notifications = Notification::where([['rel_with','assessor'],['rel_id',$this->guard()->user()->id],['read',0]])->get();
        
        foreach ($notifications as $notification) {
            $notification->read=1;
            $notification->read_by = $this->guard()->user()->name;
            $notification->save();
        }

        return response()->json(['success' => true],200);
    }
    
    public function clickNotification($id)
    {  
        if ($id=AppHelper::instance()->decryptThis($id)) {
            $notification = Notification::findOrFail($id);
            if ($notification->rel_with === 'assessor' && $this->guard()->user()->id == $notification->rel_id) {
                if (!$notification->read) {
                    if (is_null($notification->url)) {
                        $route = redirect()->back();
                    } else {
                        $route = redirect($notification->url);
                    }
                    $notification->read_by = $this->guard()->user()->name;
                    $notification->read = 1;
                    $notification->save();
                    return $route;
                }
            }
        }
    }
    
    public function index() {

        $assessor = $this->guard()->user();
        
        $absent = 0;
        $failed = 0;
        $passed = 0;

        $assessed = 0;
        $assessment = 0;
        $reassessment = 0;


        foreach ($assessor->assessorBatch as $assessorBatch) {
            if (is_null($assessorBatch->reass_id)) {
                if (!is_null($assessorBatch->batch->assessment) && Carbon::parse($assessorBatch->batch->assessment) < Carbon::now()) {
                    $assessed+=count($assessorBatch->batch->candidatesmap);
                }
                if ($assessorBatch->batch->batchassessment) {
                    foreach ($assessorBatch->batch->batchassessment->candidateMarks as $candidateMark) {
                        if ($candidateMark->attendence==='present') {
                            if ($candidateMark->passed==1) {
                                $passed+=1;
                            } elseif ($candidateMark->passed==0){
                                $failed+=1;
                            }
                        } else {
                            $absent+=1;
                        }
                    }
                }
                $assessment+=1;
            } else {
                if (!is_null($assessorBatch->reassessment->assessment) && Carbon::parse($assessorBatch->reassessment->assessment) < Carbon::now()) {
                    $assessed+=count($assessorBatch->reassessment->candidates);
                }
                if ($assessorBatch->reassessment->batchreassessment) {
                    // $candidate += count($assessorBatch->reassessment->batchreassessment->candidateMarks)
                    foreach ($assessorBatch->reassessment->batchreassessment->candidateMarks as $candidateMark) {
                        if ($candidateMark->attendence==='present') {
                            if ($candidateMark->passed==1) {
                                $passed+=1;
                            } elseif ($candidateMark->passed==0){
                                $failed+=1;
                            }
                        } else {
                            $absent+=1;
                        }
                    }
                }
                $reassessment+=1;
            }
        }
        


        $data = [
            'assessor'=>$assessor,
            
            'failed'=>$failed,
            'absent'=>$absent,
            'passed'=>$passed,
            
            'assessed'=>$assessed,
            'assessment'=>$assessment,
            'reassessment'=>$reassessment,
        ];

        return view('assessor.home')->with($data);
    }

    public function profile(){
        $assessor = Auth::guard('assessor')->user();
        return view('common.profile')->with(compact('assessor'));
    }

    public function profile_update(Request $request){
        $request->validate([
            'password' => 'required',
        ]);

        $assessor = $this->guard()->user();
        $assessor->password = Hash::make($request->password);
        $assessor->save();

        alert()->success("Your <span style='font-weight:bold;color:blue'>Password</span> has been <span style='font-weight:bold;color:blue'>Updated</span>", 'Job Done')->html()->autoclose(4000);
        return redirect()->back();
    }

}
