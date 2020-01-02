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
}
