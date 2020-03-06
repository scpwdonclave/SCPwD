<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\CenterCandidateMap;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ReleaseCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:release';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Release Candidates for Re-Register after [Assessment or Re-Assessment]';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $centerCandidates = CenterCandidateMap::where([['dropout',0],['passed',0],['reassessed','!=',0]])->orWhere([['dropout',0],['passed',2],['reassessed','!=',0]])->get();
        foreach ($centerCandidates as $centerCandidate) {
            if ($centerCandidate->batchcandidate->batch->batchreassessmentlatest) {
                // * Candidate has given ReAssessment
                $date_peak = Carbon::parse($centerCandidate->batchcandidate->batch->batchreassessmentlatest->sup_admin_verified_on)->addDays(90);
            } elseif ($centerCandidate->batchcandidate->batch->batchassessment) {
                // * Candidate has given Assessment
                $date_peak = Carbon::parse($centerCandidate->batchcandidate->batch->batchassessment->sup_admin_verified_on)->addDays(90);
            }
            if ($date_peak<Carbon::now()) {
                // * Candidate is Released
                $centerCandidate->reassessed = 0;
                $centerCandidate->save();
            }
        }
        Log::channel('cronlog')->info("Release Cron is working fine! Cron Hit at ".Carbon::now()." IST");
    }
}
