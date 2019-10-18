@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h2>Recette de {{$recettes->nom}}</h2></div>
                <div class="panel-body">

                    {{--message--}}
                    @if(Session::has('message'))
                        <div class="alert alert-info">
                            {{ Session::get('message') }}
                        </div>
                    @endif

                    <form class="form-horizontal" role="form" method="POST" action="/recette/{{$recettes->id}}/up">
                        {{ csrf_field() }}

                        <input id="nom" type="text" class="form-control hidden" name="nom" value="{{$recettes->nom}}" >

                    <div class="form-group ">
                        <label for="select" class="col-md-3 control-label">Ingrédients</label>
                        <div class="col-md-8 ">

                        @foreach($recettes->ingredients as $rec)
                        <div class="{{ $loop->iteration }}">
                            <div class="col-md-4">
                                <input id="ingredient_id" type="hidden" class="form-control" name="ingredient_id[]" value="{{$rec->id}}">
                                <input id="ingredient_nom" type="text" class="form-control" name="ingredient_nom[]" value="{{$rec->nom}}" disabled>
                            </div>
                            <div class="col-md-3">
                                <input id="qte" type="text" class="form-control" name="qte[]" value="{{$rec->pivot->qte}}">
                            </div>
                            <div class="col-md-2">
                                <div hidden> {{ $loop->iteration }}</div>
                                <input id="unite_id" type="text" class="form-control" name="unite_id[]" value="{{$rec->unites->type}}" disabled>
                            </div>
                                <div class="col-md-1">
                                    <a class="remove_line btn btn-danger btn-circle" data-target="{{ $loop->iteration }}">
                                        <i class="fa fa-fw fa-minus"></i>
                                    </a>
                                </div>
                        </div>
                        @endforeach

                        </div>

                        <div class="ingredient_div col-md-12">
                            <label for="select" class="col-md-3 control-label">
                            </label>

                            <div class="col-md-3">
                                <select class="form-control" id="ingredient_id2" name="ingredient_id2[]">
                                    <option></option>
                                    @foreach($ingredients as $ingredient)
                                        <option value="{{$ingredient->id}}">
                                            {{$ingredient->nom}}
                                        </option>
                                        <div id="unite_id" name="unite_id" value="{{$ingredient->unite_id}}" ></div>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2">
                                <input id="qte2" name="qte2[]" class="form-control"/>
                            </div>

                            {{--<div class="col-md-2">--}}
                                {{--<div id="unite_jq" name="unite_jq" class="form-control"></div>--}}
                            {{--</div>--}}
                        </div>

                            <div class="col-md-1">
                                <a class="add_line btn btn-info btn-circle" data-target="ingredient_div">
                                    <i class="fa fa-fw fa-plus"></i>
                                </a>
                            </div>
                        </div>

                        <hr>

                        <div class="form-group">
                            <label for="textarea" class="col-md-3 control-label">Preparation</label>

                            <div class="col-md-7">
                                <textarea id="mode" type="text" class="form-control" name="mode_preparation" rows="6" >{{$recettes->mode_preparation}}
                                </textarea>
                            </div>
                        </div>

                        <hr>

                        <div class="form-group">
                            <label for="temps" class="col-md-3 control-label">Temps de preparation</label>
                            <div class="col-md-2">
                                <input id="temp" type="time" class="form-control" name="temp" value="{{$recettes->temp}}" >
                            </div>

                            <label for="qte_recette" class="col-md-3 control-label">Quantité par recette</label>
                            <div class="col-md-2">
                                <input id="qte_recette" class="form-control" name="qte_recette" value="{{$recettes->qte_recette}}" >
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="cout_heure" class="col-md-3 control-label">Coût par heure</label>
                            <div class="col-md-2">
                                <input id="cout_heure" class="form-control" name="cout_heure" value="{{$recettes->cout_heure}} €">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="cout" class="col-md-3 control-label">Coût de la recette</label>
                            <div class="col-md-2">
                                <input id="cout" class="form-control" name="cout" value="{{$cout_total}} €" disabled>
                            </div>

                            <label for="cout" class="col-md-3 control-label">Prix final</label>
                            <div class="col-md-2">
                                <input id="prix" class="form-control" name="prix" value="{{$recettes->prix_final}} €" disabled>
                            </div>
                        </div>

                        {{--button--}}
                        <div class="form-group">
                            <div class="col-md-2 ">
                                <button type="submit" name="" class="btn btn-info">Modifier
                                </button>
                            </div>

                            <div class="col-md-2 col-md-offset-6">
                                <button type="button" name="" onclick="openModal()" class="btn btn-danger">Effacer
                                </button>
                            </div>

                            {{-- Modal --}}
                            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="ModalLabel">Effacer {{$recettes->nom}}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">X</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Êtes-vous sûr de vouloir supprimer cette recette de {{$recettes->nom}}?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-info" data-dismiss="modal">Non</button>
                                            <a href="/recette/{{$recettes->id}}/delete" class="btn btn-danger">Oui</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- Fin Modal --}}
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
</div>
@endsection
