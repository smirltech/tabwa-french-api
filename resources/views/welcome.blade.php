@extends('layouts.app')

@section('content')
        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
            <div class="text-center">
                <h2>Bienvenu sur la page d'accueil du Dictionnaire Tabwa-Français</h2>
                <br>
                <p>
                    Ce site est un dictionnaire qui vous permet de vous familiariser avec le français.
                    Vous pouvez aussi y trouver des mots qui vous intéressent.</p>
                <p>L'application Windows est disponible et peut être téléchargée <a href="{{url('windows-app')}}">ici</a></p>
            </div>
        </div>

@endsection
