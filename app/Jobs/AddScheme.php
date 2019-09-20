<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use App\Scheme;

class AddScheme implements ShouldQueue
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
            'scheme' => 'required|unique:schemes',
            'year' => 'required',
        ]);

        $scheme = new Scheme;
        $scheme->scheme = $request->scheme;
        $scheme->year = $request->year;
        $scheme->save();

        alert()->success('Scheme <span style="color:blue">'.$request->scheme.'</span> has been Added Successfully','New Entry')->html()->autoclose('4000');
        return redirect()->back();
    }
}
