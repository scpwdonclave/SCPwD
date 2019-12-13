<?php

namespace App\Http\Controllers\PartnerAuth;

use Auth;
use Exception;
use App\Trainer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function __construct()
    {
        
    }

    protected function downloadThis($file){
        try {
            return Storage::disk('myDisk')->download("partners/{$file}");
        } catch (Exception $e) {
            return abort(404);
        }
    }

    protected function viewThis($file){
        try {
            return Storage::disk('myDisk')->response("partners/{$file}");
        } catch (Exception $e) {
            return abort(404);
        }
    }
    protected function downloadThisTrainer($file){
        try {
            return Storage::disk('myDisk')->download("trainers/{$file}");
        } catch (Exception $e) {
            return abort(404);
        }
    }
    
    protected function viewThisTrainer($file){
        try {
            return Storage::disk('myDisk')->response("trainers/{$file}");
        } catch (Exception $e) {
            return abort(404);
        }
    }

    public function partnerFiles($action, $file)
    {
        if (Auth::guard('admin')->check()) {
            if ($action === 'view') {
                return $this->viewThis($file);
            } elseif ($action === 'download') {
                return $this->downloadThis($file);
            }
        } else {
            return abort(401);
        }
    }

    public function partnerRequirement()
    {
        if (Auth::guard('admin')->check() || Auth::guard('partner')->check()) {
            try {
                return Storage::disk('myDisk')->download("Requirements.xlsx");
            } catch (Exception $e) {
                return abort(404);
            }
        } else {
            return abort(401);
        }
    }



    public function trainerFiles($id, $action, $file){
        if (Auth::guard('partner')->check()) {
            $partner = Auth::guard('partner')->user();
            $trainer = Trainer::findOrFail($id);
            if ($partner->can('partner-has-access-to-file', [$file, $trainer])) {
                if ($action === 'view') {
                    return $this->viewThisTrainer($file);
                } elseif ($action === 'download') {
                    return $this->downloadThisTrainer($file);
                }
            } else {
                return abort(401);
            }
        }

        if (Auth::guard('admin')->check()) {
            if ($action === 'view') {
                return $this->viewThisTrainer($file);
            } elseif ($action === 'download') {
                return $this->downloadThisTrainer($file);
            }
        }
    }
}
