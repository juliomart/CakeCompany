@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h2>Liste de Commandes</h2></div>
                <div class="panel-body">

                    {{--message--}}
                    @if(Session::has('message'))
                        <div class="alert alert-info">
                            {{ Session::get('message') }}
                        </div>
                    @endif

                    <form class="form-horizontal" role="form" method="GET" action="/commande/">
                        {{ csrf_field() }}

                        @foreach($commande_list as $commande)

                        <div class="list-group">
                            <div class="list col-md-12 col-md-offset-2">

                                <div class="col-md-6">
                                <a href="/commande/{{$commande->id}}/show" class="list-group-item "> {{$commande->nom}}</a>
                                </div>

                                {{--TODO--}}
                                {{--<div class="col-md-3">--}}
                                {{--<a href="/commande/{{$commande->id}}/show" class="list-group-item "> {{$commande->livraison}}</a>--}}
                                {{--</div>--}}
                            </div>
                            <br>
                            <br>

                        </div>
                        <!-- Fin ListGroup -->

                        @endforeach
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-7">
                                <a href="/commande/create" class="btn btn-primary">Nouvelle commande</a>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
