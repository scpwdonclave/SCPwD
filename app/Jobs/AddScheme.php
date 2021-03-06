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
            'dummy' => 'nullable|mimes:jpeg,jpg,png,pdf|max:5120',
            'year' => 'required',
            'disability' => 'required',
            'invoice_on' => 'required',
            'finyear' => 'required',
            'cert_format' => 'required',
        ]);

        
        $scheme = new Scheme;
        $scheme->scheme = $request->scheme;
        if ($request->has('dummy')) {
            $scheme->dummy = Storage::disk('myDisk')->put('/adminscheme', $request->dummy);
        }
        $scheme->dept_id = $request->dept;
        $scheme->invoice_on = $request->invoice_on;
        $scheme->disability = $request->disability;
        $scheme->cert_format = $request->cert_format.'/';
        $scheme->fin_yr = $request->finyear;
        $scheme->year = $request->year;
        $scheme->save();

        alert()->success('Scheme <span style="color:blue">'.$request->scheme.'</span> has been Added Successfully','New Entry')->html()->autoclose('4000');
        return redirect()->back();
    }
}
