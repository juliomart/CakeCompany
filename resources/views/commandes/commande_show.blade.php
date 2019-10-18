@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h2>Commande de {{$commandes->nom}}</h2></div>
                <div class="panel-body">

                    {{--message--}}
                    @if(Session::has('message'))
                        <div class="alert alert-info">
                            {{ Session::get('message') }}
                        </div>
                    @endif

                    <form class="form-horizontal" role="form" method="POST" action="/commande/{{$commandes->id}}/up">
                        {{ csrf_field() }}

                    <div class="form-group ">

                        <div class="form-group">
                            <label for="nom" class="col-md-3 control-label">Nom</label>

                            <div class="col-md-4">
                                <input id="nom" type="text" class="form-control" name="nom" value="{{$commandes->nom}}">
                            </div>
                        </div>

                        <label for="text" class="col-md-3 control-label">Produit</label>
                        <div class="col-md-8 ">

                        @foreach($commandes->recettes as $rec)
                        <div class="{{ $loop->iteration }}">
                            <div class="col-md-4">
                                <input id="recette_id" type="hidden" class="form-control" name="recette_id[]" value="{{$rec->id}}">
                                <input id="recette_nom" type="text" class="form-control" name="recette_nom[]" value="{{$rec->nom}}" disabled>
                            </div>
                            <div class="col-md-2">
                                <input id="qte" type="text" class="form-control" name="qte[]" value="{{$rec->pivot->qte_commande}}">
                            </div>
                                <div class="col-md-1">X</div>
                            <div class="col-md-3">
                                <input id="prix" type="text" class="form-control" name="prix" value="{{$rec->prix_final}}" disabled>
                            </div>
                                <div class="col-md-1">
                                    <a class="remove_line btn btn-danger btn-circle" data-target="{{ $loop->iteration }}">
                                        <i class="fa fa-fw fa-minus"></i></a>
                                </div>
                            </div>
                        @endforeach

                        </div>

                        <div class="ingredient_div col-md-12">
                            <label for="select" class="col-md-3 control-label">
                            </label>

                            <div class="col-md-3">
                                <select class="form-control " id="recette_id2" name="recette_id2[]">
                                    <option></option>

                                    @foreach($recettes as $recette)
                                        <option value="{{$recette->id}}">
                                            {{$recette->nom}}
                                        </option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="col-md-2">
                                <input id="qte2" name="qte2[]" class="form-control" placeholder="qte"/>
                            </div>
                        </div>

                            <div class="col-md-1 col-md-offset-1">
                                <a class="add_line btn btn-info btn-circle" data-target="ingredient_div">
                                    <i class="fa fa-fw fa-plus"></i>
                                </a>
                            </div>
                        </div>

                        <hr>
                        <div class="form-group">
                            <label for="Textarea"class="col-md-3 control-label">Commentaire </label>
                            <div class="col-md-7">
                                <textarea  id="comments" type="text" class="form-control" name="comments" rows="5" >{{$commandes->comments}}
                                </textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="livraison" class="col-md-3 control-label">Date Livraison</label>

                            <div class="container">
                                <div class="col-sm-4" style="height:130px;">
                                    <div class="form-group">
                                        <div class='input-group date' id='datetimepicker8'>
                                            <input type='text' class="form-control" />
                                            <span class="input-group-addon">
                                                <span class="fa fa-calendar"> </span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <script type="text/javascript">
                                    $(function () {
                                        $('#datetimepicker8').datetimepicker({
                                            icons: {
                                                time: "fa fa-clock-o",
                                                date: "fa fa-calendar",
                                                up: "fa fa-arrow-up",
                                                down: "fa fa-arrow-down"
                                            }
                                        });
                                    });
                                </script>
                            </div>

                            <div class="col-md-4">
                                <input id="livraison" type="text" class="form-control" name="livraison" value="{{$livraison}}">
                            </div>
                        </div>

                        <hr>

                        <div class="form-group">
                            <label for="cout" class="col-md-8 control-label">Prix final</label>
                            <div class="col-md-2">
                                <input id="prix" class="form-control" name="prix" value="{{$valeur_commande}} €" disabled>
                            </div>
                        </div>

                        {{--button--}}
                        <div class="form-group">
                            <div class="col-md-2 col-md-offset-1">
                                <button type="submit" name="" class="btn btn-info">Modifier
                                </button>
                            </div>

                            <div class="col-md-2 col-md-offset-5">
                                <button type="button" name="" onclick="openModal()" class="btn btn-danger">Effacer
                                </button>
                            </div>

                            {{-- Button --}}
                            {{--<div class="btn-group">--}}
                                {{--<button data-toggle="dropdown" class="btn btn-success btn-md dropdown-toggle" type="button">--}}
                                    {{--<span class="caret"></span></button>--}}
                                {{--<ul class="dropdown-menu">--}}
                                    {{--<li><a onclick="openModal()" href="#">Effacer</a></li>--}}
                                {{--</ul>--}}


                                {{-- Modal --}}
                                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="ModalLabel">Effacer {{$commandes->nom}}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">X</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Êtes-vous sûr de vouloir supprimer ce commande de {{$commandes->nom}}?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-info" data-dismiss="modal">Non</button>
                                                <a href="/commande/{{$commandes->id}}/delete" class="btn btn-danger">Oui</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- Fin Modal --}}

                            </div>
                        {{-- Fin Button --}}
                    {{--</div>--}}

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
