<?php

namespace App\Http\Controllers;
use App\Models\company;
use App\Models\branch;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
      $user = auth()->user();
      $companies=Company::all();
      $branches=Branch::all();
             return view('admin.dashboard.index', ['user' => $user,'companies'=>$companies,'branches'=>$branches]);
    }
}
