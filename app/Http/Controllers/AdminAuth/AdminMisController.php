<?php

namespace App\Http\Controllers\AdminAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\CenterCandidateMap;
use App\JobRole;
use App\PartnerJobrole;
use App\CenterJobRole;
use App\Center;
use App\Batch;
use App\Scheme;
use DB;


class AdminMisController extends Controller
{

    public function __construct()
    {
        $this->middleware(['admin','prevent-back-history']);
    }

    public function mis(){

        $fyear =( date('m') > 3) ? date('y')."-".(date('y') + 1) : (date('y')-1)."-".date('y');

        //Block portion
            //Enroll
            $b_total_candidate=CenterCandidateMap::where('f_year',$fyear)->get()->count();
            //End Enroll

            //Ongoing Training
            $b_ongoing_training=Batch::where([['batch_start','<=',Carbon::now()->format('d-m-Y')],['batch_end','>=',Carbon::now()->format('d-m-Y')]])->get();
            $bt_can_cnt=0;
            foreach ($b_ongoing_training as $bt_ongoing) {
                foreach ($bt_ongoing->candidatesmap as $bt_can_map) {
                   $bt_can_cnt += CenterCandidateMap::where('id',$bt_can_map->candidate_id)->get()->count();
                      
                }
            }
            //End Ongoing Training

            //Trained
            $b_trained_batch=Batch::where([['f_year','=',$fyear],['batch_end','<',Carbon::now()->format('d-m-Y')]])->get();
            $trained_can_cnt=0;
            foreach ($b_trained_batch as $bt_trained) {
                foreach ($bt_trained->candidatesmap as $bt_can_map) {
                   $trained_can_cnt += CenterCandidateMap::where('id',$bt_can_map->candidate_id)->get()->count();
                      
                }
            }
            
            //End trained
            //Assessed
            $b_assessed_batch=Batch::where([['f_year','=',$fyear],['assessment','<',Carbon::now()->format('d-m-Y')]])->get();
            
            $assessed_can_cnt=0;
            foreach ($b_assessed_batch as $bt_assessed) {
                
                foreach ($bt_assessed->candidatesmap as $bt_can_map) {
                   $assessed_can_cnt += CenterCandidateMap::where('id',$bt_can_map->candidate_id)->get()->count();
                      
                }
            }
            //End Assessed
            //Candidate Passed
                $candidate_passed=CenterCandidateMap::where([['passed','=',1],['f_year','=',$fyear]])->get()->count();
               
            //End Candidate Passed
            //Candidate Failed
                $candidate_failed=CenterCandidateMap::where([['passed','=',0],['f_year','=',$fyear]])->get()->count();
               
            //End Candidate Failed
            //Candidate Absent
                $candidate_absent=CenterCandidateMap::where([['passed','=',2],['f_year','=',$fyear]])->get()->count();
               
            //End Candidate Absent
            

        //End Block portion
        

        // Bar chart for District
        $districts=DB::table('state_district')->get();
        $stack = array();
        foreach ($districts as $key => $dist) {
           $can_count=0;
        
           
            $candidate=CenterCandidateMap::where([['state_district','=',$dist->id],['f_year','=',$fyear]])->get();
           
            $can_count=$can_count+ count($candidate);
      
        
        $stack[$dist->district]=$can_count;
        }
        arsort($stack);
        
        $state=$candidate=array();
        foreach ($stack as $key => $value) {
            array_push($state,$key);
            array_push($candidate,$value);
        }
        //End Bar Chart for District

        //Bar chart for Parliament
        $parliaments=DB::table('parliament')->get();
        $parliament_stack = array();

        foreach ($parliaments as  $parliament) {
            $can_count_parliament=0;
           $center=Center::where('parliament',$parliament->id)->get();

           foreach ($center as  $center) {
               $can_count_parliament=$can_count_parliament+ $center->candidatesmap->where('f_year',$fyear)->count();
            }
            $parliament_stack[$parliament->constituency]=$can_count_parliament;

        }
        arsort($parliament_stack);
        $parl_name=$p_can_count=array();
        foreach ($parliament_stack as $key => $value) {
            array_push($parl_name,$key);
            array_push($p_can_count,$value);
        }

        
        //End Bar chart for Parliament

        //Job role Bar Chart

        $job_role=JobRole::all();
        
        $can_stack=array();
        foreach ($job_role as  $job) {
            $c_count=0;
            $partner_job=PartnerJobrole::where('jobrole_id',$job->id)->get();

            foreach ($partner_job as  $p_job) {
               $center_job=CenterJobRole::where('tp_job_id',$p_job->id)->get(); 

               foreach ($center_job as  $c_job) {
                $center_candidate=CenterCandidateMap::where([['tc_job_id','=',$c_job->id],['f_year','=',$fyear]])->get();
                
                $c_count=$c_count+count($center_candidate);

               }
            }
            $can_stack[$job->job_role]=$c_count;
            arsort($can_stack);
            $job_name=$t_candidate=array();
            foreach ($can_stack as $key1 => $value1) {
                array_push($job_name,$key1);
                array_push($t_candidate,$value1);
            }


        }

        //End Job role Bar Chart
        //dd($can_stack);       
       
        return view('admin.mis.quick-view')->with(compact('state','candidate','job_name','t_candidate','parl_name',
        'p_can_count','b_total_candidate','bt_can_cnt','trained_can_cnt','assessed_can_cnt','candidate_passed','candidate_failed','candidate_absent'));
    }

