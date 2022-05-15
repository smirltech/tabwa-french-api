@extends('layouts.app')

@section('content')
 <div class="container">
  <h2 class="">Dashboard</h2>
  <ul class="breadcrumb">
   <li class="breadcrumb-item"><a href="/">Accueil</a></li>
   <li class="breadcrumb-item"><a href="/lexics">List des Mots</a></li>
   <li class="breadcrumb-item">Ajouter Mot</li>
  </ul>
  <div class="container">
   <div class="card">
    <div class="card-header">
     <span class="card-title w3-xlarge">Création de Nouveau Mot</span>

    </div>
    <div class="card-body">
     {!! Form::open(['action'=>'LexicsController@store', 'methode'=>'POST']) !!}
     <div class="form-group">
      {{Form::label('word', 'Mot')}}
      {{Form::text('word', '', ['class'=>'form-control', 'placeholder'=>"Mot Nouveau"])}}
     </div>
     <div class="form-group">
      {{Form::label('categorie', 'Categorie')}}
      {{Form::select('categorie', ['français'=>'français', 'tabwa'=>'tabwa'], '', ['class'=>'form-control'])}}
     </div>
     {{Form::submit('Créer', ['class'=>'btn btn-primary'])}}
     {!! Form::close() !!}
  </div>
   </div>
  </div>
 </div>
@endsection
