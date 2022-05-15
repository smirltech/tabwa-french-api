@extends('layouts.app')

@section('content')
 <div class="container">
  <h2 class="">Dashboard</h2>
  <ul class="breadcrumb">
   <li class="breadcrumb-item"><a href="/">Accueil</a></li>
   <li class="breadcrumb-item">Liste des Mots</li>
  </ul>
  <div class="container">
   <div class="card">
    <div class="card-header">
     <span class="card-title w3-xlarge">Les Mots</span>
     <a href="/lexics/create" class="btn btn-default float-right"><span class="fa fa-plus"></span></a>

    </div>
    <div class="card-body">
   @if(count($lexics)>0)
   <div class="table-responsive">
    <table class="table table-striped table-bordered">
     <thead>
     <tr>
      <th style="width: 5px">No.</th>
      <th>Mot</th>
      <th>Categorie</th>
      <th>Ajouté par</th>
      <th colspan="2" class="w3-center">Actions</th>

     </tr>
     </thead>
     <tbody>
      @foreach($lexics as $idx=>$lexic)
     <tr>
      <td class="text-right">{{$idx + 1}}</td>
      <td>{{$lexic->word}}</td>
      <td>{{$lexic->categorie}}</td>
      <td>{{$lexic->user->name}}</td>
      <td style="width: 50px"><a href="/lexics/{{$lexic->id}}/edit" class="btn btn-warning"><span class="fa fa-edit"> Modifier</span></a></td>
      <td style="width: 50px"><button onclick="passId('{{$lexic->id}}')" class="btn btn-danger" data-toggle="modal" data-target="#lModal"><span class="fa fa-eraser"> Supprimer</span></button></td>
     </tr>
      @endforeach
     </tbody>
    </table>
    {{$lexics->links()}}
   </div>
   @else
    <div>
     <p>Il n'y a pas de mots enregistrés pour l'instant</p>
    </div>
   @endif
  </div>
   </div>
  </div>
 </div>
@endsection


<!-- The Modal -->
<div class="modal" id="lModal">
 <div class="modal-dialog">
  <div class="modal-content">

   <!-- Modal Header -->
   <div class="modal-header">
    <h4 class="modal-title">Suppression de Mot</h4>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
   </div>

   <!-- Modal body -->
   <div class="modal-body">
    {!! Form::open(['action'=>['LexicsController@destroy', ''], 'id'=>'lform','method'=>'POST']) !!}
    <div><h5>Etes-vous sur de vouloir supprimer ce mot ?</h5></div>
    {{Form::hidden('_method', 'DELETE')}}
    {{Form::submit('Supprimer', ['class'=>'btn btn-danger'])}}
    {!! Form::close() !!}
   </div>
  </div>
 </div>
</div>

<script>
 function passId(id){
  $('#lform').attr({
   "action":"/lexics/"+id
  })
 }
</script>
