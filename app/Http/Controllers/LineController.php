<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LineController extends Controller
{
    public function index(){
        return response('Hello World', 200);
    }
}
