<?php

namespace App\Http\Controllers\PartnerAuth;

use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use App\Trainer;
use Auth;

class FileController extends Controller
{
    public function __construct()
    {
        
    }

    protected function downloadThis($file){
        try {
            return response()->download(storage_path("app/files/partners/{$file}"));
        } catch (Exception $e) {
            return abort(404);
        }
    }

    protected function viewThis($file){
        try {
            return response()->file(storage_path("app/files/partners/{$file}"));
        } catch (Exception $e) {
            return abort(404);
        }
    }
    protected function downloadThisTrainer($file){
        try {
            return response()->download(storage_path("app/files/trainers/{$file}"));
        } catch (Exception $e) {
            return abort(404);
        }
    }

    protected function viewThisTrainer($file){
        try {
            return response()->file(storage_path("app/files/trainers/{$file}"));
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
                return response()->download(storage_path("app/Requirements.xlsx"));
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
