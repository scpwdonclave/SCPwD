<?php

namespace App\Http\Controllers\Partner;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Auth;

class FileController extends Controller
{
    protected $redirectTo = '/partner/login';    

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

    public function partnerFiles($file)
    {
            if (Auth::guard('admin')->check()) {
                return $this->downloadThis($file);
            } else {
                if (basename(Auth::guard('partner')->user()->incorp_doc) === $file) {
                    return $this->downloadThis($file);
                } else {
                    return 'Unauthorized Access';
                }
            }
    }
}
