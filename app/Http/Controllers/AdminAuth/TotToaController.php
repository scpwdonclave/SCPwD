<?php

namespace App\Http\Controllers\AdminAuth;

use PDF;
use Validator;
use App\Scheme;
use App\TotBatch;
use Carbon\Carbon;
use App\Expository;
use App\AssessmentTrainer;
use App\Helpers\AppHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\TotBatchAssessmentTrainerMap;

class TotToaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['admin','prevent-back-history']);
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    public function totBatches()
    {
        $data = [
            'tag' => 'tot',
            'records' => TotBatch::all()
        ];
        return view('admin.tot-toa.batches')->with($data);
    }

    public function submitTotBatches(Request $request)
    {
        $last_bid=DB::select("SELECT MAX(SUBSTRING(batch_id,11)) AS b_id FROM `tot_batches`");
        
        $b_id = $last_bid[0]->b_id?$last_bid[0]->b_id+1:43;

        $totbatch = new TotBatch;
        $totbatch->batch_id = 'SCPwD-TOT-'.$b_id;
        $totbatch->batch_start = Carbon::parse($request->start)->format('Y-m-d');
        $totbatch->batch_end = Carbon::parse($request->end)->format('Y-m-d');
        $totbatch->save();

        
        if ($request->has('new_records')) {
            foreach ($request->new_records as $data) {
                $trainer = AssessmentTrainer::select('doc_no','trainer_category','tp_name')->where('id',$data)->first();
                //! Need to fix here first
                if ($trainer->trainer_category) {
                    // Master Trainer
                    $last_bttotid=DB::select("SELECT MAX(SUBSTRING(bt_tot_id,19)) AS bttot_id FROM `tot_batch_assessment_trainer_maps` WHERE bt_tot_id LIKE '%/ToMT-%'");
                    $bttot_id = 'PWD/'.Carbon::parse($totbatch->batch_end)->format('dmY').'/ToMT-'.($last_bttotid[0]->bttot_id?$last_bttotid[0]->bttot_id+1:1);
                } else {
                    // Trainer
                    $last_bttotid=DB::select("SELECT MAX(SUBSTRING(bt_tot_id,16)) AS bttot_id FROM `tot_batch_assessment_trainer_maps` WHERE bt_tot_id LIKE '%/T-%'");
                    $bttot_id = 'PWD/'.Carbon::parse($totbatch->batch_end)->format('dmY').'/T-'.($last_bttotid[0]->bttot_id?$last_bttotid[0]->bttot_id+1:1061);
                }
                $tbtr_map = new TotBatchAssessmentTrainerMap;
                $tbtr_map->bt_id = $totbatch->id;
                $tbtr_map->tr_id = $data;
                $tbtr_map->doc_no = $trainer->doc_no;
                $tbtr_map->tp_name = $trainer->tp_name;
                $tbtr_map->bt_tot_id = $bttot_id;
                $tbtr_map->save();
            }
        }
        if ($request->has('renewals')) {
            foreach ($request->renewals as $data) {
                $trainer = AssessmentTrainer::select('id','doc_no','tp_name')->where('id',$data)->first();
                //! Need to fix here first
                // Master Trainer And Trainer
                $last_bttotid=DB::select("SELECT MAX(id) AS id, SUBSTRING(bt_tot_id,14) AS bttot_id FROM `tot_batch_assessment_trainer_maps` WHERE tr_id='$trainer->id'");
                $bttot_id = 'PWD/'.Carbon::parse($totbatch->batch_end)->format('dmY').'/'.$last_bttotid[0]->bttot_id;
                
                $tbtr_map = new TotBatchAssessmentTrainerMap;
                $tbtr_map->bt_id = $totbatch->id;
                $tbtr_map->tr_id = $data;
                $tbtr_map->doc_no = $trainer->doc_no;
                $tbtr_map->tp_name = $trainer->tp_name;
                $tbtr_map->bt_tot_id = $bttot_id;
                $tbtr_map->save();
            }
        }

        alert()->success('Batch has been <span style="color:blue">Created</span> with provided details', 'Job Done')->html()->autoclose(4000);
        return redirect()->back();
    }

    public function addTotMarks(Request $request)
    {
        if ($id=AppHelper::instance()->decryptThis($request->id)) {
            $batchData = TotBatch::findOrFail($id);
            if (is_null($batchData->trainers[0]->percentage)) {
                return view('admin.tot-toa.add-marks')->with(compact('batchData'));
            }
            return abort(403,'This action is not permitted');
        }
    }

    public function submitTotMarks(Request $request)
    {
        $totBatch = TotBatch::findOrFail($request->bt_id);

        foreach ($totBatch->trainers as $batchMap) {

            $percentage = $request->mark[$batchMap->tr_id][0];

            if ((int)$percentage >= 90) {
                $grade = $batchMap->trainer->trainer_category?'Pass':'A';
                $validity = Carbon::parse($totBatch->batch_end)->addYear(2)->format('Y-m-d');
            } elseif ((int)$percentage < 90 && (int)$percentage >= 80) {
                $grade = 'B';
                $validity = Carbon::parse($totBatch->batch_end)->addYear(1)->format('Y-m-d');
            } elseif ((int)$percentage < 80 && (int)$percentage >= 70 && !$batchMap->trainer->trainer_category) {
                $grade = 'Provisionally Pass';
                $validity = Carbon::parse($totBatch->batch_end)->addMonth(6)->format('Y-m-d');
            } else {
                $grade = NULL;
                $validity = NULL;
            }

            if (is_null($grade)) {
                $q_id = NULL;
                $digital_key = NULL;
            } else {
                if ($batchMap->trainer->trainer_category) {
                    //Master Trainer
                    $last_qid=DB::select("SELECT MAX(SUBSTRING(qr_id,12)) AS q_id FROM `tot_batch_assessment_trainer_maps` WHERE qr_id LIKE '%/ToMT/%'");
                    $q_id = 'SCPwD/ToMT/'.($last_qid[0]->q_id?$last_qid[0]->q_id+1:1);
                    $digital_key = rand(10,99).$batchMap->id.time();
                } else {
                    //Trainer
                    $last_qid=DB::select("SELECT MAX(SUBSTRING(qr_id,9)) AS q_id FROM `tot_batch_assessment_trainer_maps` WHERE qr_id LIKE '%/T/%'");
                    $q_id = 'SCPwD/T/'.($last_qid[0]->q_id?$last_qid[0]->q_id+1:771);
                    $digital_key = rand(10,99).$batchMap->id.time();
                }
            }
        }
            
        $batchMap->update(['qr_id'=>$q_id,'digital_key'=>$digital_key,'percentage'=>$percentage,'grade'=>$grade, 'validity'=>$validity]);

        alert()->success('Batch Marks has been <span style="color:blue">Updated</span>','Job Done')->html()->autoclose(5000);
        return redirect()->route('admin.tot-toa.tot-batches');
    }


    public function viewTotBatch(Request $request)
    {
        if ($id=AppHelper::instance()->decryptThis($request->id)) {
            $batchData = TotBatch::findOrFail($id);
            if ($batchData->trainers->count()) {
                return view('admin.tot-toa.view-batch')->with(compact('batchData'));
            }
            return abort(403,'This action is not permitted');
        }
    }


    public function toaBatches()
    {
        $data = [
            'tag' => 'toa',
            'records' => collect()
        ];
        return view('admin.tot-toa.batches')->with($data);
    }

    public function trainers()
    {
        $today = Carbon::now()->format('Y-m-d');
        // $tots = AssessmentTrainer::select(DB::raw('doc_no, max(id) as id, name, contact, tp_name'))->groupBy('doc_no')->get();
        $tots=AssessmentTrainer::whereIn('id',AssessmentTrainer::select(DB::raw('max(id) as id'))->groupBy('doc_no')->get()->pluck('id')->toArray())->get();
        
        $schemes = Scheme::all();
        $expired = DB::select("SELECT asat.id, asat.name, asat.tp_name, asat.doc_no, asat.trainer_category FROM `tot_batch_assessment_trainer_maps` AS tbatm INNER JOIN `assessment_trainers` AS asat ON tbatm.tr_id = asat.id WHERE tbatm.id IN (SELECT tbm1.id FROM `assessment_trainers` AS ass LEFT JOIN `tot_batch_assessment_trainer_maps` AS tbm1 ON (ass.id = tbm1.tr_id) LEFT OUTER JOIN `tot_batch_assessment_trainer_maps` AS tbm2 ON (ass.doc_no = tbm2.doc_no AND (tbm1.id < tbm2.id)) WHERE tbm2.id IS NULL AND tbm1.id NOT IN (SELECT tbm.id FROM `tot_batch_assessment_trainer_maps` tbm INNER JOIN `assessment_trainers` ass ON ass.doc_no=tbm.doc_no WHERE tbm.tr_id < ass.id)) AND percentage IS NOT NULL AND (validity IS NULL OR (validity IS NOT NULL AND validity < '$today'))");

        return view('admin.tot-toa.trainers')->with(compact('tots','schemes','expired'));
    }

    // public function linkingTrainerAPI(Request $request)
    // {
    //     $tot = AssessmentTrainer::find($request->trainer);
    //     if ($tot) {
    //         return response()->json(['success'=> true, 'tot'=>$tot], 200);
    //     } else {
    //         return response()->json(['success'=> false, 'message'=>'Selected Trainer is Not Found'], 200);
    //     }
        
    // }

    public function submitLinkingTrainer(Request $request)
    {

        // dd($request);
        $data = explode(',', $request->trainer);
        $tot = AssessmentTrainer::find($data[0]);
        if ($tot) {
            
            if ($tot->tp_name == trim($request->tp_name) && $tot->trainer_category == $request->trainer_type) {
                return response()->json(['success'=> false, 'message'=>'Selected Trainer is presently linked with provided TP'], 200);
            } else {

                if ($request->trainer_type=='0' && $tot->trainer_category=='1') {
                    
                }
                
                $tot_new = new AssessmentTrainer;
                $tot_new->doc_type = $tot->doc_type;
                $tot_new->doc_no = $tot->doc_no;
                $tot_new->salutation = $tot->salutation;
                $tot_new->name = $tot->name;
                $tot_new->email = $tot->email;
                $tot_new->contact = $tot->contact;
                $tot_new->gender = $tot->gender;
                $tot_new->trainer_category = ($request->trainer_type=='0' && $tot->trainer_category=='1')?$request->trainer_type:$tot->trainer_category;
                $tot_new->dob = $tot->dob;
                $tot_new->sip_tr_id = $tot->sip_tr_id;
                $tot_new->sip_tc_id = ($request->trainer_type=='0' && $tot->trainer_category=='1')?$request->sip_tcid:$tot->sip_tc_id;
                $tot_new->tc_name = ($request->trainer_type=='0' && $tot->trainer_category=='1')?$request->tc_name:$tot->tc_name;
                $tot_new->tc_address = ($request->trainer_type=='0' && $tot->trainer_category=='1')?$request->tc_location:$tot->tc_address;
                // $tot_new->tp_name = ($request->trainer_type=='0' && $tot->trainer_category=='1')?$request->tp_name:$tot->tp_name;
                $tot_new->tp_name = is_null($request->tp_name)?'NA':$request->tp_name;
                $tot_new->utr_no = $tot->utr_no;
                $tot_new->dop = $tot->dop;
                $tot_new->scheme = ($request->trainer_type=='0' && $tot->trainer_category=='1')?$request->scheme:$tot->scheme;
                
                $tot_new->has_ssc = ($request->trainer_type=='0' && $tot->trainer_category=='1')?($request->has('domain_cert_no')?1:0):$tot->has_ssc;
                $tot_new->ssc_certno = ($request->trainer_type=='0' && $tot->trainer_category=='1')?($request->has('domain_cert_no')?$request->domain_cert_no:NULL):$tot->ssc_certno;
                $tot_new->details_on_inspc = ($request->trainer_type=='0' && $tot->trainer_category=='1')?$request->is_insprcted:$tot->details_on_inspc;
                $tot_new->has_disability = $tot->has_disability;
                $tot_new->d_type = $tot->d_type;
                $tot_new->high_quali = $tot->high_quali;
                $tot_new->industry_exp = $tot->industry_exp;
                $tot_new->training_exp = $tot->training_exp;
                $tot_new->domain_job = ($request->trainer_type=='0' && $tot->trainer_category=='1')?$request->job_role:$tot->domain_job;
                $tot_new->domain_job_code = ($request->trainer_type=='0' && $tot->trainer_category=='1')?$request->job_role_code:$tot->domain_job_code;
                $tot_new->g_type = $tot->g_type;
                $tot_new->g_name = $tot->g_name;
                $tot_new->address = $tot->address;
                $tot_new->pin = $tot->pin;
                $tot_new->city = $tot->city;
                $tot_new->state_district = $tot->state_district;
                $tot_new->save();
                return response()->json(['success'=> true, 'message'=>'Trainer Switching is <span style="color:blue">Successful</span>'], 200);
            }

        } else {
            return response()->json(['success'=> false, 'message'=>'Selected Trainer is not Found'], 200);
        }

    }

    public function viewTrainer(Request $request)
    {
        if ($id=AppHelper::instance()->decryptThis($request->id)) {
            $tot = AssessmentTrainer::findOrFail($id);
            $tot_records = AssessmentTrainer::where('doc_no', $tot->doc_no)->get();
            return view('admin.tot-toa.view-trainer')->with(compact('tot', 'tot_records'));
        }
    }
    
    public function addTrainerCert()
    { 

        $data = [
            'states' => DB::table('state_district')->get(),
            'disabilities' => Expository::all(),
            'schemes' => Scheme::all(),
        ];
        return view('admin.tot-toa.add-tot-cert')->with($data);
    }

    public function submitAddTrainerCert(Request $request)
    {   

        $tot = new AssessmentTrainer;
        $tot->doc_type=$request->doc_type;
        $tot->doc_no=$request->doc_no;
        $tot->salutation=$request->salutation;
        $tot->name=$request->name;
        $tot->email=$request->email;
        $tot->contact=$request->mobile;
        $tot->gender=$request->gender;
        $tot->trainer_category=$request->trainer_category;
        $tot->dob=$request->dob;
        $tot->sip_tr_id=$request->sip_tr_id;
        $tot->sip_tc_id=$request->sip_tc_id;
        $tot->tc_name=$request->tc_name;
        $tot->tc_address=$request->tc_address;
        $tot->tp_name=is_null($request->tp_name)?'NA':trim($request->tp_name);
        $tot->utr_no=$request->utr_no;
        $tot->dop=$request->payment_date;
        $tot->scheme=$request->scheme;
        $tot->has_ssc=$request->has_domain_cert;
        $tot->ssc_certno=$request->has_domain_cert?$request->domain_cert:NULL;
        $tot->details_on_inspc=$request->has_inspected;
        $tot->has_disability=$request->has_disability;
        $tot->d_type=$request->disability;
        $tot->high_quali=$request->qualification;
        $tot->industry_exp=$request->industry_exp;
        $tot->training_exp=$request->training_exp;
        $tot->domain_job=$request->domain_job;
        $tot->domain_job_code=$request->domain_job_code;
        $tot->g_type=$request->g_type;
        $tot->g_name=$request->g_name;
        $tot->address=$request->address;
        $tot->state_district=$request->state_district;
        $tot->city=$request->city;
        $tot->pin=$request->pin;

        $tot->save();

        alert()->success('Trainer data with Training Partner has been recorded', 'Job Done')->autoclose(4000);
        return redirect()->back();
            
    }

    public function totApi(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'doc_no' => [
                'nullable',
                'unique:candidates,doc_no',
                'unique:assessment_trainers,doc_no',
                'unique:assessment_assessors,doc_no',
                'unique:agencies,aadhaar',
                'unique:assessors,aadhaar',
            ],
            'mobile' => [
                'nullable',
                'numeric',
                'min:10',
                'unique:assessment_trainers,contact',
                'unique:assessment_assessors,contact',
                'unique:partners,spoc_mobile',
                'unique:centers,mobile',
                'unique:candidates,contact',
                'unique:agencies,mobile',
                'unique:assessors,mobile',
            ],
            'email' => [
                'nullable',
                'email',
                'unique:assessment_trainers,email',
                'unique:assessment_assessors,email',
                'unique:admins,email',
                'unique:partners,email',
                'unique:centers,email',
                'unique:candidates,email',
                'unique:agencies,email',
                'unique:assessors,email'
            ],
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->getMessages();
            $message=NULL;
            foreach ($errors as $err) {
                $message = $message . $err[0] . ' <br> ';
            }
            return response()->json(['success'=>false, 'message'=>$message]);
        }
        return response()->json(['success'=>true]);
    }

    public function totBatchApi()
    {
        $today = Carbon::now()->format('Y-m-d');
        // $expired = DB::select("select ass.id, ass.name, ass.tp_name, ass.doc_no from `assessment_trainers` AS ass INNER JOIN `tot_batch_assessment_trainer_maps` AS tbm ON ass.id=tbm.tr_id INNER JOIN `tot_batches` AS tb ON tb.id=tbm.bt_id WHERE tbm.validity < '$today' AND tbm.id IN (SELECT tbm.id FROM `assessment_trainers` AS ass LEFT JOIN `tot_batch_assessment_trainer_maps` AS tbm ON (ass.id = tbm.tr_id) LEFT OUTER JOIN `tot_batch_assessment_trainer_maps` AS tbm2 ON (ass.doc_no = tbm2.doc_no AND (tbm.id < tbm2.id)) WHERE tbm2.id IS NULL)");
        $expired = DB::select("SELECT asat.id, asat.name, asat.tp_name, asat.doc_no FROM `tot_batch_assessment_trainer_maps` AS tbatm INNER JOIN `assessment_trainers` AS asat ON tbatm.tr_id = asat.id WHERE tbatm.id IN (SELECT tbm1.id FROM `assessment_trainers` AS ass LEFT JOIN `tot_batch_assessment_trainer_maps` AS tbm1 ON (ass.id = tbm1.tr_id) LEFT OUTER JOIN `tot_batch_assessment_trainer_maps` AS tbm2 ON (ass.doc_no = tbm2.doc_no AND (tbm1.id < tbm2.id)) WHERE tbm2.id IS NULL AND tbm1.id NOT IN (SELECT tbm.id FROM `tot_batch_assessment_trainer_maps` tbm INNER JOIN `assessment_trainers` ass ON ass.doc_no=tbm.doc_no WHERE tbm.tr_id < ass.id)) AND percentage IS NOT NULL AND (validity IS NULL OR (validity IS NOT NULL AND validity < '$today'))");

        $new_registered = DB::select("select id, name, tp_name, doc_no from `assessment_trainers` WHERE id NOT IN (SELECT tr_id FROM `tot_batch_assessment_trainer_maps`)");

        return response()->json(['new_records' => $new_registered, 'renewals' => $expired],200);
    }

    public function assessors()
    {
        return view('admin.tot-toa.assessors');
    }

    public function addAssessorCert()
    {
        return view('admin.tot-toa.add-toa-cert');
    }
}
