<?php

namespace App\Http\Controllers;

use App\Competence;
use App\Question;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TesController extends Controller
{
    public function index()
    {
        /* $kompentensi = Competence::all();

        return response()->json($kompentensi[0]); */

        echo Auth::user()->username;
    }

    public function ambilQuestion()
    {
        $data = Question::all();

        return response()->json($data);
    }
}
