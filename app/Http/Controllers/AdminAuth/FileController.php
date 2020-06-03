<?php

namespace App\Http\Controllers\AdminAuth;

use Auth;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{

    public function __construct()
    {
        $this->middleware(['admin']);
    }

    public function schemeFiles($logo)
    {
        
        try {
            return Storage::disk('public')->response("adminscheme/{$logo}");
        } catch (Exception $e) {
            return abort(404);
        }
    }

    public function toaFiles($file)
    {
        try {
            return Storage::disk('myDisk')->download("toa/{$file}");
        } catch (Exception $e) {
            return abort(404);
        }
    }


    public function placementFile($id, $file)
    {
        try {
            return Storage::disk('myDisk')->download("placement/{$file}");
        } catch (Exception $e) {
            return abort(404);
        }
    }

    public function oldDocumentDownload($folder,$document){
        try {
            return Storage::disk('myDisk')->download("Old_MIS/{$folder}/{$document}");
        } catch (Exception $e) {
            return abort(404);
        }
    }
}
