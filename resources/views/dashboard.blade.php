@extends('layouts.app')

@section('content')
 <div class="container-fluid">
  <h2 class="">Dashboard</h2>
  <div class="jumbotron jumbotron-fluid">
   <div class="container align-content-center">
    <div class="row">
     <div class="col-4">
      <div class="card">
       <div class="card-body">
        <h1 class="text-right">{{number_format(count($users))}}</h1>
       </div>
       <footer class="card-footer">
        <h5 class="text-center">Admins</h5>
       </footer>
      </div>
     </div>
     <div class="col-4">
      <div class="card">
       <div class="card-body">
        <h1 class="text-right">{{number_format(count($words))}}</h1>
       </div>
       <footer class="card-footer">
        <h5 class="text-center">Lexics</h5>
       </footer>
      </div>
     </div>
     <div class="col-4">
      <div class="card">
       <div class="card-body">
        <h1 class="text-right">{{number_format(2900400)}}</h1>
       </div>
       <footer class="card-footer">
        <h5 class="text-center">Utilisateurs</h5>
       </footer>
      </div>
     </div>
    </div>
   </div>
  </div>
 </div>
@endsection
