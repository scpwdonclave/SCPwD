<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Sector;

class AddSector implements ShouldQueue
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

        $valid = Validator::make($request->all(), [
            'sector' => [
                'required',
                'unique:sectors'
            ],
        ]);
    
        if ($valid->fails()) {
            alert()->error('<span style="color:blue">'.$request->sector.'</span> Sector Already exists in Database','Dupicate Entry')->html()->autoclose('4000');
            return redirect()->back();    
        }
        
        $sector = new Sector;
        $sector->sector = $request->sector;
        $sector->save();
        alert()->success('<span style="color:blue">'.$request->sector.'</span> Sector Added Successfully','New Entry')->html()->autoclose('4000');
        return redirect()->back();
    }
}
