class Cart {

    static get cartCacheName() {
        return 'cartCache';
    }

    static print(update = false) {
        let cache = Cart.getCache();
        if (cache && !update) {
            $('#cart .cart-products').html(cache);
            Cart.updateTotals()
            Cart.lockButtons();
        } else {
            ajax('/api/cart/', 'get',).then(response => response.text())
                .then(function (text) {
                    Cart.pushCache(text);
                    $('#cart .cart-products').html(text);
                    Cart.updateTotals();
                    Cart.lockButtons();
                })
        }
    }


    static updateTotals() {
        let totalPrice = 0;
        let totalQuantity = 0;
        let totalValues = $('.cart-product-total');
        totalValues.each(function () {
            totalPrice += parseInt($(this).text());
            totalQuantity++;
        });

        $('#cart-button .total-price').text(totalPrice)
        $('#cart .cart-head span').text(totalQuantity + ' товаров');
        $('#cart .cart-total span').text(totalPrice + ' ₽');
        $('#header-mobile .cart .counter').text(totalQuantity);
    }

    static addToCart(id) {
        if (!parseInt(id)) {
            throw new Error('Ошибка - неверный id товара')
        }
        let quantity = parseInt($('.quantity[data-id=' + id + ']').text());
        if (quantity === NaN || quantity < 1) {
            throw new Error('Ошибка - неверное количество товара');
        }

        let element = $('.add2cart[data-id=' + id + ']');

        if (element.hasClass('disabled')) {
            return false;
        }
      
        ajax('/api/cart/', 'PUT', {
            'product_id': id,
            'quantity': quantity,
        }).then(response => response.json())
            .then(function (json) {
                if (json.error) {
                    alert(json.error);
                    throw new Error(json.error);
                }
                if (json.success) {
                    Cart.clearCache();
                    Cart.print(true)
                }
            })
    }

    static delete(id) {
        if (!parseInt(id)) {
            throw new Error('Ошибка - неверный id')
        }
        return ajax('/api/cart/', 'DELETE', {
            'product_id': id,
        }).then(response => response.json())
            .then(function (json) {
                if (json.error) {
                    alert(json.error);
                    throw new Error(json.error);
                }
                if (json.success) {
                    Cart.clearCache();
                    Cart.print(true);
                }
            })
    }

    static plus(id) {
        let element = $('.quantity[data-id=' + id + ']')
        let quantity = $('.add2cart[data-id=' + id + ']')  

        element.text(parseInt(element.text()) + 1);
    }

    static minus(id) {
        let element = $('.quantity[data-id=' + id + ']')
        let quantity = element.text();
        if (quantity > 1) {
            element.text(parseInt(quantity) - 1);
        }
    }

    static init() {
        Cart.addAnimation()
        Cart.print();
        $('#order-form').submit(() => Cart.clearCache());
    }

    static getCache() {
        return localStorage.getItem(Cart.cartCacheName) || false;
    }

    static pushCache(html) {
        localStorage.setItem(Cart.cartCacheName, html);
    }

    static clearCache() {
        console.log('123');
        localStorage.removeItem(Cart.cartCacheName);
    }

    static addAnimation() {
        let cartButton = $('#cart-button');
        let cart = $('#cart')
        cartButton.hover(function () {
            if (cart.hasClass('locked')) {
                return false;
            }
            cart.addClass('locked')
            $(cart).slideDown(400, () => cart.removeClass('locked'));
        }, function () {
            if (cart.hasClass('locked')) {
                return false;
            }
            cart.addClass('locked')
            $(cart).slideUp(400, () => cart.removeClass('locked'));
        })

    }

    static lockButtons() {
        let items = {};
        let cart = document.querySelectorAll('#cart .cart-product')
        for(let item of cart) {
            items[item.dataset.id] = true;
        }

        let buttons = document.querySelectorAll('.add2cart');
        for(let button of buttons) {
            if(items[button.dataset.id]) {
                button.classList.add('disabled')
            } else {
                button.classList.remove('disabled');
            }
        }
    }
}


