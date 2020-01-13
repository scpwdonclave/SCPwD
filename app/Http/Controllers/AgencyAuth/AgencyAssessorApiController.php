<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;

class AssessorApiController extends Controller
{
    
    public function assessorApi(Request $request){
        if (Auth::guard('admin')->check() || Auth::guard('agency')->check()) {

            if ($request->section=='mobile') {
                if($request->has('aa_id')){
                $validator = Validator::make($request->all(), [ 
                  
                    'checkredundancy' => [
                        'required',
                        'numeric',
                        'unique:trainers,mobile',
                        'unique:partners,spoc_mobile',
                        'unique:centers,mobile',
                        'unique:trainer_statuses,mobile',
                        'unique:agencies,mobile',
                        'unique:assessors,mobile,'.$request->as_id,
                        
                    ],
                ]);
                }else{
                    $validator = Validator::make($request->all(), [ 
                  
                        'checkredundancy' => [
                            'required',
                            'numeric',
                            'unique:trainers,mobile',
                            'unique:partners,spoc_mobile',
                            'unique:centers,mobile',
                            'unique:trainer_statuses,mobile',
                            'unique:agencies,mobile',
                            'unique:assessors,mobile',
                            
                        ],
                    ]); 
                }
    
                if ($validator->fails()) {
                    return response()->json(['success' => false, 'errors'=>$validator->errors()]);
                } else {
                    return response()->json(['success' => true], 200);
                }
            
            }
            else if ($request->section=='email') {
                if($request->has('aa_id')){
                $validator = Validator::make($request->all(), [ 
                  
                    'checkredundancy' => [
                        'required',
                        'unique:admins,email',
                        'unique:trainers,email',
                        'unique:partners,email',
                        'unique:centers,email',
                        'unique:trainer_statuses,email',
                        'unique:agencies,email',
                        'unique:assessors,email,'.$request->aa_id,
                    ],
                ]);
                
                }else{
                    $validator = Validator::make($request->all(), [ 
                  
                        'checkredundancy' => [
                            'required',
                            'unique:admins,email',
                            'unique:trainers,email',
                            'unique:partners,email',
                            'unique:centers,email',
                            'unique:trainer_statuses,email',
                            'unique:agencies,email',
                            'unique:assessors,email',
                        ],
                    ]);
                }
    
                if ($validator->fails()) {
                    return response()->json(['success' => false, 'errors'=>$validator->errors()]);
                } else {
                    return response()->json(['success' => true], 200);
                }
            
            }
            else if ($request->section=='aadhaar') {
                if($request->has('aa_id')){
                $validator = Validator::make($request->all(), [ 
                   'checkredundancy' => [
                        'required',
                        'unique:trainers,doc_no',
                        'unique:trainer_statuses,doc_no',
                        'unique:agencies,aadhaar',
                        'unique:assessors,aadhaar,'.$request->aa_id,
                        
                    ],
                ]);
                    
                }else{
                    $validator = Validator::make($request->all(), [ 
                        'checkredundancy' => [
                             'required',
                             'unique:trainers,doc_no',
                             'unique:trainer_statuses,doc_no',
                             'unique:agencies,aadhaar',
                             'unique:assessors,aadhaar',
                             
                         ],
                     ]);
                }
    
                if ($validator->fails()) {
                    return response()->json(['success' => false, 'errors'=>$validator->errors()]);
                } else {
                    return response()->json(['success' => true], 200);
                }
            
            }
        }


    }
}
