@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h2>Ajouter un ingrédient</h2></div>
                <div class="panel-body">

                    {{--message--}}
                    @if(Session::has('message'))
                        <div class="alert alert-info">
                            {{ Session::get('message') }}
                        </div>
                    @endif

                    <form class="form-horizontal" role="form" method="POST" action="/ingredient">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="name" class="col-md-3 control-label">Ingrédient</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="nom" placeholder="nom">
                            </div>
                        </div>

                        <div class="form-group ingredient_div">

                            <label for="select" class="col-md-3 control-label">
                                Quantité
                            </label>

                            <div class="col-md-2">
                                <input id="qte_stock" name="qte_stock" class="form-control" placeholder="quantité">
                            </div>

                            <div class="col-md-2">
                                <select class="form-control " id="unite_id" name="unite_id">
                                    <option></option>

                                    @foreach($unites as $unite)
                                        <option value="{{$unite->id}}">{{$unite->type}}
                                        </option>
                                    @endforeach

                                </select>
                            </div>

                        </div>
                            <div class="form-group">

                            <label for="select" class="col-md-3 control-label">
                                Valeur
                            </label>

                            <div class="col-md-2">
                                <input id="valeur" name="valeur" class="form-control" name="valeur" placeholder="valeur">€
                                {{--TODO--}}
                                @if  ($unite->type === "gr")
                                    / kilo
                                @elseif ($unite->type === "ml")
                                    / litre
                                @else
                                    / unité
                                @endif
                            </div>

                            <div class="form-group">
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-info">
                                        Ajouter
                                    </button>
                                </div>
                            </div>
                            </div>

                    </form>
                </div>

                {{--message error--}}
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection
