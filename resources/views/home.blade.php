@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Mes commandes') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if((Auth()->user()->orders)->isEmpty())
                    <div class="text-center">
                        <h6> Pas de commande !!</h6>
                    </div>
                    @else
                    @foreach (Auth::user()->orders as $order)
                        <div class="card mb-3">
                            <div class="card-header">
                                    Commande passé le {{ Carbon\Carbon::parse($order->payment_created_at)->format('Y/m/d à H:i:s') }} 
                                    d'un montant de <strong>{{ getPrice($order->amount) }}  </strong>
                                    
                            </div>
                                <div class="card-body">
                                    <h5>Liste des produits</h5>
                                    @foreach (unserialize($order->products) as $product)
                                        <div>Nom du produit : <strong style="color: red">{{ $product[0] }}</strong></div>
                                        <div>Prix  : <strong style="font-weight: bold">{{ getPrice($product[1]) }}</strong></div>
                                        <div>Quantité : <strong>{{ $product[2] }}</div></strong>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
