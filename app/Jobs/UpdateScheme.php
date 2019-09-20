<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use App\Scheme;

class UpdateScheme implements ShouldQueue
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
            'value' => 'required',
        ]);
        
        $scheme = Scheme::find($request->id);
        if ($scheme) {

            $scheme->scheme = $request->value;
            $scheme->save();
            return response()->json(array('type' => 'success', 'message' => "Scheme has been <span style='font-weight:bold;color:blue'>Updated</span> Successfully"),200);
            
        } else {
            return response()->json(array('type' => 'error', 'message' => "<span style='font-weight:bold;color:red'>$request->name</span> Scheme is not Found"),200);
        }
    }
}
