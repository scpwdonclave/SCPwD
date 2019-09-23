<?php

namespace App\Http\Controllers\CenterAuth;

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
            return response()->file(storage_path("app/files/centers/{$file}"));
        } catch (Exception $e) {
            return abort(404);
        }
    }

    protected function viewThis($file){
        try {
            return response()->file(storage_path("app/files/centers/{$file}"));
        } catch (Exception $e) {
            return abort(404);
        }
    }

    public function centerFiles($action, $file)
    {
        if ($action === 'view') {
            return $this->viewThis($file);
        } elseif ($action === 'download') {
            return $this->downloadThis($file);
        }
    }
}
