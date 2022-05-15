@extends('layouts.app')

@section('content')
 <div class="container">
  <h2 class="">Dashboard</h2>
  <ul class="breadcrumb">
   <li class="breadcrumb-item"><a href="/">Accueil</a></li>
   <li class="breadcrumb-item">Liste des Types</li>
  </ul>
  <div class="container">
   <div class="card">
    <div class="card-header">
     <span class="card-title w3-xlarge">Les Types</span>
     <a href="/types/create" class="btn btn-default float-right"><span class="fa fa-plus"></span></a>

    </div>
    <div class="card-body">
   @if(count($types)>0)
   <div class="table-responsive">
    <table class="table table-striped table-bordered">
     <thead>
     <tr>
      <th style="width: 5px">No.</th>
      <th>Type</th>
      <th>Abreviation</th>
      <th colspan="2" class="w3-center">Actions</th>

     </tr>
     </thead>
     <tbody>
      @foreach($types as $idx=>$type)
     <tr>
      <td class="text-right">{{$idx + 1}}</td>
      <td>{{$type->type}}</td>
      <td>{{$type->abbrev}}</td>
      <td style="width: 50px"><a href="/types/{{$type->id}}/edit" class="btn btn-warning"><span class="fa fa-edit"> Modifier</span></a></td>
      <td style="width: 50px"><button onclick="passId('{{$type->id}}')" class="btn btn-danger" data-toggle="modal" data-target="#tModal"><span class="fa fa-eraser"> Supprimer</span></button></td>
     </tr>
      @endforeach
     </tbody>
    </table>
    {{$types->links()}}
   </div>
   @else
    <div>
     <p>Il n'y a pas de type enregistré pour l'instant</p>
    </div>
   @endif
  </div>
   </div>
  </div>
 </div>
@endsection


<!-- The Modal -->
<div class="modal" id="tModal">
 <div class="modal-dialog">
  <div class="modal-content">

   <!-- Modal Header -->
   <div class="modal-header">
    <h4 class="modal-title">Suppression de Type</h4>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
   </div>

   <!-- Modal body -->
   <div class="modal-body">
    {!! Form::open(['action'=>['TypesController@destroy', ''], 'id'=>'tform','method'=>'POST']) !!}
    <div><h5>Etes-vous sur de vouloir supprimer ce type ?</h5></div>
    {{Form::hidden('_method', 'DELETE')}}
    {{Form::submit('Supprimer', ['class'=>'btn btn-danger'])}}
    {!! Form::close() !!}
   </div>
  </div>
 </div>
</div>

<script>
 function passId(id){
  $('#tform').attr({
   "action":"/types/"+id
  })
 }
</script>
