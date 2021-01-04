<?php

namespace App\Http\Controllers\AdminAuth;

use PDF;
use Validator;
use App\Agency;
use App\Scheme;
use App\ToaBatch;
use App\TotBatch;
use Carbon\Carbon;
use App\Expository;
use App\OldToaData;
use App\OldTotData;
use App\AssessmentTrainer;
use App\Helpers\AppHelper;
use App\AssessmentAssessor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\TotBatchAssessmentTrainerMap;
use App\ToaBatchAssessmentAssessorMap;
use Illuminate\Support\Facades\Storage;

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
    public function submitToaBatches(Request $request)
    {
        // dd($request);
        $last_bid=DB::select("SELECT MAX(SUBSTRING(batch_id,11)) AS b_id FROM `toa_batches`");
        
        $b_id = $last_bid[0]->b_id?$last_bid[0]->b_id+1:43;

        $toabatch = new ToaBatch;
        $toabatch->batch_id = 'SCPwD-TOA-'.$b_id;
        $toabatch->batch_start = Carbon::parse($request->start)->format('Y-m-d');
        $toabatch->batch_end = Carbon::parse($request->end)->format('Y-m-d');
        $toabatch->save();

        
        if ($request->has('new_records')) {
            foreach ($request->new_records as $data) {
                $assessor = AssessmentAssessor::select('doc_no')->where('id',$data)->first();
                
                $last_bttoaid=DB::select("SELECT MAX(SUBSTRING(bt_toa_id,16)) AS bttoa_id FROM `toa_batch_assessment_assessor_maps`");
                $bttoa_id = 'PWD/'.Carbon::parse($toabatch->batch_end)->format('dmY').'/A-'.($last_bttoaid[0]->bttoa_id?($last_bttoaid[0]->bttoa_id+1):814);
                
                $tbas_map = new ToaBatchAssessmentAssessorMap;
                $tbas_map->bt_id = $toabatch->id;
                $tbas_map->as_id = $data;
                $tbas_map->doc_no = $assessor->doc_no;
                $tbas_map->bt_toa_id = $bttoa_id;
                $tbas_map->save();
            }
        }
        if ($request->has('renewals')) {
            foreach ($request->renewals as $data) {
                $assessor = AssessmentAssessor::select('id','doc_no')->where('id',$data)->first();

                $last_bttoaid=DB::select("SELECT SUBSTRING(bt_toa_id,14) AS bttoa_id FROM `toa_batch_assessment_assessor_maps` WHERE as_id='$assessor->id'");
                
                $bttoa_id = 'PWD/'.Carbon::parse($toabatch->batch_end)->format('dmY').'/'.$last_bttoaid[0]->bttoa_id;
                
                $tbtr_map = new ToaBatchAssessmentAssessorMap;
                $tbtr_map->bt_id = $toabatch->id;
                $tbtr_map->as_id = $data;
                $tbtr_map->doc_no = $assessor->doc_no;
                $tbtr_map->bt_toa_id = $bttoa_id;
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
            $tag = 'tot';
            if (is_null($batchData->trainers[0]->percentage)) {
                return view('admin.tot-toa.add-marks')->with(compact('batchData', 'tag'));
            }
            return abort(403,'This action is not permitted');
        }
    }
    public function addToaMarks(Request $request)
    {
        if ($id=AppHelper::instance()->decryptThis($request->id)) {
            $batchData = ToaBatch::findOrFail($id);
            $tag = 'toa';
            if (is_null($batchData->assessors[0]->percentage)) {
                return view('admin.tot-toa.add-marks')->with(compact('batchData', 'tag'));
            }
            return abort(403,'This action is not permitted');
        }
    }

    public function submitTotMarks(Request $request)
    {
        $totBatch = TotBatch::findOrFail($request->bt_id);

        DB::transaction(function () use($totBatch, $request){

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
                        $digital_key = rand(10,99).$batchMap->id.time().'1';
                    } else {
                        //Trainer
                        $last_qid=DB::select("SELECT MAX(SUBSTRING(qr_id,9)) AS q_id FROM `tot_batch_assessment_trainer_maps` WHERE qr_id LIKE '%/T/%'");
                        $q_id = 'SCPwD/T/'.($last_qid[0]->q_id?$last_qid[0]->q_id+1:771);
                        $digital_key = rand(10,99).$batchMap->id.time().'1';
                    }
                }
                $batchMap->update(['qr_id'=>$q_id,'digital_key'=>$digital_key,'percentage'=>$percentage,'grade'=>$grade, 'validity'=>$validity]);

            }
        });  

        

        alert()->success('Batch Marks has been <span style="color:blue">Updated</span>','Job Done')->html()->autoclose(5000);
        return redirect()->route('admin.tot-toa.tot-batches');
    }
    public function submitToaMarks(Request $request)
    {
        $toaBatch = ToaBatch::findOrFail($request->bt_id);

        DB::transaction(function () use($toaBatch, $request){
            foreach ($toaBatch->assessors as $batchMap) {
    
                $percentage = $request->mark[$batchMap->as_id][0];
    
                if ((int)$percentage >= 90) {
                    $grade = 'A';
                    $validity = Carbon::parse($toaBatch->batch_end)->addYear(2)->format('Y-m-d');
                } elseif ((int)$percentage < 90 && (int)$percentage >= 80) {
                    $grade = 'B';
                    $validity = Carbon::parse($toaBatch->batch_end)->addYear(1)->format('Y-m-d');
                } elseif ((int)$percentage < 80 && (int)$percentage >= 70) {
                    $grade = 'Provisionally Pass';
                    $validity = Carbon::parse($toaBatch->batch_end)->addMonth(6)->format('Y-m-d');
                } else {
                    $grade = NULL;
                    $validity = NULL;
                }
    
                if (is_null($grade)) {
                    $q_id = NULL;
                    $digital_key = NULL;
                } else {
                    $last_qid=DB::select("SELECT MAX(SUBSTRING(qr_id,9)) AS q_id FROM `toa_batch_assessment_assessor_maps`");
                    $q_id = 'SCPwD/A/'.($last_qid[0]->q_id?$last_qid[0]->q_id+1:689);
                    $digital_key = rand(10,99).$batchMap->id.time().'0';
                }
                $batchMap->update(['qr_id'=>$q_id,'digital_key'=>$digital_key,'percentage'=>$percentage,'grade'=>$grade, 'validity'=>$validity]);
            
            }
        });  

        alert()->success('Batch Marks has been <span style="color:blue">Updated</span>','Job Done')->html()->autoclose(5000);
        return redirect()->route('admin.tot-toa.toa-batches');
    }


    public function viewTotBatch(Request $request)
    {
        if ($id=AppHelper::instance()->decryptThis($request->id)) {
            $batchData = TotBatch::findOrFail($id);
            $tag = 'tot';
            if ($batchData->trainers->count()) {
                return view('admin.tot-toa.view-batch')->with(compact('batchData','tag'));
            }
            return abort(403,'This action is not permitted');
        }
    }

    public function viewToaBatch(Request $request)
    {
        if ($id=AppHelper::instance()->decryptThis($request->id)) {
            $batchData = ToaBatch::findOrFail($id);
            $tag = 'toa';
            if ($batchData->assessors->count()) {
                return view('admin.tot-toa.view-batch')->with(compact('batchData','tag'));
            }
            return abort(403,'This action is not permitted');
        }
    }


    public function toaBatches()
    {
        $data = [
            'tag' => 'toa',
            'records' => ToaBatch::all()
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

        return view('admin.tot-toa.tot.trainers')->with(compact('tots','schemes','expired'));
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

                // if ($request->trainer_type=='0' && $tot->trainer_category=='1') {
                    
                // }
                
                $tot_new = new AssessmentTrainer;
                $tot_new->doc_type = $tot->doc_type;
                $tot_new->doc_no = $tot->doc_no;
                $tot_new->salutation = $tot->salutation;
                $tot_new->name = $tot->name;
                $tot_new->email = $tot->email;
                $tot_new->contact = $tot->contact;
                $tot_new->gender = $tot->gender;
                $tot_new->trainer_category = ($request->trainer_type=='0' && $tot->trainer_category=='1')?$request->trainer_type:(($request->trainer_type=='1' && $tot->trainer_category=='0')?$request->trainer_type:$tot->trainer_category);
                $tot_new->dob = $tot->dob;
                $tot_new->sip_tr_id = $tot->sip_tr_id;
                $tot_new->sip_tc_id = ($request->trainer_type=='0' && $tot->trainer_category=='1')?$request->sip_tcid:(($request->trainer_type=='1' && $tot->trainer_category=='0')?$request->sip_tcid:$tot->sip_tc_id);
                $tot_new->tc_name = ($request->trainer_type=='0' && $tot->trainer_category=='1')?$request->tc_name:(($request->trainer_type=='1' && $tot->trainer_category=='0')?$request->tc_name:$tot->tc_name);
                $tot_new->tc_address = ($request->trainer_type=='0' && $tot->trainer_category=='1')?$request->tc_location:(($request->trainer_type=='1' && $tot->trainer_category=='0')?$request->tc_location:$tot->tc_address);
                // $tot_new->tp_name = ($request->trainer_type=='0' && $tot->trainer_category=='1')?()$request->tp_name:$tot->tp_name;
                $tot_new->tp_name = is_null($request->tp_name)?'NA':$request->tp_name;
                $tot_new->utr_no = $tot->utr_no;
                $tot_new->dop = $tot->dop;
                $tot_new->scheme = ($request->trainer_type=='0' && $tot->trainer_category=='1')?$request->scheme:(($request->trainer_type=='1' && $tot->trainer_category=='0')?$request->scheme:$tot->scheme);
                
                $tot_new->has_ssc = ($request->trainer_type=='0' && $tot->trainer_category=='1')?($request->has('domain_cert_no')?1:0):(($request->trainer_type=='1' && $tot->trainer_category=='0')?($request->has('domain_cert_no')?1:0):$tot->has_ssc);
                $tot_new->ssc_certno = ($request->trainer_type=='0' && $tot->trainer_category=='1')?($request->has('domain_cert_no')?$request->domain_cert_no:NULL):(($request->trainer_type=='1' && $tot->trainer_category=='0')?($request->has('domain_cert_no')?$request->domain_cert_no:NULL):$tot->ssc_certno);
                $tot_new->details_on_inspc = ($request->trainer_type=='0' && $tot->trainer_category=='1')?$request->is_insprcted:(($request->trainer_type=='1' && $tot->trainer_category=='0')?$request->is_insprcted:$tot->details_on_inspc);
                $tot_new->has_disability = $tot->has_disability;
                $tot_new->d_type = $tot->d_type;
                $tot_new->high_quali = $tot->high_quali;
                $tot_new->industry_exp = $tot->industry_exp;
                $tot_new->training_exp = $tot->training_exp;
                $tot_new->domain_job = ($request->trainer_type=='0' && $tot->trainer_category=='1')?$request->job_role:(($request->trainer_type=='1' && $tot->trainer_category=='0')?$request->job_role:$tot->domain_job);
                $tot_new->domain_job_code = ($request->trainer_type=='0' && $tot->trainer_category=='1')?$request->job_role_code:(($request->trainer_type=='1' && $tot->trainer_category=='0')?$request->job_role_code:$tot->domain_job_code);
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

    public function submitLinkingAssessor(Request $request)
    {

        $toa = AssessmentAssessor::find($request->assessor);
        if ($toa) {
            
            if ($toa->aa_id == $request->agency) {
                return response()->json(['success'=> false, 'message'=>'Selected Assessor is presently linked with provided AA'], 200);
            } else {

                $toa_new = new AssessmentAssessor;
                $toa_new->doc_type = $toa->doc_type;
                $toa_new->doc_no = $toa->doc_no;
                $toa_new->salutation = $toa->salutation;
                $toa_new->name = $toa->name;
                $toa_new->email = $toa->email;
                $toa_new->contact = $toa->contact;
                $toa_new->landline = $toa->landline;
                $toa_new->gender = $toa->gender;
                $toa_new->dob = $toa->dob;
                $toa_new->is_pwd = $toa->is_pwd;
                $toa_new->d_type = $toa->d_type;
                $toa_new->domain_cert_no = $toa->domain_cert_no;
                $toa_new->g_type = $toa->g_type;
                $toa_new->g_name = $toa->g_name;
                $toa_new->address = $toa->address;
                $toa_new->pin = $toa->pin;
                $toa_new->city = $toa->city;
                $toa_new->state_district = $toa->state_district;
                $toa_new->aa_id = $request->agency;
                $toa_new->doa_curr_aa = $toa->doa_curr_aa;
                $toa_new->job_type = $toa->job_type;
                $toa_new->state_loc_employment = $toa->state_loc_employment;
                $toa_new->qualification = $toa->qualification;
                $toa_new->industry_exp = $toa->industry_exp;
                $toa_new->assessing_exp = $toa->assessing_exp;
                $toa_new->sector = $toa->sector;
                $toa_new->sub_sector = $toa->sub_sector;
                $toa_new->domain_job = $toa->domain_job;
                $toa_new->domain_job_code = $toa->domain_job_code;
                $toa_new->nsqf = $toa->nsqf;
                $toa_new->no_batch_assessed = $toa->no_batch_assessed;
                $toa_new->domain_ssc_doc = $toa->domain_ssc_doc;                
                $toa_new->save();
                return response()->json(['success'=> true, 'message'=>'Assessor Switching is <span style="color:blue">Successful</span>'], 200);
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
            return view('admin.tot-toa.tot.view-trainer')->with(compact('tot', 'tot_records'));
        }
    }
    
    public function addTrainerCert()
    { 

        $data = [
            'states' => DB::table('state_district')->get(),
            'disabilities' => Expository::all(),
            'schemes' => Scheme::all(),
        ];
        return view('admin.tot-toa.tot.add-tot-cert')->with($data);
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
        $tot->d_type=$request->has_disability?$request->disability:NULL;
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

    public function redundantCheckApi(Request $request)
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
            'tag' => [
                'nullable'
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

        if ($request->has('doc_no')) {
            if ($request->tag == '1') {
                $oldtots = OldTotData::where('doc_no', $request->doc_no)->get();
                if ($oldtots) {
                    foreach ($oldtots as $oldtot) {
                        $validity = substr_count($oldtot->validity, '/')?(Carbon::createFromFormat('d/m/y', $oldtot->validity)):(Carbon::parse($oldtot->validity));
                        if ($validity > Carbon::now()) {
                            return response()->json(['success'=>false, 'message'=>'Trainer with this Doc No already having a Valid Certificate from SCPwD']);
                        }
                    }
                }
            } else {
                $oldtoas = OldToaData::where('doc_no', $request->doc_no)->get();
                if ($oldtoas) {
                    foreach ($oldtoas as $oldtoa) {
                        $validity = substr_count($oldtoa->validity, '/')?(Carbon::createFromFormat('d/m/y', $oldtoa->validity)):(Carbon::parse($oldtoa->validity));
                        if ($validity > Carbon::now()) {
                            return response()->json(['success'=>false, 'message'=>'Assessor with this Doc No already having a Valid Certificate from SCPwD']);
                        }
                    }
                }
            }
        }

        return response()->json(['success'=>true]);
    }

    public function totBatchApi()
    {
        $today = Carbon::now()->format('Y-m-d');
        // $expired = DB::select("select ass.id, ass.name, ass.tp_name, ass.doc_no from `assessment_trainers` AS ass INNER JOIN `tot_batch_assessment_trainer_maps` AS tbm ON ass.id=tbm.tr_id INNER JOIN `tot_batches` AS tb ON tb.id=tbm.bt_id WHERE tbm.validity < '$today' AND tbm.id IN (SELECT tbm.id FROM `assessment_trainers` AS ass LEFT JOIN `tot_batch_assessment_trainer_maps` AS tbm ON (ass.id = tbm.tr_id) LEFT OUTER JOIN `tot_batch_assessment_trainer_maps` AS tbm2 ON (ass.doc_no = tbm2.doc_no AND (tbm.id < tbm2.id)) WHERE tbm2.id IS NULL)");
        $expired = DB::select("SELECT asat.id, asat.name, asat.tp_name, asat.doc_no FROM `tot_batch_assessment_trainer_maps` AS tbatm INNER JOIN `assessment_trainers` AS asat ON tbatm.tr_id = asat.id WHERE tbatm.id IN (SELECT tbm1.id FROM `assessment_trainers` AS ass LEFT JOIN `tot_batch_assessment_trainer_maps` AS tbm1 ON (ass.id = tbm1.tr_id) LEFT OUTER JOIN `tot_batch_assessment_trainer_maps` AS tbm2 ON (ass.doc_no = tbm2.doc_no AND (tbm1.id < tbm2.id)) WHERE tbm2.id IS NULL AND tbm1.id NOT IN (SELECT tbm.id FROM `tot_batch_assessment_trainer_maps` tbm INNER JOIN `assessment_trainers` ass ON ass.doc_no=tbm.doc_no WHERE tbm.tr_id < ass.id)) AND percentage IS NOT NULL AND (validity IS NULL OR (validity IS NOT NULL AND validity < '$today'))");

        $new_registered = DB::select("SELECT id, name, tp_name, doc_no from `assessment_trainers` WHERE id NOT IN (SELECT tr_id FROM `tot_batch_assessment_trainer_maps`)");

        return response()->json(['new_records' => $new_registered, 'renewals' => $expired],200);
    }

    public function toaBatchApi()
    {
        $today = Carbon::now()->format('Y-m-d');
        // $expired = DB::select("select ass.id, ass.name, ass.tp_name, ass.doc_no from `assessment_trainers` AS ass INNER JOIN `tot_batch_assessment_trainer_maps` AS tbm ON ass.id=tbm.tr_id INNER JOIN `tot_batches` AS tb ON tb.id=tbm.bt_id WHERE tbm.validity < '$today' AND tbm.id IN (SELECT tbm.id FROM `assessment_trainers` AS ass LEFT JOIN `tot_batch_assessment_trainer_maps` AS tbm ON (ass.id = tbm.tr_id) LEFT OUTER JOIN `tot_batch_assessment_trainer_maps` AS tbm2 ON (ass.doc_no = tbm2.doc_no AND (tbm.id < tbm2.id)) WHERE tbm2.id IS NULL)");
        $expired = DB::select("SELECT asat.id, asat.name, agnc.agency_name, asat.doc_no FROM `toa_batch_assessment_assessor_maps` AS tbatm INNER JOIN `assessment_assessors` AS asat ON tbatm.as_id = asat.id INNER JOIN `agencies` AS agnc ON asat.aa_id=agnc.id WHERE tbatm.id IN (SELECT tbm1.id FROM `assessment_assessors` AS ass LEFT JOIN `toa_batch_assessment_assessor_maps` AS tbm1 ON (ass.id = tbm1.as_id) LEFT OUTER JOIN `toa_batch_assessment_assessor_maps` AS tbm2 ON (ass.doc_no = tbm2.doc_no AND (tbm1.id < tbm2.id)) WHERE tbm2.id IS NULL AND tbm1.id NOT IN (SELECT tbm.id FROM `toa_batch_assessment_assessor_maps` tbm INNER JOIN `assessment_assessors` ass ON ass.doc_no=tbm.doc_no WHERE tbm.as_id < ass.id)) AND percentage IS NOT NULL AND (validity IS NULL OR (validity IS NOT NULL AND validity < '$today'))");

        $new_registered = DB::select("SELECT aa.id, aa.name, agnc.agency_name, aa.doc_no from `assessment_assessors` AS aa INNER JOIN `agencies` AS agnc ON aa.aa_id=agnc.id WHERE aa.id NOT IN (SELECT as_id FROM `toa_batch_assessment_assessor_maps`)");

        return response()->json(['new_records' => $new_registered, 'renewals' => $expired],200);
    }

    public function assessors()
    {
        $today = Carbon::now()->format('Y-m-d');
        $toas=AssessmentAssessor::whereIn('id',AssessmentAssessor::select(DB::raw('max(id) as id'))->groupBy('doc_no')->get()->pluck('id')->toArray())->get();
        
        $agencies = Agency::all();
        $expired = DB::select("SELECT asat.id, asat.name, agc.agency_name, asat.doc_no FROM `toa_batch_assessment_assessor_maps` AS tbatm INNER JOIN `assessment_assessors` AS asat ON tbatm.as_id = asat.id INNER JOIN `agencies` AS agc ON agc.id = asat.aa_id WHERE tbatm.id IN (SELECT tbm1.id FROM `assessment_assessors` AS ass LEFT JOIN `toa_batch_assessment_assessor_maps` AS tbm1 ON (ass.id = tbm1.as_id) LEFT OUTER JOIN `toa_batch_assessment_assessor_maps` AS tbm2 ON (ass.doc_no = tbm2.doc_no AND (tbm1.id < tbm2.id)) WHERE tbm2.id IS NULL AND tbm1.id NOT IN (SELECT tbm.id FROM `toa_batch_assessment_assessor_maps` tbm INNER JOIN `assessment_assessors` ass ON ass.doc_no=tbm.doc_no WHERE tbm.as_id < ass.id)) AND percentage IS NOT NULL AND (validity IS NULL OR (validity IS NOT NULL AND validity < '$today'))");

        return view('admin.tot-toa.toa.assessors')->with(compact('toas','agencies','expired'));    
    }

    public function addAssessorCert()
    {
        $data = [
            'states' => DB::table('state_district')->get(),
            'disabilities' => Expository::all(),
            'agencies' => Agency::all(),
        ];
        return view('admin.tot-toa.toa.add-toa-cert')->with($data);
    }

    public function submitAddAssessorCert(Request $request)
    {
        // dd($request->is_pwd);
        $toa = new AssessmentAssessor;
        $toa->doc_type=$request->doc_type;
        $toa->doc_no=$request->doc_no;
        $toa->salutation=$request->salutation;
        $toa->name=$request->name;
        $toa->email=$request->email;
        $toa->contact=$request->mobile;
        $toa->landline=$request->landline;
        $toa->gender=$request->gender;
        $toa->dob=$request->dob;
        $toa->is_pwd=$request->is_pwd;
        $toa->d_type=($request->is_pwd)?$request->disability:NULL;
        $toa->domain_cert_no=$request->domain_cert_no;
        $toa->g_type=$request->g_type;
        $toa->g_name=$request->g_name;
        $toa->address=$request->address;
        $toa->state_district=$request->state_district;
        $toa->city=$request->city;
        $toa->pin=$request->pin;
        $toa->aa_id=$request->aa_name;
        $toa->doa_curr_aa=$request->doa_curr_aa;
        $toa->job_type=$request->job_type;
        $toa->state_loc_employment=$request->state_loc_employment;
        $toa->qualification=$request->qualification;
        $toa->industry_exp=$request->industry_exp;
        $toa->assessing_exp=$request->assessing_exp;
        $toa->sector=$request->sector;
        $toa->sub_sector=$request->sub_sector;
        $toa->domain_job=$request->domain_job;
        $toa->domain_job_code=$request->domain_job_code;
        $toa->nsqf=$request->nsqf;
        $toa->no_batch_assessed=$request->no_batch_assessed;

        if ($request->has('domain_ssc_doc')) {
            $toa->domain_ssc_doc = Storage::disk('myDisk')->put('/toa', $request->domain_ssc_doc);
        }

        $toa->save();

        alert()->success('Assessor data with Assessment Agency has been recorded', 'Job Done')->autoclose(4000);
        return redirect()->back();
    }

    public function viewAssessor(Request $request)
    {
        if ($id=AppHelper::instance()->decryptThis($request->id)) {
            $toa = AssessmentAssessor::findOrFail($id);
            $toa_records = AssessmentAssessor::where('doc_no', $toa->doc_no)->get();
            return view('admin.tot-toa.toa.view-assessor')->with(compact('toa', 'toa_records'));
        }        
    }
}
