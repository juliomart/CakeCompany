@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-9 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading"><h2>Ajouter une recette</h2></div>
                <div class="panel-body">

                    {{--message--}}
                    @if(Session::has('message'))
                        <div class="alert alert-info">
                            {{ Session::get('message') }}
                        </div>
                    @endif

                    <form class="form-horizontal" role="form" method="POST" action="/recette">
                        {{ csrf_field() }}
                    <div class="col-md-offset-1">
                        <div class="form-group">
                            <label for="name" class="col-md-3 control-label">Nom</label>

                            <div class="col-md-7">
                                <input id="name" type="text" class="form-control" name="nom" placeholder="nom">
                            </div>
                        </div>

                            <div class="form-group ingredient_div">

                                <label for="select" class="col-md-3 control-label">
                                    <div class="col-md-1">
                                        <a class="add_line btn btn-info btn-circle" data-target="ingredient_div">
                                            <i class="fa fa-fw fa-plus"></i>
                                        </a>
                                    </div>
                                    Ingrédients
                                </label>

                                <div class="col-md-3">
                                    <select class="form-control " id="ingredient_id" name="ingredient_id[]">
                                        <option></option>
                                        @foreach($ingredients as $ingredient)
                                                <option value="{{$ingredient->id}}">
                                                    {{$ingredient->nom}}
                                                </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <input id="qte" name="qte[]" class="form-control" placeholder="qte">
                                </div>

                            </div>

                        <div class="form-group">
                            <label for="Textarea"class="col-md-3 control-label">Preparation </label>
                            <div class="col-md-7">
                                <textarea  id="mode" type="text" class="form-control" name="mode_preparation" rows="5" ></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="temps" class="col-md-3 control-label">Temps de preparation</label>

                            <div class="col-md-2">
                                <input id="temps" type="time" class="form-control" name="temp" placeholder="hh:mm:ss">
                            </div>

                            <label for="qte_recette" class="col-md-3 control-label">Quantité par recette</label>
                            <div class="col-md-2">
                                <input id="qte_recette" class="form-control" name="qte_recette" placeholder="Quantité" >
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="cout_heure" class="col-md-3 control-label">Coût par heure</label>
                            <div class="col-md-2">
                                <input id="cout_heure" class="form-control" name="cout_heure" placeholder=" €">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-0">
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
