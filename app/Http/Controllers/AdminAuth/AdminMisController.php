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
use App\Expository;
use App\Agency;
use App\BatchCenterCandidateMap;
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

        $scheme=$this->scheme();
        $scm=Scheme::findOrFail($request->scheme);
        $sel_scm=$scm->scheme;
        $sel_yr=$request->financial_year;
       //JOB ROLE wise Report 
        $job_role=JobRole::all();
        $can_stack=array();
        foreach ($job_role as $job) {

            //Total Enroll
            $c_count=0;
            $partner_job=PartnerJobrole::where([['jobrole_id','=',$job->id],['scheme_id','=',$request->scheme]])->get();
            foreach ($partner_job as  $p_job) {
                $center_job=CenterJobRole::where('tp_job_id',$p_job->id)->get(); 
 
                foreach ($center_job as  $c_job) {
                 $center_candidate=CenterCandidateMap::where([['tc_job_id','=',$c_job->id],['f_year','=',$request->financial_year]])->get();
                 
                 $c_count += count($center_candidate);
 
                }
             }
             //End Total Enroll
             //Ongoing Batch
             $batch_ongoing=Batch::where([['f_year','=',$request->financial_year],['scheme_id','=',$request->scheme],['jobrole_id','=',$job->id],['batch_start','<=',Carbon::now()->format('d-m-Y')],['batch_end','>=',Carbon::now()->format('d-m-Y')]])->get();
            $bt_can_cnt=0;
            foreach ($batch_ongoing as $bt_ongoing) {
                foreach ($bt_ongoing->candidatesmap as $bt_can_map) {
                   $bt_can_cnt += CenterCandidateMap::where('id',$bt_can_map->candidate_id)->get()->count();
                      
                }
            }
            //End Ongoing Batch
            //Trained
            $batch_trained=Batch::where([['f_year','=',$request->financial_year],['scheme_id','=',$request->scheme],['jobrole_id','=',$job->id],['batch_end','<',Carbon::now()->format('d-m-Y')]])->get();
            $bt_train_can_cnt=0;
            foreach ($batch_trained as $bt_trained) {
                foreach ($bt_trained->candidatesmap as $bt_can_map) {
                   $bt_train_can_cnt += CenterCandidateMap::where('id',$bt_can_map->candidate_id)->get()->count();
                      
                }
            }
            //End Of Trained
            //Assessed
            $batch_assessed=Batch::where([['f_year','=',$request->financial_year],['scheme_id','=',$request->scheme],['jobrole_id','=',$job->id],['assessment','<',Carbon::now()->format('d-m-Y')]])->get();
            $bt_assessed_can_cnt=$passed_can_cnt=$failed_can_cnt=$absent_can_cnt=0;
            foreach ($batch_assessed as $bt_assessed) {
                foreach ($bt_assessed->candidatesmap as $bt_can_map) {
                   $bt_assessed_can_cnt += CenterCandidateMap::where('id',$bt_can_map->candidate_id)->get()->count();
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
            //End Of Assessed
           $can_stack[$job->job_role] =[
                                        $c_count,
                                        $bt_can_cnt,
                                        $bt_train_can_cnt,
                                        $bt_assessed_can_cnt,
                                        $passed_can_cnt,
                                        $failed_can_cnt,
                                        $absent_can_cnt
                                        ];
        }
        //END JOB ROLE wise Report
        //DISABILITY wise Report
            $expository=Expository::all();
            $dis_can_stack=array();
            foreach ($expository as $expo) {
                $dis_can_cnt=0;
                //enroll
                $dis_candidate=CenterCandidateMap::where([['d_type','=',$expo->id],['f_year','=',$request->financial_year]])->get();
                foreach ($dis_candidate as  $dis_candidate) {
                    if($dis_candidate->jobrole->partnerjobrole->where('scheme_id',$request->scheme)){
                        $dis_can_cnt +=1;
                    }
                }
                //end enroll
                //ongoing Training
                $dis_batch_ongoing=Batch::where([['f_year','=',$request->financial_year],['scheme_id','=',$request->scheme],['batch_start','<=',Carbon::now()->format('d-m-Y')],['batch_end','>=',Carbon::now()->format('d-m-Y')]])->get();
                $dis_bt_can_cnt=0;
                foreach ($dis_batch_ongoing as $bt_ongoing) {
                    foreach ($bt_ongoing->candidatesmap as $bt_can_map) {
                       $dis_bt_can_cnt += CenterCandidateMap::where([['id','=',$bt_can_map->candidate_id],['d_type','=',$expo->id]])->get()->count();
                        
                    
                    }
                }
                //End ongoing Training
                // Trained
                $dis_batch_trained=Batch::where([['f_year','=',$request->financial_year],['scheme_id','=',$request->scheme],['batch_end','<',Carbon::now()->format('d-m-Y')]])->get();
                $dis_bt_trnd_can=0;
                foreach ($dis_batch_trained as $bt_trained) {
                    foreach ($bt_trained->candidatesmap as $bt_can_map) {
                       $dis_bt_trnd_can += CenterCandidateMap::where([['id','=',$bt_can_map->candidate_id],['d_type','=',$expo->id]])->get()->count();
                          
                    }
                }
                //End Trained
                // Assessed
                $dis_batch_assessed=Batch::where([['f_year','=',$request->financial_year],['scheme_id','=',$request->scheme],['assessment','<',Carbon::now()->format('d-m-Y')]])->get();
                $dis_bt_assd_can=$dis_passed_can_cnt=$dis_failed_can_cnt=$dis_absent_can_cnt=0;
                foreach ($dis_batch_assessed as $bt_assessed) {
                    foreach ($bt_assessed->candidatesmap as $bt_can_map) {
                       $dis_bt_assd_can += CenterCandidateMap::where([['id','=',$bt_can_map->candidate_id],['d_type','=',$expo->id]])->get()->count();
                     //Candidate Passed
                    $dis_passed_can_cnt += CenterCandidateMap::where([['passed','=',1],['id','=',$bt_can_map->candidate_id],['d_type','=',$expo->id]])->get()->count();
                    //End Candidate Passed
                    //Candidate Failed
                    $dis_failed_can_cnt += CenterCandidateMap::where([['passed','=',0],['id','=',$bt_can_map->candidate_id],['d_type','=',$expo->id]])->get()->count();
                    //End Candidate failed
                    //Candidate Absent
                    $dis_absent_can_cnt += CenterCandidateMap::where([['passed','=',2],['id','=',$bt_can_map->candidate_id],['d_type','=',$expo->id]])->get()->count();
                    //End Candidate Absent  
                    }
                }
                //End Assessed
                $dis_can_stack[$expo->e_expository]=[
                                                    $dis_can_cnt,
                                                    $dis_bt_can_cnt,
                                                    $dis_bt_trnd_can,
                                                    $dis_bt_assd_can,
                                                    $dis_passed_can_cnt,
                                                    $dis_failed_can_cnt,
                                                    $dis_absent_can_cnt
                                                    ];
            }
            //dd($dis_can_stack);
        //END DISABILITY wise Report
        return view('admin.mis.job-disability-summary')->with(compact('can_stack','dis_can_stack','scheme','sel_scm','sel_yr'));

    }

    public function pageAgencyWise(){
        $scheme=$this->scheme();
        return view('admin.mis.agency-summary')->with(compact('scheme')); 
    }

    public function agencyWiseSummary(Request $request){
        $scheme=$this->scheme();
        $scm=Scheme::findOrFail($request->scheme);
        $sel_scm=$scm->scheme;
        $sel_yr=$request->financial_year;
       $agency= Agency::all();
       $candidate_stack=array();
       foreach ($agency  as $agency) {
        $enroll_candidate=$ongoing_candidate=$trained_candidate=$assessed_candidate=$passed_candidate=$failed_candidate=$absent_candidate=0;
           foreach ($agency->agencyBatch->where('aa_verified',1) as $agBatch) {
               //Enroll/Assign
            $batch=Batch::where([['f_year','=',$request->financial_year],['scheme_id','=',$request->scheme],['id','=',$agBatch->bt_id]])->get();
            foreach ($batch as $batch) {
                foreach ($batch->candidatesmap as $bt_can_map) {
                   $enroll_candidate += CenterCandidateMap::where('id',$bt_can_map->candidate_id)->get()->count();
                
                }
            }
        
            //End Enroll/Assign

            //Ongoing Batch
            $batch_ongoing=Batch::where([['f_year','=',$request->financial_year],['scheme_id','=',$request->scheme],['id','=',$agBatch->bt_id],['batch_start','<=',Carbon::now()->format('d-m-Y')],['batch_end','>=',Carbon::now()->format('d-m-Y')]])->get();
            foreach ($batch_ongoing as $batch_ongoing) {
                foreach ($batch_ongoing->candidatesmap as $bt_can_map) {
                   $ongoing_candidate += CenterCandidateMap::where('id',$bt_can_map->candidate_id)->get()->count();
                
                }
            }
            //End Ongoing Batch
            //Trained Batch
            $batch_trained=Batch::where([['f_year','=',$request->financial_year],['scheme_id','=',$request->scheme],['id','=',$agBatch->bt_id],['batch_end','<',Carbon::now()->format('d-m-Y')]])->get();
            foreach ($batch_trained as $batch_trained) {
                foreach ($batch_trained->candidatesmap as $bt_can_map) {
                   $trained_candidate += CenterCandidateMap::where('id',$bt_can_map->candidate_id)->get()->count();
                
                }
            }
            //End Trained Batch

            // Batch Assessed
            $batch_assessed=Batch::where([['f_year','=',$request->financial_year],['scheme_id','=',$request->scheme],['id','=',$agBatch->bt_id],['assessment','<',Carbon::now()->format('d-m-Y')]])->get();
            foreach ($batch_assessed as $batch_assessed) {
                foreach ($batch_assessed->candidatesmap as $bt_can_map) {
                   $assessed_candidate += CenterCandidateMap::where('id',$bt_can_map->candidate_id)->get()->count();
                    //Candidate Passed
                    $passed_candidate += CenterCandidateMap::where([['passed','=',1],['id','=',$bt_can_map->candidate_id]])->get()->count();
                    //End Candidate Passed
                    //Candidate Failed
                    $failed_candidate += CenterCandidateMap::where([['passed','=',0],['id','=',$bt_can_map->candidate_id]])->get()->count();
                    //End Candidate failed
                    //Candidate Absent
                    $absent_candidate += CenterCandidateMap::where([['passed','=',2],['id','=',$bt_can_map->candidate_id]])->get()->count();
                    //End Candidate Absent  
                
                }
            }
            //End Batch Assessed
          
        }

        $candidate_stack[$agency->agency_name]=[
                                                $enroll_candidate,
                                                $ongoing_candidate,
                                                $trained_candidate,
                                                $assessed_candidate,
                                                $passed_candidate,
                                                $failed_candidate,
                                                $absent_candidate
                                                ];
    }
    
    return view('admin.mis.agency-summary')->with(compact('candidate_stack','scheme','sel_scm','sel_yr'));


    }
}
