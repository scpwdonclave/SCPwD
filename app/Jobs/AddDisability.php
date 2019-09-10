<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use App\Disability;

class AddDisability implements ShouldQueue
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
            'disability' => 'required|unique:disabilities',
            'initials' => 'required|unique:disabilities',
        ]);
        
        $disability = new Disability;
        $disability->disability = ucwords(strtolower($request->disability));
        $disability->initials = strtoupper($request->initials);
        $disability->save();

        alert()->success('Disability <span style="color:blue">Added</span> Successfully','New Entry')->html()->autoclose('4000');
        return redirect()->back();
    }
}
