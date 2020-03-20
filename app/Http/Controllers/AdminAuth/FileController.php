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


    public function placementFile($id, $file)
    {
        if ($file === 'zip') {
            return 'Woking on It';
        } else {
            try {
                return Storage::disk('myDisk')->download("placement/{$file}");
            } catch (Exception $e) {
                return abort(404);
            }
        }
    }

    public function oldDocumentDownload($document){
        if (Auth::guard('admin')->check() ) {
            try {
                return Storage::disk('myDisk')->download($document);
            } catch (Exception $e) {
                return abort(404);
            }
        } else {
            return abort(401);
        }
    }
}
