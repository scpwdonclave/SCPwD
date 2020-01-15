<?php

namespace App\Jobs;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use App\Scheme;
use Crypt;
use DB;


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

    protected function decryptThis($id){
        try {
            return Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(array('type' => 'error', 'message' => "Something went Wrong"),400);
        }
    }
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Request $request)
    {
        if ($request->has('name')) {
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
        } else {
            $request->validate([
                'id' => 'required',
            ]);
            if ($id=$this->decryptThis($request->id)) {
                $scheme = Scheme::find($id);
                if ($scheme) {
    
                    DB::transaction(function() use($scheme){
                        $scheme->status = !$scheme->status;
                        $scheme->save();
                        
                        foreach ($scheme->partners as $partnerJob) {
                            if (!$partnerJob->direct_action) {
                                $partnerJob->status = $scheme->status;
                                $partnerJob->save();
                            }
                        }
                    });

                    return response()->json(array('type' => 'success', 'message' => "Scheme has been <span style='font-weight:bold;color:blue'>Updated</span> Successfully"),200);
                    
                } else {
                    return response()->json(array('type' => 'error', 'message' => "Requested Scheme is not Found"),200);
                }
            }
        }
    }
}
