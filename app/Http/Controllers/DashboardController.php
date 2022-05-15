<?php

namespace App\Http\Controllers;


use App\User;
use App\Word;
use Illuminate\Http\Request;

class DashboardController extends Controller {
 /**
  * Create a new controller instance.
  *
  * @return void
  */
 public function __construct() {
  $this->middleware('auth');
 }

 /**
  * Show the application dashboard.
  *
  * @return \Illuminate\Http\Response
  */
 public function index() {
  $user_id = auth()->user()->id;
  $user = User::find($user_id);
  $data['user'] = $user;
  $data['users'] = User::all();
  $data['words'] = Word::all();
  return view('dashboard')->with($data);
 }
}