    public function summary(){
        return view('admin.mis.summary-block');
       
    }
    protected function scheme(){
       return Scheme::all();
    }
    public function pageTpTcWise(){
       
        $scheme=$this->scheme();
        return view('admin.mis.tp-tc-summary')->with(compact('scheme'));
    }

    public function tpTcWiseSummary(Request $request){
        //$fyear =( date('m') > 3) ? date('y')."-".(date('y') + 1) : (date('y')-1)."-".date('y');
        $scheme=$this->scheme();
        $scm=Scheme::findOrFail($request->scheme);
        $sel_scm=$scm->scheme;
        $sel_yr=$request->financial_year;
        $tp=PartnerJobrole::where('scheme_id',$request->scheme)->groupBy('tp_id')->get();
        // $partner_id=
        // $center_id=$candidate_enroll=$can_ongoing=$can_trained=$can_assessed=$can_passed=$can_failed=$can_absent=array();
        $center_stack=array();
        foreach ($tp as  $partner) {
            $tc=Center::where('tp_id',$partner->tp_id)->get();

            foreach ($tc as $center) {
            $tp_tc_wise_candidate=CenterCandidateMap::where([['f_year','=',$request->financial_year],['tc_id','=',$center->id]])->get()->count();

            $batch_ongoing=Batch::where([['f_year','=',$request->financial_year],['tc_id','=',$center->id],['batch_start','<=',Carbon::now()->format('d-m-Y')],['batch_end','>=',Carbon::now()->format('d-m-Y')]])->get();
            $bt_can_cnt=0;
            foreach ($batch_ongoing as $bt_ongoing) {
                foreach ($bt_ongoing->candidatesmap as $bt_can_map) {
                   $bt_can_cnt += CenterCandidateMap::where('id',$bt_can_map->candidate_id)->get()->count();
                      
                }
            }

            //Trained
            $trained_batch=Batch::where([['f_year','=',$request->financial_year],['tc_id','=',$center->id],['batch_end','<',Carbon::now()->format('d-m-Y')]])->get();
            
            $trained_can_cnt=0;
            foreach ($trained_batch as $bt_trained) {
                foreach ($bt_trained->candidatesmap as $bt_can_map) {
                   $trained_can_cnt += CenterCandidateMap::where('id',$bt_can_map->candidate_id)->get()->count();
                      
                }
            }
            //End trained
             //Assessed
             $assessed_batch=Batch::where([['f_year','=',$request->financial_year],['tc_id','=',$center->id],['assessment','<',Carbon::now()->format('d-m-Y')]])->get();
            
             $assessed_can_cnt=$passed_can_cnt=$failed_can_cnt=$absent_can_cnt=0;
             foreach ($assessed_batch as $bt_assessed) {
                 
                 foreach ($bt_assessed->candidatesmap as $bt_can_map) {
                    $assessed_can_cnt += CenterCandidateMap::where('id',$bt_can_map->candidate_id)->get()->count();
                    //Candidate Passed
                    $passed_can_cnt += CenterCandidateMap::where([['passed','=',1],['id','=',$bt_can_map->candidate_id]])->get()->count();
                    //End Candidate Passed
                    //Candidate Failed
                    $failed_can_cnt += CenterCandidateMap::where([['passed','=',0],['id','=',$bt_can_map->candidate_id]])->get()->count();
                    //End Candidate failed
                    //Candidate Absent
                    $absent_can_cnt += CenterCandidateMap::where([['passed','=',2],['id','=',$bt_can_map->candidate_id]])->get()->count();
                    //End Candidate Absent
                       
                 }
             }
             //End Assessed
             
             $center_stack[$center->tc_id]=[
                                        $partner->partner->tp_id,
                                        $tp_tc_wise_candidate,
                                        $bt_can_cnt,
                                        $trained_can_cnt,
                                        $assessed_can_cnt,
                                        $passed_can_cnt,
                                        $failed_can_cnt,
                                        $absent_can_cnt
                                        ];

                            }

                     }
        return view('admin.mis.tp-tc-summary')->with(compact('center_stack','scheme','sel_scm','sel_yr'));
        //dd($center_id);
    }

