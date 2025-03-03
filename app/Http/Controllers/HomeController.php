<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Quesioner;
use App\Models\Time;
use Illuminate\Support\Facades\Auth;

// Models
use App\User;
use App\Models\TrQuesionerAnswer;
use App\TmResult;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {

        return view('home');
    }

}
