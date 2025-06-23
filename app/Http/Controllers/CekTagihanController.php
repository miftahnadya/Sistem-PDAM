<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CekTagihanController extends Controller
{
    public function index()
    {
        return view('cektagihan');
    }
}