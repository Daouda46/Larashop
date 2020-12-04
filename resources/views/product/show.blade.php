@extends('layouts/master')

@section('content')

<div class="col-md-12">
  <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-270 position-relative">
    <div class="col p-2 d-flex flex-column position-static">
      <muted class="d-inline-block mb-2 text-info">
        <div class="badge badge-pill badge-info">{{ $stock }}</div>
        @foreach ($product->categories as $category)
            {{ $category->name }} {{ $loop->last? "":", " }}
        @endforeach
      </muted>
      <h3 class="mb-0">{{ $product->title }}</h3>
      <div class="mb-1 text-muted">{{ $product->created_at }}</div>
      <p class="card-text mb-auto">{!! $product->description !!}</p>
      <strong> <p class="card-text mb-auto">{{ $product->getPrice() }}</p> </strong>
      @if ($stock === 'Disponible')
        <form action="{{route('cart.store')}}" method="POST">
          @csrf
          <input type="hidden" name="product_id" value="{{ $product->id }}">
          
            <button type="submit" class="btn btn-success"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Ajouter au panier</button>
        </form>
      @endif
    </div>
    <div class="col-auto d-none d-lg-block mt-2">
      <img src="{{  asset('storage/'.$product->image )  }}" id="mainImage" width="260px;" height="160px;" > 
      <div class="mt-3">
        @if($product->images)
        <img src="{{  asset('storage/'.$product->image )  }}" width="60px;" class="img-thumbnail" >
          @foreach (json_decode($product->images, true) as $image)
            <img src="{{  asset('storage/'.$image )  }}" width="60px;" class="img-thumbnail">
          @endforeach
        @endif
      </div>
      {{-- <svg class="bd-placeholder-img" width="200" height="250" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: Thumbnail"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"/><text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text></svg> --}}
    </div>
  </div>
</div>

@endsection

@section('extra-js')
 <script>
    var mainImage = document.querySelector('#mainImage');
    var Thumbnails = document.querySelectorAll('.img-thumbnail');

    Thumbnails.forEach((element) => element.addEventListener('click', changeImage));
    
    function changeImage(e){
      mainImage.src= this.src;
    }
 </script>
@endsection