<?php

namespace App\Http\Controllers\AdminAuth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Auth;

class FileController extends Controller
{

    public function __construct()
    {
        $this->middleware(['admin']);
    }

    public function schemeFiles($logo)
    {
        try {
            return response()->download(storage_path("app/files/adminscheme/{$logo}"));
        } catch (Exception $e) {
            return abort(404);
        }
    }
}
