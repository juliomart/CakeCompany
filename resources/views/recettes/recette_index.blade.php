@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h2>Liste des Recettes</h2></div>
                <div class="panel-body">

                    {{--message--}}
                    @if(Session::has('message'))
                        <div class="alert alert-info">
                            {{ Session::get('message') }}
                        </div>
                    @endif

                    <form class="form-horizontal" role="form" method="GET" action="/recette">
                        {{ csrf_field() }}

                        @foreach($recette_list as $recette)

                        <div class="list-group ">

                            <div class="col-md-7 col-md-offset-2">
                            <a href="/recette/{{$recette->id}}/show" class="list-group-item "> {{$recette->nom}} </a>
                            </div>

                            <div>
                                <br>
                                <br>
                            </div>

                        </div>
                        <!-- Fin ListGroup -->

                        @endforeach

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-7">
                                <a href="/recette/create" class="btn btn-primary">Ajouter une recette</a>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
