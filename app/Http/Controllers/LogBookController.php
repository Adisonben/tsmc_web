<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogBookController extends Controller
{
    //
    public function index() {
        return view('logbook.carMATable');
    }

    public function create(){
        return view('logbook.carMAForm');
    }

    public function logbookTable() {
        return view('logbook.logBookTable');
    }

    public function logbookCreate() {
        return view('logbook.logBookForm');
    }
}
