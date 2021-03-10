<?php

namespace App\Http\Controllers;

use Auth;
use Exception;
use App\Assessor;
use App\Complain;
use App\Candidate;
use App\ComplainFile;
use App\BatchAssessment;
use App\BatchReAssessment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{  

    

    public function __construct()
    {
        // 
    }

    protected function downloadThis($id, $file){
        $column = ($file === 'doc')?'doc_file':'d_cert';
        $fileurl = Candidate::where('id', $id)->select($column)->firstOrFail();
        try {
            return Storage::disk('myDisk')->download("{$fileurl->$column}");
        } catch (Exception $e) {
            return abort(404);
        }
    }
    protected function downloadThisAssessor($id,$column){
        //$column = ($file === 'doc')?'doc_file':'d_cert';
        $fileurl = Assessor::where('id', $id)->select($column)->firstOrFail();
        try {
            return Storage::disk('myDisk')->download("{$fileurl->$column}");
        } catch (Exception $e) {
            return abort(404);
        }
    }
    protected function downloadThisAssessment($id,$column,$type){

        $fileurl = $type ? BatchReAssessment::where('id', $id)->select($column)->firstOrFail():BatchAssessment::where('id', $id)->select($column)->firstOrFail();
       
        $headers = array(
            'Content-Type' => 'text/csv',
        );
        $ext = pathinfo($fileurl->$column, PATHINFO_EXTENSION);
        $or_f_name=$filename = pathinfo($fileurl->$column, PATHINFO_FILENAME);
       
        try {
            if($ext==='txt'){
                return Storage::disk('myDisk')->download($fileurl->$column,$or_f_name.'.csv' , $headers);
            }else{
                return Storage::disk('myDisk')->download("{$fileurl->$column}");
            }
        } catch (Exception $e) {
            return abort(404);
        }
    }
    protected function downloadThisSupport($id,$column){

        if ($column === 'attachment') {
            $fileurl = Complain::where('id', $id)->select('attachment')->firstOrFail();
        } else {
            $fileurl = ComplainFile::where('id', $id)->select($column)->firstOrFail();
        }
        try {
            return Storage::disk('myDisk')->download("{$fileurl->$column}");
        } catch (Exception $e) {
            return abort(404);
        }
    }

    protected function viewThis($id, $file){
        $column = ($file === 'doc')?'doc_file':'d_cert';
        $fileurl = Candidate::where('id', $id)->select($column)->firstOrFail();
        try {
            return Storage::disk('myDisk')->response("{$fileurl->$column}");
        } catch (Exception $e) {
            return abort(404);
        }
    }
    protected function viewThisAssessor($id,$column){
        //$column = ($file === 'doc')?'doc_file':'d_cert';
        $fileurl = Candidate::where('id', $id)->select($column)->firstOrFail();
        try {
            return Storage::disk('myDisk')->response("{$fileurl->$column}");
        } catch (Exception $e) {
            return abort(404);
        }
    }
    protected function viewThisAssessment($id,$column,$type){
        //$column = ($file === 'doc')?'doc_file':'d_cert';
        $fileurl = $type ? BatchReAssessment::where('id', $id)->select($column)->firstOrFail():BatchAssessment::where('id', $id)->select($column)->firstOrFail();
        try {
            return Storage::disk('myDisk')->response("{$fileurl->$column}");
        } catch (Exception $e) {
            return abort(404);
        }
    }
    protected function viewThisSupport($id,$column){
        //$column = ($file === 'doc')?'doc_file':'d_cert';
        $fileurl = ComplainFile::where('id', $id)->select($column)->firstOrFail();
        try {
            return Storage::disk('myDisk')->response("{$fileurl->$column}");
        } catch (Exception $e) {
            return abort(404);
        }
    }

    public function candidateFiles($action, $id, $file){

        if (Auth::guard('admin')->check() || Auth::guard('partner')->check() || Auth::guard('center')->check()) {
            if (Auth::guard('center')->check()) {
                $candidate = Candidate::findOrFail($id);
                if ($candidate->center->id != Auth::guard('center')->user()->id) {
                    return abort(401);
                } else {
                    if ($action === 'view') {
                        return $this->viewThis($id, $file);
                    } elseif ($action === 'download') {
                        return $this->downloadThis($id, $file);
                    }
                }
            }
            if (Auth::guard('partner')->check()) {
                $candidate = Candidate::findOrFail($id);
                if ($candidate->center->partner->id != Auth::guard('partner')->user()->id) {
                    return abort(401);
                } else {
                    if ($action === 'view') {
                        return $this->viewThis($id, $file);
                    } elseif ($action === 'download') {
                        return $this->downloadThis($id, $file);
                    }
                }
            }

            if (Auth::guard('admin')->check()) {
                if ($action === 'view') {
                    return $this->viewThis($id, $file);
                } elseif ($action === 'download') {
                    return $this->downloadThis($id, $file);
                }
            }
        } else {
            return abort(401);
        }

    }


    public function assessorFiles( $id, $action,$column){
        // dd($action);

        if (Auth::guard('admin')->check() || Auth::guard('agency')->check()) {
            if (Auth::guard('agency')->check()) {
                $assessor = Assessor::findOrFail($id);
                if ($assessor->agency->id != Auth::guard('agency')->user()->id) {
                    return abort(401);
                } else {
                    if ($action === 'view') {
                        return $this->viewThisAssessor($id,$column);
                    } elseif ($action === 'download') {
                        return $this->downloadThisAssessor($id,$column);
                    }
                }
            }
           

            if (Auth::guard('admin')->check()) {
                if ($action === 'view') {
                    return $this->viewThisAssessor($id,$column);
                } elseif ($action === 'download') {
                    return $this->downloadThisAssessor($id,$column);
                }
            }
        } else {
            return abort(401);
        }

    }


    public function assessmentFiles($id,$action,$column,$type){
        // dd($action);

        if (Auth::guard('admin')->check() || Auth::guard('agency')->check() || Auth::guard('assessor')->check()) {
            $batch_ass_reass = $type ? BatchReAssessment::findOrFail($id):BatchAssessment::findOrFail($id);
            
            if (Auth::guard('agency')->check()) {
                if ($type) {
                    if ($batch_ass_reass->reassessment->agencybatch->aa_id != Auth::guard('agency')->user()->id) {
                        return abort(401);
                    } else {
                        if ($action === 'view') {
                            return $this->viewThisAssessment($id,$column,$type);
                        } elseif ($action === 'download') {
                            return $this->downloadThisAssessment($id,$column,$type);
                        }
                    }
                } else {
                    if ($batch_ass_reass->batch->agencybatch->aa_id != Auth::guard('agency')->user()->id) {
                        return abort(401);
                    } else {
                        if ($action === 'view') {
                            return $this->viewThisAssessment($id,$column,$type);
                        } elseif ($action === 'download') {
                            return $this->downloadThisAssessment($id,$column,$type);
                        }
                    }
                }
                
            }
            if (Auth::guard('assessor')->check()) {
                if ($type) {
                    if ($batch_ass_reass->reassessment->assessor != Auth::guard('assessor')->user()->id) {
                        return abort(401);
                    } else {
                        if ($action === 'view') {
                            return $this->viewThisAssessment($id,$column,$type);
                        } elseif ($action === 'download') {
                            return $this->downloadThisAssessment($id,$column,$type);
                        }
                    }
                } else {
                    if ($batch_ass_reass->batch->assessorbatch->as_id != Auth::guard('assessor')->user()->id) {
                        return abort(401);
                    } else {
                        if ($action === 'view') {
                            return $this->viewThisAssessment($id,$column,$type);
                        } elseif ($action === 'download') {
                            return $this->downloadThisAssessment($id,$column,$type);
                        }
                    }
                }
                
            }
            if (Auth::guard('admin')->check()) {
                if ($action === 'view') {
                    return $this->viewThisAssessment($id,$column,$type);
                } elseif ($action === 'download') {
                    return $this->downloadThisAssessment($id,$column,$type);
                }
            }
        } else {
            return abort(401);
        }

    }

    public function supportFiles($id, $action,$column){

        if (Auth::guard('admin')->check() || Auth::guard('agency')->check() || Auth::guard('assessor')->check() || Auth::guard('partner')->check() || Auth::guard('center')->check()) {
           
            if (Auth::guard('admin')->check()) {
                if ($action === 'view') {
                    return $this->viewThisSupport($id,$column);
                } elseif ($action === 'download') {
                    return $this->downloadThisSupport($id,$column);
                }
            }

            if (Auth::guard('partner')->check()) {
                $complain_file = ComplainFile::findOrFail($id);
                if (($complain_file->complain->rel_id != Auth::guard('partner')->user()->id) || ($complain_file->complain->rel_with !='partner')) {
                    return abort(401);
                } else {
                    if ($action === 'view') {
                        return $this->viewThisSupport($id,$column);
                    } elseif ($action === 'download') {
                        return $this->downloadThisSupport($id,$column);
                    }
                }
            }

            if (Auth::guard('center')->check()) {
                $complain_file = ComplainFile::findOrFail($id);
                if (($complain_file->complain->rel_id != Auth::guard('center')->user()->id) || ($complain_file->complain->rel_with !='center')) {
                    return abort(401);
                } else {
                    if ($action === 'view') {
                        return $this->viewThisSupport($id,$column);
                    } elseif ($action === 'download') {
                        return $this->downloadThisSupport($id,$column);
                    }
                }
            }

            if (Auth::guard('agency')->check()) {
                $complain_file = ComplainFile::findOrFail($id);
                if (($complain_file->complain->rel_id != Auth::guard('agency')->user()->id) || ($complain_file->complain->rel_with !='agency')) {
                    return abort(401);
                } else {
                    if ($action === 'view') {
                        return $this->viewThisSupport($id,$column);
                    } elseif ($action === 'download') {
                        return $this->downloadThisSupport($id,$column);
                    }
                }
            }

            if (Auth::guard('assessor')->check()) {
                $complain_file = ComplainFile::findOrFail($id);
                if (($complain_file->complain->rel_id != Auth::guard('assessor')->user()->id) || ($complain_file->complain->rel_with !='assessor')) {
                    return abort(401);
                } else {
                    if ($action === 'view') {
                        return $this->viewThisSupport($id,$column);
                    } elseif ($action === 'download') {
                        return $this->downloadThisSupport($id,$column);
                    }
                }
            }

        } else {
            return abort(401);
        }

    }

}
