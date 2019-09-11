<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
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
            'role_disability' => 'array|required'
        ]);
        
        $jobrole = new JobRole;
        $jobrole->sector_id = $request->sector_id;
        $jobrole->job_role = $request->job_role;
        $jobrole->qp_code = $request->qp_code;
        $jobrole->nsqf_level = $request->nsqf_level;
        $jobrole->save();

        $jobrole->disabilities()->sync($request->role_disability);

        alert()->success('Job Role <span style="color:blue">'.$jobrole->job_role.'</span> has been Created Successfully','New Entry')->html()->autoclose('4000');
        return redirect()->back();
    }
}
