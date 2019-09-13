<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use App\QP;

class AddQP implements ShouldQueue
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
            'qp_name' => 'required|unique:q_p_s',
            'qp_code' => 'required|unique:q_p_s',
            'nsqf_level' => 'required|numeric',
        ]);

        $qp = new QP;
        $qp->qp_name = $request->qp_name;
        $qp->qp_code = $request->qp_code;
        $qp->nsqf_level = $request->nsqf_level;
        $qp->save();

        alert()->success('QP Record <span style="color:blue">'.$request->qp_name.'</span> has been Created Successfully','New Entry')->html()->autoclose('4000');
        return redirect()->back();

    }
}
