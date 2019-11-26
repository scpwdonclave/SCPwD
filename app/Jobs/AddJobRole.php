<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use App\JobQualification;
use App\JobRole;

class AddJobRole implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Request $request)
    {
        $request->validate([
            'sector_id' => 'required',
            'job_role' => 'required|unique:job_roles',
            'qp_code' => 'required|unique:job_roles',
            'nsqf_level' => 'required|numeric',
            'hours' => 'required|numeric',
            'qualification' => 'required',
            'sector_exp' => 'required|numeric',
            'teaching_exp' => 'required|numeric',
            'role_expository' => 'array|required',
        ]);
        
        $jobrole = new JobRole;
        $jobrole->sector_id = $request->sector_id;
        $jobrole->job_role = $request->job_role;
        $jobrole->qp_code = $request->qp_code;
        $jobrole->nsqf_level = $request->nsqf_level;
        $jobrole->hours = $request->hours;
        $jobrole->save();

        $jobquilification = new JobQualification;
        $jobquilification->job_id = $jobrole->id;
        $jobquilification->qualification = $request->qualification;
        $jobquilification->sector_exp = $request->sector_exp;
        $jobquilification->teaching_exp = $request->teaching_exp;
        $jobquilification->save();

        $jobrole->expositories()->sync($request->role_expository);

        alert()->success('Job Role <span style="color:blue">'.$jobrole->job_role.'</span> has been Created Successfully','New Entry')->html()->autoclose('4000');
        return redirect()->back();
    }
}
