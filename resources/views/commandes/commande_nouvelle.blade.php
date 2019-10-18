@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h2>Nouvelle commande</h2></div>
                <div class="panel-body">

                    {{--message--}}
                    @if(Session::has('message'))
                        <div class="alert alert-info">
                            {{ Session::get('message') }}
                        </div>
                    @endif

                    <form class="form-horizontal" role="form" method="POST" action="/commande">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="nom" class="col-md-3 control-label">Nom</label>

                            <div class="col-md-6">
                                <input id="nom" type="text" class="form-control" name="nom" placeholder="nom">
                            </div>
                        </div>


                        <div class="form-group ingredient_div">
                            <label for="select" class="col-md-3 control-label">
                                <div class="col-md-1">
                                    <a class="add_line btn btn-info btn-circle" data-target="ingredient_div">
                                        <i class="fa fa-fw fa-plus"></i>
                                    </a>
                                </div>
                                Produit
                            </label>

                            <div class="col-md-3">
                                <select class="form-control " id="recette_id" name="recette_id[]">
                                    <option></option>

                                    @foreach($recettes_list as $recettes)
                                        <option value="{{$recettes->id}}">
                                            {{$recettes->nom}}
                                        </option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="col-md-2">
                                <input id="qte_commande" name="qte_commande[]" class="form-control" placeholder="qte">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Textarea"class="col-md-3 control-label">Commentaire </label>
                            <div class="col-md-7">
                                <textarea  id="comments" type="text" class="form-control" name="comments" rows="5" ></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="livraison" class="col-md-3 control-label">Date Livraison</label>

                            <div class="col-md-6">
                                <input id="livraison" type="text" class="form-control" name="livraison" placeholder="date">
                            </div>
                        </div>

                            <div class="form-group">
                                <div class="col-md-2 ">
                                    <button type="submit" class="btn btn-info">
                                        Ajouter
                                    </button>
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
