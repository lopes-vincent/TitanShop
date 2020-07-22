@extends('default.templates.public')

@section('page.title', $product->i18nValue('title'))

@section('page.content')
    @include('default.components.breadcrumb', ['breadcrumb' => $product->generateBreadcrumb()])

    @include('default.components.toast', [
        'class' => 'product-added-toast',
        'message' => $product->i18nValue('title') . ' a été ajouté à votre panier.'
    ])

    <div class="row justify-content-center my-5">
        <div class="col-lg-4">
            <img src="{{$product->firstImage ? asset($product->firstImage->path) : asset('images/utils/question-mark.png')}}" alt="{{$product->i18nValue('title')}}" class="w-100">
        </div>
        <div class="col-lg-6">
            <h2>{{$product->i18nValue('title')}}</h2>
            <p>{{$product->i18nValue('description')}}</p>

            <div class="buying-container mt-3">
                <p class="h4">{{$product->formattedPrice}}</p>
                <button name="add-to-cart-btn" id="add-to-cart-btn" class="btn btn-primary rounded-0 shadow-none border mt-3" role="button">
                    Ajouter au panier</button>
            </div>
        </div>
    </div>
@endsection

@section('page.scripts')
    <script>
        $('#add-to-cart-btn').on('click', function () {
            $.ajax({
                url : '{{route("cart.items.add")}}',
                type : 'POST',
                dataType : 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data : {
                    product_id: '{{$product->id}}',
                    quantity: 1
                },
                success : function(data, status){
                    $('.toast-container').show();
                    $('.product-added-toast').toast('show');
                },
                error : function(data, status, error){
                    console.error('product not added : ' + error);
                }
            });
        });
    </script>
@endsection
