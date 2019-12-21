<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use App\Scheme;
use Storage;

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
            'logo' => 'required|mimes:jpeg,jpg,png',
            'year' => 'required',
            'finyear' => 'required',
            'cert_format' => 'required',
        ]);

        // dd($request);

        $scheme = new Scheme;
        $scheme->scheme = $request->scheme;
        $scheme->logo = Storage::disk('public')->put('/adminscheme', $request->logo);
        $scheme->year = $request->year;
        $scheme->cert_format = $request->cert_format.'/';
        $scheme->fin_yr = $request->finyear;
        $scheme->save();

        alert()->success('Scheme <span style="color:blue">'.$request->scheme.'</span> has been Added Successfully','New Entry')->html()->autoclose('4000');
        return redirect()->back();
    }
}
