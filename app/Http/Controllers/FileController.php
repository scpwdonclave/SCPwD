<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Candidate;
use Exception;
use Auth;

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
            return response()->download(storage_path("app/files/{$fileurl->$column}"));
        } catch (Exception $e) {
            return abort(404);
        }
    }

    protected function viewThis($id, $file){
        $column = ($file === 'doc')?'doc_file':'d_cert';
        $fileurl = Candidate::where('id', $id)->select($column)->firstOrFail();
        try {
            return response()->file(storage_path("app/files/{$fileurl->$column}"));
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

}
