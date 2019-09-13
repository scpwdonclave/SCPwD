<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use App\Expository;

class AddExpository implements ShouldQueue
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
            'expository' => 'required|unique:expositories',
            'initials' => 'required|unique:expositories',
        ]);
        $count = Expository::count();    
        $initial_name = 'E'.sprintf('%03d', ($count+1)).' - ';
        $expository = new Expository;
        $expository->expository = $initial_name.ucwords(strtolower($request->expository));
        $expository->initials = strtoupper($request->initials);
        $expository->save();
        alert()->success('Expository <span style="color:blue">'.$expository->expository.'</span> has been Created Successfully','New Entry')->html()->autoclose('4000');
        return redirect()->back();
    }
}
