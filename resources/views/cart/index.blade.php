@extends('layouts/master')

@section('extra-meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')

@if(Cart::count() > 0)

    <div class="px-4 px-lg-0">
    
        <div class="pb-5">
        <div  class="container">
            <div class="row">
            <div class="col-lg-12 p-5 bg-white rounded shadow-sm mb-5">
    
                <!-- Shopping cart table -->
                <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col" class="border-0 bg-light">
                        <div class="p-2 px-3 text-uppercase">Produit</div>
                        </th>
                        <th scope="col" class="border-0 bg-light">
                        <div class="py-2 text-uppercase">Prix</div>
                        </th>
                        <th scope="col" class="border-0 bg-light">
                        <div class="py-2 text-uppercase">Quantité</div>
                        </th>
                        <th scope="col" class="border-0 bg-light">
                        <div class="py-2 text-uppercase">Supprimer</div>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    
                    @foreach($cartItems as $item)
                    <tr>
                        <th scope="row" class="border-0">
                        <div class="p-2">
                            <img src="{{  asset('storage/'.$products->find($item->id)->image )  }}" alt="" width="70" class="img-fluid rounded shadow-sm">
                            <div class="ml-3 d-inline-block align-middle">
                            <h5 class="mb-0"> <a href="#" class="text-dark d-inline-block align-middle">{{ $products->find($item->id)->title }}</a></h5>
                            <span class="text-muted font-weight-normal font-italic d-block"> Categorie:
                                @foreach ($item->model->categories as $category)
                                    {{ $category->name }} {{ $loop->last? "":", " }}
                                @endforeach
                            </span>
                            </div>
                        </div>
                        </th>
                        <td class="border-0 align-middle"><strong>{{ getPrice($item->subtotal) }}</strong></td>
                        <td class="border-0 align-middle">
                            <select class="quantity" name="qty" id="qty" data-id ="{{ $item->rowId }}" 
                                data-stock="{{ $products->find($item->id)->stock }}" class="custom-select">
                                @for ($i =1; $i <= 6; $i++)
                                    <option value="{{ $i }}" {{ $i == $item->qty ? 'selected':'' }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </td>
                        <td class="border-0 align-middle">
                            <form action="{{ route('cart.destroy', $item->rowId) }}" method="post">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger" ><i class="fa fa-trash"></i></button>
                            </form>
                            
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                </div>
                <!-- End -->
            </div>
            </div>
    
            <div class="row py-5 p-4 bg-white rounded shadow-sm">
            <div class="col-lg-6">
                <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">Coupon code</div>
                @if(!request()->session()->has('coupon'))
                    <div class="p-4">
                    <p class="font-italic mb-4">Si vous detenez un code coupon, Entrez-le dans le champ ci-dessous</p>
                    <form action="{{ route('cart.storeCoupon') }}" method="post">
                        @csrf
                        <div class="input-group mb-4 border rounded-pill p-2">
                            <input type="text" placeholder="Entrez votre code ici" name="code" aria-describedby="button-addon3" class="form-control border-0">
                            <div class="input-group-append border-0">
                            <button id="button-addon3" type="submit" class="btn btn-dark px-4 rounded-pill"><i class="fa fa-gift mr-2"></i>Appliquer le coupon</button>
                            </div>
                        </div>
                    </form>
                    </div>
                @else
                <div class="p-4">
                    <p class="font-italic mb-4">Un coupon est déjà appliqué</p>
                </div>
                @endif
                {{-- <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">Instructeur pour les vendeurs</div>
                <div class="p-4">
                <p class="font-italic mb-4">If you have some information for the seller you can leave them in the box below</p>
                <textarea name="" cols="30" rows="2" class="form-control"></textarea>
                </div> --}}
            </div>
            <div class="col-lg-6">
                <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">Details de la commande </div>
                <div class="p-4">
                <p class="font-italic mb-4">Shipping and additional costs are calculated based on values you have entered.</p>
                <ul class="list-unstyled mb-4">
                    <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Sous-total </strong><strong>{{ getPrice(Cart::subtotal()) }}</strong></li>
                    @if (request()->session()->has('coupon'))
                        <li class="d-flex justify-content-between py-3 border-bottom">
                            <strong class="text-muted">Coupon {{ request()->session()->get('coupon')['code'] }}
                                <form action="{{ route('cart.destroyCoupon') }}" method="post" class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></button>
                                </form>
                            </strong>
                            <strong>{{ getPrice(request()->session()->get('coupon')['remise']) }}</strong>
                        </li>
                        <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Nouveau sous total</strong>
                            <strong>{{ getPrice(Cart::subtotal() - request()->session()->get('coupon')['remise'])  }}</strong>
                        </li>
                        <li class="d-flex justify-content-between py-3 border-bottom">
                            <strong class="text-muted">Taxe</strong>
                            <strong>
                                {{ getPrice((Cart::subtotal() - request()->session()->get('coupon')['remise'])* (config('cart.tax') / 10))  }}
                            </strong>
                        </li>
                        <li class="d-flex justify-content-between py-3 border-bottom">
                            <strong class="text-muted">Total</strong>
                            <strong>
                                {{ getPrice((Cart::subtotal() - request()->session()->get('coupon')['remise']) + (Cart::subtotal() -
                                 request()->session()->get('coupon')['remise'])* (config('cart.tax') / 10))  }}
                            </strong>
                        </li>
                    @else
                    <li class="d-flex justify-content-between py-3 border-bottom">
                        <strong class="text-muted">Taxe</strong>
                        <strong>{{ getPrice(Cart::tax()) }}</strong>
                    </li>
                    <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Total</strong>
                        <h5 class="font-weight-bold">{{ getPrice(Cart::total()) }}</h5>
                    </li>
                    @endif
                </ul><a href="{{ route('payment.index') }}" class="btn btn-dark rounded-pill py-2 btn-block"><i class="fa fa-credit-card"></i>  Valider ma commande</a>
                </div>
            </div>
            </div>
    
        </div>
        </div>
    </div>
@else
<div class="col-md-12">
    <h5>Votre panier est vide pour le moment.</h5>
    <p>Mais vous pouvez visiter la <a href="{{ route('homepage') }}">boutique</a> pour faire votre shopping.
    </p>
</div>
@endif

@endsection

@section('extra-js')
<script src="{{ asset('js/app.js') }}" defer></script>
<script>

   ( function() {
        const classname = document.querySelectorAll('.quantity');

        Array.from(classname).forEach(function(element){
            element.addEventListener('change', function(){
                const stock = element.getAttribute('data-stock');
                const id = element.getAttribute('data-id');
                axios.patch(`/panier/${id}`, {
                    quantity:this.value,
                    stock:stock
                })
                .then(function (response) {
                    // console.log(response);
                    window.location.href = "{{ route('cart.index') }}"
                })
                .catch(function (error) {
                    console.log(error);
                    window.location.href = "{{ route('cart.index') }}"
                });
            })
        })

    })();
    // var selects = document.querySelectorAll('#qty');
    // Array.from(selects).forEach((element) => {
    //     element.addEventListener('change', function(){
    //         var rowId = this.getAttribute('data-id');
    //         var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
    //         fetch(
    //             `/panier/${rowId}`,
    //             {
    //                 hearders: {
    //                     "Content-Type": "application/json",
    //                     "Accept": "application/json, text/plain, */*",
    //                     "X-Requested-With": "XMLHttpRequest",
    //                     "X-CSRF-TOKEN": token
    //                 },
    //                 method: 'PATCH',
    //                 body: JSON.stringify({
    //                     qty: this.value
    //                 })
    //             }
    //         ).then((data) =>{
    //             console.log(data);
    //             window.location.reload();
    //         }).catch((error) => {
    //             console.log(error);
    //         })
    //     });
    // });

</script>
@endsection