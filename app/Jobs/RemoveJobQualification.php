<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use App\JobQualification;

class RemoveJobQualification implements ShouldQueue
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
            'id' => 'required',
            'name' => 'required',
        ]);
        
        $qualification = JobQualification::find($request->id);
        if ($qualification) {
            if (count($qualification->job->qualifications) > 1) {
                $qualification->delete();
                return response()->json(array('type' => 'success', 'message' => "Job Qualification Record of <span style='font-weight:bold;color:blue'>$request->name</span> has been Removed"),200);
            } else {
                return response()->json(array('type' => 'info', 'message' => "This Jobrole does not have any other <span style='font-weight:bold;color:blue'>Qualification Record</span> rather than This, So Cannot Proceed Further"),200);
            }
        } else {
            return response()->json(array('type' => 'error', 'message' => "<span style='font-weight:bold;color:red'>$request->name</span> Qualification Record is not Found"),200);
        }
    }
}
