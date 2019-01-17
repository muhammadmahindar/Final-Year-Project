<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TestingController extends Controller {
    public function test() {
        return response()
            ->view('test')
            ->header('Referrer-Policy','no-referrer');
    }
}
