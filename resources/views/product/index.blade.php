@extends('layouts/master')

@section('content')

@foreach($products as $product)
      
    <div class="col-md-6">
      <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-260 position-relative">
        <div class="col p-4 d-flex flex-column position-static">
          <strong class="d-inline-block mb-2 text-primary">
            @foreach ($product->categories as $category)
                {{ $category->name }}
                @if(!$loop->last)
                ,
                @endif
            @endforeach
          </strong>
          <h5 class="mb-0">{{ $product->title }}</h5> <br>
          <div class="mb-1 text-muted">{{ $product->created_at }}</div>
          <p class="card-text mb-auto">{{ $product->subtitle }}</p>
          <b> <p class="card-text mb-auto">{{ $product->getPrice() }}</p> </b>
          <br>
          <div class="inline-block">
            <a href="{{ route('products.show',  $product->slug) }}" class="btn btn-sm btn-info"><i class="fa fa-mouse-pointer"></i> voir l'article</a>
            <a>
              <form action="{{route('cart.store')}}" method="POST"  class="d-inline-block">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                
                  <button type="submit" class="btn btn-sm btn-warning"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Ajouter Au panier</button>
              </form>
            </a>
            {{-- <a href="" class="btn btn-warning"><i class="fa fa-shopping-cart"></i>  Au panier</a> --}}
          </div>
        </div>
        <div class="col-auto d-none d-lg-block mt-3">
          <img src="{{  asset('storage/'.$product->image )  }}" style="width:200px; " >
         
        </div>
      </div>
    </div>
    @endforeach
    {{ $products->appends(request()->input())->links('vendor/pagination/bootstrap-4') }}
@endsection