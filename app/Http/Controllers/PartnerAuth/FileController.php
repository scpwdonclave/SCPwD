<?php

namespace App\Http\Controllers\PartnerAuth;

use Auth;
use Exception;
use ZipArchive;
use App\Trainer;
use App\Placement;
use ZipStream\ZipStream;
use App\Helpers\AppHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

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

    protected function downloadThisPlacement($file, $id){
        if ($file === 'zip') {
            // $placement = Placement::find($id);
            // $download1 = Storage::disk('myDisk')->download("{$placement->payslip1}");
            // $download2 = Storage::disk('myDisk')->download("{$placement->payslip2}");
            // $download3 = Storage::disk('myDisk')->download("{$placement->payslip3}");
            return 'Woking on It';

        } else {
            try {
                return Storage::disk('myDisk')->download("placement/{$file}");
            } catch (Exception $e) {
                return abort(404);
            }
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

    public function placementFile($id, $file)
    {
        if (Auth::guard('partner')->check()) {
            if ($id=AppHelper::instance()->decryptThis($id)) {
                $placement = Placement::findOrFail($id);
                if ($placement->tp_id == Auth::guard('partner')->user()->id) {
                    return $this->downloadThisPlacement($file, $id);
                }
            }
        }
    
        return abort(403, 'You are not Authorized for this Action');
    }
}
