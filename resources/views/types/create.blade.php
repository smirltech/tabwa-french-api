@extends('layouts.app')

@section('content')
 <div class="container">
  <h2 class="">Dashboard</h2>
  <ul class="breadcrumb">
   <li class="breadcrumb-item"><a href="/">Accueil</a></li>
   <li class="breadcrumb-item"><a href="/types">List des Types</a></li>
   <li class="breadcrumb-item">Ajouter Type</li>
  </ul>
  <div class="container">
   <div class="card">
    <div class="card-header">
     <span class="card-title w3-xlarge">Création de Nouveau Type</span>

    </div>
    <div class="card-body">
     {!! Form::open(['action'=>'TypesController@store', 'methode'=>'POST']) !!}
     <div class="form-group">
      {{Form::label('type', 'Type')}}
      {{Form::text('type', '', ['class'=>'form-control', 'placeholder'=>"Nom du Type"])}}
     </div>
     <div class="form-group">
      {{Form::label('abbrev', 'Abréviation')}}
      {{Form::text('abbrev', '', ['class'=>'form-control', 'placeholder'=>"Abréviation du Type"])}}
     </div>
     {{Form::submit('Créer', ['class'=>'btn btn-primary'])}}
     {!! Form::close() !!}
  </div>
   </div>
  </div>
 </div>
@endsection
