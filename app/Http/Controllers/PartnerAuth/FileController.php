<?php

namespace App\Http\Controllers\PartnerAuth;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Auth; 

class FileController extends Controller
{
    protected $redirectTo = '/partner';    

    public function __construct()
    {
        $this->middleware('auth:admin,partner');
    }

    protected function downloadThis($file){
        try {
            return response()->file(storage_path("app/files/partners/{$file}"));
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

    public function partnerFiles($action, $file)
    {
        if ($action === 'view' && Auth::guard('admin')->check()) {
            return $this->viewThis($file);
        } elseif ($action === 'download' && Auth::guard('admin')->check()) {
            return $this->downloadThis($file);
        } else {
            return 'Unauthorized Access Or File is Not Found On Server';
        }
    }
}