    public function pageCandidateWise(){
        $scheme=$this->scheme();
        return view('admin.mis.candidate-summary')->with(compact('scheme'));
    }

    public function candidateWiseSummary(Request $request){

        $scheme=$this->scheme();
        $scm=Scheme::findOrFail($request->scheme);
        $sel_scm=$scm->scheme;
        $sel_yr=$request->financial_year;
        $candidate=CenterCandidateMap::where('f_year',$request->financial_year)->get();
        $can_stack=array();
        foreach ($candidate as $key => $value) {
           if($value->jobrole->partnerjobrole->where('scheme_id',$request->scheme)){
            if(!is_null( $value->batchcandidate)){
               $batch_id= $value->batchcandidate->batch->batch_id;
               $batch_start= $value->batchcandidate->batch->batch_start;
               $batch_end= $value->batchcandidate->batch->batch_end;
                }else{ 
                    $batch_id='N/A';$batch_start='N/A';$batch_end='N/A';
                
                }

            if($value->passed==null){
                $result='N/A';
            }elseif($value->passed===1){
                $result='Passed';

            }elseif($value->passed===0){
                $result='Failed';

            }elseif($value->passed===2){
                $result='Absent';

            }
            $can_state_dist=DB::table('state_district')->where('id',$value->state_district)->first();
            $tc_state_dist=DB::table('state_district')->where('id', $value->center->state_district)->first();
            $can_stack[$value->id]=[
                                    $value->center->partner->tp_id,
                                    $value->center->tc_id,
                                    $value->jobrole->partnerjobrole->jobrole->job_role,
                                    $batch_id,
                                    $value->candidate->name,
                                    $can_state_dist->state,
                                    $can_state_dist->district,
                                    $value->candidate->gender,
                                    $value->education,
                                    $value->candidate->contact,
                                    $value->disability->e_expository,
                                    $batch_start,
                                    $batch_end,
                                    $result,
                                    $value->candidate->category,
                                    $value->center->center_address,
                                    $value->jobrole->partnerjobrole->sector->sector,
                                    $tc_state_dist->state,
                                    $tc_state_dist->district,
                                    $value->center->email,
                                    $value->center->mobile,
                                    $value->center->spoc_name

                                    ];

           }

           
        }
        return view('admin.mis.candidate-summary')->with(compact('can_stack','scheme','sel_scm','sel_yr'));

    }

    public function pageJobDisabilityWise(){
        $scheme=$this->scheme();
        return view('admin.mis.job-disability-summary')->with(compact('scheme'));
    }

    public function jobDisabilityWiseSummary(Request $request){
        $job_role=JobRole::all();

        // foreach ($job_role as $key => $value) {
            
        // }
    }
}
