<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use App\Sector;

class RemoveSector implements ShouldQueue
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
        $sector = Sector::find($request->id);
        if ($sector) {

            // if (count($sector->job_roles) == 0) {
                $sector->delete();
                return response()->json(array('type' => 'success', 'message' => "Sector <span style='font-weight:bold;color:blue'>$request->name</span> has been Removed Successfully"),200);
            // } else {
            //     return response()->json(array('type' => 'error', 'message' => "You cannot <span style='font-weight:bold;color:red'>Remove</span> any Sector while its associated with some Job Roles"),200);
            // }
            
        
        } else {
            return response()->json(array('type' => 'error', 'message' => "<span style='font-weight:bold;color:red'>$request->name</span> Sector is not Found"),200);
        }      
    }
}
