function ajax(path, method, data = {}) {
    let contentType = typeof(data) === 'object' ? "application/json" : "application/x-www-form-urlencoded" ;
    let params = {
        method: method,
        headers: {
            "Content-type": contentType,

        },
    }

    if(method.toLowerCase() !== 'get') {
        params.body = JSON.stringify(data);
        params.headers['X-CSRF-Token'] = $("meta[name='csrf-token']").attr('content')
    }

    return fetch(path, params);
}


function ajaxSendForm(form, callback = false) {
    let formData = new FormData(form);
    let data = {};
    for(let a of formData) {
        data.a[0] = a[1];
    }
    let method = form.method ? form.method : 'get';
    let path = form.action ? form.action : window.location.href;

    ajax(path,method,data).then(function(response) {
        if(typeof(callback) == "function") {
            callback.apply(form);
        }
    })
}


document.addEventListener('DOMContentLoaded', function() {


    $('.catalog-menu .category').hover(function(e) {
        let category = $(this);
        category.children('.submenu').first().css('display' , 'block');
        setTimeout(() => category.children('.submenu').first().css('opacity' , '1'), 50);
        category.addClass('selected');

    },function(e) {
        $(this).children('.submenu').first().css('display' , 'none');
        $(this).children('.submenu').first().css('opacity' , '0');
        $(this).removeClass('selected');
    })



    let names = document.querySelectorAll('.item-name');
    if(names.length) {
        let maxHeight = 0;
        for (let name of names) {
            console.log(maxHeight);
            if (name.offsetHeight > maxHeight) {
                maxHeight = name.offsetHeight;
            }
        }
        for (let name of names) {
            name.style.height = maxHeight + 'px';
        }
    }



    Cart.init();
})
