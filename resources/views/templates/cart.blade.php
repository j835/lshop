@foreach($items as $item)
    <div class="cart-product" data-id="{{$item->id}}">
        <div class="image-wrapper">
            <img src="{{$item->preview_path}}" alt="preview">
        </div>
        <div class="cart-product-info">
            <a class="cart-product-name" href="{{$item->path}}">{{$item->name}}</a>
            <div class="cart-product-cost">
                <span class="single-price">{{$item->price}}</span> × <span class="quantity">{{$item->quantity}}</span> = <span
                    class="cart-product-total">{{$item->total}}</span>
            </div>
        </div>
        <div class="cart-delete unselectable" onclick="Cart.delete({{$item->id}})" data-id="{{$item->id}}">x</div>
    </div>
@endforeach

