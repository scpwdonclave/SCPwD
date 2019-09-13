<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use App\Expository;


class UpdateExpository implements ShouldQueue
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
        
        $expository = Expository::find($request->id);
        if ($expository) {
            $expository->status = !$expository->status;
            $expository->save();
            return response()->json(array('type' => 'success', 'message' => "Status has been Updated of <br><span style='font-weight:bold;color:blue'>$request->name</span>"),200);
        } else {
            return response()->json(array('type' => 'error', 'message' => "<span style='font-weight:bold;color:red'>$request->name</span> Expository is not Found"),200);
        }

    }
}
