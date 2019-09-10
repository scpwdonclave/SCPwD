<?php

namespace App\Http\Controllers\PartnerAuth;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Auth; 

class FileController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
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
        if ($action === 'view') {
            return $this->viewThis($file);
        } elseif ($action === 'download') {
            return $this->downloadThis($file);
        }
    }
}
