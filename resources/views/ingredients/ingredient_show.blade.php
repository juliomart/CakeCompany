@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h2>{{$ingredient->nom}}</h2></div>
                <div class="panel-body">

                    {{--message--}}
                    @if(Session::has('message'))
                        <div class="alert alert-info">
                            {{ Session::get('message') }}
                        </div>
                    @endif

                    <form class="form-horizontal" role="form" method="POST" action="/ingredient/{{$ingredient->id}}/up">
                        {{ csrf_field() }}

                        <div class="form-group ingredient_div">

                            <label for="select" class="col-md-3 control-label">
                                Quantité
                            </label>

                            <div class="col-md-2">
                                <input id="qte_stock" name="qte_stock" class="form-control" value={{$ingredient->qte_stock}}>
                            </div>

                            <div class="col-md-2">
                                <input class="form-control " id="unite_id" name="" value="{{$unite->type}}" disabled>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="select" class="col-md-3 control-label">
                                Valeur
                            </label>

                            <div class="col-md-2">
                                <input id="valeur" name="valeur" class="form-control" value={{$ingredient->valeur}}>€
                                @if  ($unite->type === "gr")
                                    / kilo
                                @elseif ($unite->type === "ml")
                                    / litre
                                @else
                                    / unité
                                @endif
                            </div>
                        </div>

                            {{--button--}}
                            <div class="form-group">
                                <div class="col-md-2 col-md-offset-1">
                                    <button type="submit" name="" class="btn btn-info">
                                        Modifier
                                    </button>
                                </div>
                                <div class="col-md-2 col-md-offset-4">
                                    <button type="button" name="" onclick="openModal()" class="btn btn-danger">Effacer
                                    </button>
                                </div>

                                {{-- Modal --}}
                                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="ModalLabel">Effacer {{$ingredient->nom}}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">X</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Êtes-vous sûr de vouloir supprimer cet ingrédient?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-info" data-dismiss="modal">Non</button>
                                                <a href="/ingredient/{{$ingredient->id}}/delete" class="btn btn-danger">Oui</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- Fin Modal --}}
                            </div>

                    </form>
                </div>

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
