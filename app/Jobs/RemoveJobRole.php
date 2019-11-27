<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use App\JobRole;

class RemoveJobRole implements ShouldQueue
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
        
        $jobrole = JobRole::find($request->id);
        if ($jobrole) {
            if (count($jobrole->partners) > 0) {
                return response()->json(array('type' => 'error', 'message' => "You cannot <span style='font-weight:bold;color:red'>Remove</span> a Job Role while its associated with Training Partners"),200);
            } else {
                $jobrole->delete();
                return response()->json(array('type' => 'success', 'message' => "Job Role <span style='font-weight:bold;color:blue'>$request->name</span> has been Removed Successfully"),200);
            }
        } else {
            return response()->json(array('type' => 'error', 'message' => "<span style='font-weight:bold;color:red'>$request->name</span> Expository is not Found"),200);
        }
    }
}
