@extends('layouts.app')

@section('content')
 <div class="container">
  <h2 class="">Dashboard</h2>
  <ul class="breadcrumb">
   <li class="breadcrumb-item"><a href="/">Accueil</a></li>
   <li class="breadcrumb-item"><a href="/lexics">List des Mots</a></li>
   <li class="breadcrumb-item">Modifier Mot</li>
  </ul>
  <div class="container">
   <div class="card">
    <div class="card-header">
     <span class="card-title w3-xlarge">Modification de Mot : <strong>{{$lexic->word}}</strong></span>
     <div class="small">par : <strong>{{$lexic->user->name}}</strong></div>
    </div>
    <div class="card-body">
     {!! Form::open(['action'=>['LexicsController@update', $lexic->id], 'methode'=>'POST']) !!}
     <div class="form-group">
      {{Form::label('word', 'Mot')}}
      {{Form::text('word', $lexic->word, ['class'=>'form-control', 'placeholder'=>"Mot à Modifier"])}}
     </div>
     <div class="form-group">
      {{Form::label('categorie', 'Categorie')}}
      {{Form::select('categorie', ['français'=>'français', 'tabwa'=>'tabwa'], $lexic->categorie, ['class'=>'form-control'])}}
     </div>
     {{Form::hidden('_method', 'PUT')}}
     {{Form::submit('Modifier', ['class'=>'btn btn-warning'])}}
     {!! Form::close() !!}
    </div>
   </div>
  </div>
  <div class="container mt-2">
   <div class="card">
    <div class="card-header">
     <span class="card-title w3-xlarge">Les Traductions</span>
     <button class="btn btn-default float-right" data-toggle="modal" data-target="#tModal"><span
        class="fa fa-plus"></span></button>
    </div>
    <div class="card-body">
     <table class="table table-bordered table-striped">
      <thead class="table-dark">
      <tr>
       <th style="width: 5px"></th>
       <th>TYPE</th>
       <th>TRADUCTION</th>
       <th>EXEMPLE</th>
       <th>EXEMPLE TRADUIT</th>
       <th class="w3-center" colspan="2">ACTION</th>
      </tr>
      </thead>
      <tbody>
      @if(count($translations)> 0)
       @foreach($translations as $idx=>$translation)
        {!! Form::open(['action'=>['TranslationsController@update', $translation->id], 'methode'=>'POST']) !!}
        <tr>
         <td>
          <div class="form-group">
           <div class="form-control">
            {{$idx + 1}}
           </div>
          </div>
         </td>
         <td>
          <div class="form-group">
           {{Form::select('type_id', $types, $translation->type_id, ['class'=>'form-control'])}}
          </div>
         </td>
         <td>
          <div class="form-group">
           {{Form::text('translation', $translation->translation, ['class'=>'form-control', 'placeholder'=>"Mot traduit"])}}
          </div>
         </td>
         <td>
          <div class="form-group">
           {{Form::text('example', $translation->example, ['class'=>'form-control', 'placeholder'=>"Exemple"])}}
          </div>
         </td>
         <td>
          <div class="form-group">
           {{Form::text('example_translation', $translation->example_translation, ['class'=>'form-control', 'placeholder'=>"Exemple traduit"])}}
          </div>
         </td>
         <td>
          {{Form::submit('Modifier', ['class'=>'btn btn-warning'])}}
         </td>
         <td>
          <div class="form-group">
           <button onclick="passTid('{{$translation->id}}')" type="button" class="btn btn-danger form-control"
                   data-toggle="modal" data-target="#tdModal">Supprimer
           </button>
          </div>
         </td>
        </tr>
        {{Form::hidden('_method', 'PUT')}}
        {!! Form::close() !!}
       @endforeach
      @endif
      </tbody>
     </table>
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
    <h4 class="modal-title">Suppression de Mot</h4>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
   </div>

   <!-- Modal body -->
   <div class="modal-body">
    {!! Form::open(['action'=>'TranslationsController@store','method'=>'POST']) !!}
    <div class="form-group">
     {{Form::label('translation', 'Traduction')}}
     {{Form::text('translation', '', ['class'=>'form-control', 'placeholder'=>"Mot traduit"])}}
    </div>
    <div class="form-group">
     {{Form::label('type_id', 'Type')}}
     {{Form::select('type_id', $types, '', ['class'=>'form-control'])}}
    </div>
    <div class="form-group">
     {{Form::label('example', 'Exemple')}}
     {{Form::text('example', '', ['class'=>'form-control', 'placeholder'=>"Exemple"])}}
    </div>
    <div class="form-group">
     {{Form::label('example_translation', "Traduction d'exemple")}}
     {{Form::text('example_translation', '', ['class'=>'form-control', 'placeholder'=>"Exemple traduit"])}}
    </div>
    {{Form::hidden('word_id', $lexic->id)}}
    {{Form::submit('Ajouter', ['class'=>'btn btn-default'])}}
    {!! Form::close() !!}
   </div>
  </div>
 </div>
</div>

<!-- The Modal -->
<div class="modal" id="tdModal">
 <div class="modal-dialog">
  <div class="modal-content">

   <!-- Modal Header -->
   <div class="modal-header">
    <h4 class="modal-title">Suppression de Traduction</h4>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
   </div>

   <!-- Modal body -->
   <div class="modal-body">
    {!! Form::open(['action'=>['TranslationsController@destroy', ''], 'id'=>'tdform','method'=>'POST']) !!}
    <div><h5>Etes-vous sur de vouloir supprimer cette traduction ?</h5></div>
    {{Form::hidden('_method', 'DELETE')}}
    {{Form::submit('Supprimer', ['class'=>'btn btn-danger'])}}
    {!! Form::close() !!}
   </div>
  </div>
 </div>
</div>

<script>
 function passTid(id) {
  $('#tdform').attr({
   "action": "/translations/" + id
  })
 }
</script>

