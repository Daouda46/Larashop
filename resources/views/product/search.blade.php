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
          <h5 class="mb-0">{{ $product->title }}</h5>
          <div class="mb-1 text-muted">{{ $product->created_at }}</div>
          <p class="card-text mb-auto">{{ $product->subtitle }}</p>
          <strong> <p class="card-text mb-auto">{{ $product->getPrice() }}</p> </strong>
          <a href="{{ route('products.show',  $product->slug) }}" class="stretched-link btn btn-info">voir l'article</a>
        </div>
        <div class="col-auto d-none d-lg-block">
          <img src="{{  asset('storage/'.$product->image )  }}" alt="" style="width: 250px" >
         
        </div>
      </div>
    </div>
    @endforeach
    {{ $products->appends(request()->input())->links() }}
@endsection