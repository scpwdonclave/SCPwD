<?php

namespace App\Http\Controllers\CenterAuth;

use Auth; 
use Exception;
use App\Center;
use App\Placement;
use App\Helpers\AppHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{

    public function __construct()
    {
        // 
    }

    protected function downloadThis($file){
        try {
            return Storage::disk('myDisk')->download("centers/{$file}");
            // return response()->download(storage_path("app/files/centers/{$file}"));
        } catch (Exception $e) {
            return abort(404);
        }
    }

    protected function viewThis($file){
        try {
            return Storage::disk('myDisk')->response("centers/{$file}");
            // return response()->file(Storage::disk('myDisk')->response("centers/{$file}"));
        } catch (Exception $e) {
            return abort(404);
        }
    }

    protected function downloadThisPlacement($file, $id){
        try {
            return Storage::disk('myDisk')->download("placement/{$file}");
        } catch (Exception $e) {
            return abort(404);
        }
    }

    public function centerFiles($action, $id, $file)
    {
        if (Auth::guard('admin')->check() || Auth::guard('partner')->check()) {
            if (Auth::guard('admin')->check()) {
                if ($action === 'view') {
                    return $this->viewThis($file);
                } elseif ($action === 'download') {
                    return $this->downloadThis($file);
                }
            } else {
                $center = Center::findOrFail($id);
                if ($center->partner->id == Auth::guard('partner')->user()->id) {
                    if ($action === 'view') {
                        return $this->viewThis($file);
                    } elseif ($action === 'download') {
                        return $this->downloadThis($file);
                    } 
                }
            }
        }
        return abort(401);

    }

    public function placementFile($id, $file)
    {
        if (Auth::guard('center')->check()) {
            if ($id=AppHelper::instance()->decryptThis($id)) {
                $placement = Placement::findOrFail($id);
                if ($placement->tc_id == Auth::guard('center')->user()->id) {
                    return $this->downloadThisPlacement($file, $id);
                }
            }
        }
    
        return abort(403, 'You are not Authorized for this Action');
    }
    
}
