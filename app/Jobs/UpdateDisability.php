<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use App\Disability;


class UpdateDisability implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
   
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
        
        $disability = Disability::find($request->id);
        if ($disability) {
            $disability->status = !$disability->status;
            $disability->save();
            return response()->json(array('type' => 'success', 'message' => "Status has been Updated of <br><span style='font-weight:bold;color:blue'>$request->name</span>"),200);
        } else {
            return response()->json(array('type' => 'error', 'message' => "<span style='font-weight:bold;color:red'>$request->name</span> Disability is not Found"),200);
        }

    }
}
