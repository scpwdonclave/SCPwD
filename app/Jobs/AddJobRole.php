<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use DB;

class AddJobRole implements ShouldQueue
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
        // dd($request);
        $request->validate([
            'sector_role' => 'required|numeric',
            'qp_role' => 'required|numeric',
            'expository_role' => 'required|array',
        ]);

        foreach ($request->expository_role as $role) {
            $count = DB::table('expo_qp_sector')->select('*')->where([['sector_id', '=', $request->sector_role],['qp_id', '=',$request->qp_role],['expo_id', '=',$role]])->count();
            if ($count > 0) {
                alert()->error('Oparation Aborted, Please Provide Unique Combinations','Duplicate Entry')->html()->autoclose('4000');
                return redirect()->back();
            }
        }
        
        foreach ($request->expository_role as $role) {
            DB::table('expo_qp_sector')->insert([
                ['sector_id' => $request->sector_role, 'qp_id' => $request->qp_role, 'expo_id' => $role],
            ]);
        }

        alert()->success('Job Role(s) <span style="color:blue">Added</span> Successfully','New Entry')->html()->autoclose('4000');
        return redirect()->back();
    }
}
