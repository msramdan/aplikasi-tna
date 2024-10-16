<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ErrorController extends Controller
{
    // Untuk halaman not found
    public function notFound()
    {
        return view('errors.not-found');
    }

    // Untuk halaman un-authorized
    public function unAuthorized()
    {
        return view('errors.un-authorized');
    }
}
