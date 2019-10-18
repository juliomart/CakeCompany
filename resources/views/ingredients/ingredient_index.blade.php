@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h2>Stock d'ingrédients</h2></div>
                <div class="panel-body">

                    {{--message--}}
                    @if(Session::has('message'))
                        <div class="alert alert-info">
                            {{ Session::get('message') }}
                        </div>
                    @endif
                    {{--message2--}}
                    @if(Session::has('message_danger'))
                        <div class="alert alert-danger">
                            {{ Session::get('message_danger') }}
                        </div>
                    @endif

                    <form class="form-horizontal" role="form" method="GET" action="/ingredient/">
                        {{ csrf_field() }}

                        @foreach($ingredient_list as $ingredient)

                        <div class="list-group col-md-offset-2">

                            <div class="col-md-5">
                            <a href="/ingredient/{{$ingredient->id}}/show" class="list-group-item "> {{$ingredient->nom}}</a>
                            </div>
                            <div class="col-md-2">
                            <a href="/ingredient/{{$ingredient->id}}/show" class="list-group-item "> {{$ingredient->qte_stock}}</a>
                            </div>
                            <div class="col-md-2">
                            <a href="/ingredient/{{$ingredient->id}}/show" class="list-group-item "> {{$ingredient->unites->type}}</a>
                            </div>
                            <br><br>

                        </div>

                        @endforeach
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-8">
                                <a href="/ingredient/create" class="btn btn-info">Ajouter un ingrédient</a>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
