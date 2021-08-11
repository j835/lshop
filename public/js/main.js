function ajax(path, method, data = {}) {
    let contentType = typeof (data) === 'object' ? "application/json" : "application/x-www-form-urlencoded";
    let params = {
        method: method,
        headers: {
            "Content-type": contentType,

        },
    }

    if (method.toLowerCase() !== 'get') {
        params.body = JSON.stringify(data);
        params.headers['X-CSRF-Token'] = $("meta[name='csrf-token']").attr('content')
    }
    return fetch(path, params);
}


document.addEventListener('DOMContentLoaded', function () {

    $('.catalog-menu .category').hover(function (e) {
        if (window.innerWidth <= 768) {
            return false;
        }
        let category = $(this);
        category.children('.submenu').first().css('display', 'block');
        setTimeout(() => category.children('.submenu').first().css('opacity', '1'), 50);
        category.addClass('selected');

    }, function (e) {
        if (window.innerWidth <= 768) {
            return false;
        }
        $(this).children('.submenu').first().css('display', 'none');
        $(this).children('.submenu').first().css('opacity', '0');
        $(this).removeClass('selected');
    })



    let names = document.querySelectorAll('.item-name');
    if (names.length) {
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


    $('#header-mobile .burger').click(function () {
        let button = $(this);
        let sidebar = $('#sidebar');
        if (button.hasClass('locked')) {
            return false;
        }

        window.scrollTo({ top: 0, behavior: "smooth", });
        button.addClass('locked');

        if (button.hasClass('opened')) {
            sidebar.slideUp(400, () => button.removeClass('locked') && button.removeClass('opened'));
        } else {
            sidebar.slideDown(400, () => button.removeClass('locked') && button.addClass('opened'));
        }
    })

    $('#header-mobile .search').click(function () {
        let button = $(this);
        let form = $('#search-mobile');
        if (button.hasClass('locked')) {
            return false;
        }

        window.scrollTo({ top: 0, behavior: "smooth", });
        button.addClass('locked');

        if (button.hasClass('opened')) {
            form.slideUp(400, () => button.removeClass('locked') && button.removeClass('opened'));
        } else {
            form.slideDown(400, () => button.removeClass('locked') && button.addClass('opened'));
        }
    })

    $('#sidebar .catalog-menu a').click(function (e) {
        let link = $(this);
        let submenu = $(this).siblings('.submenu')[0];

        if (window.innerWidth > 768 || !submenu || link.hasClass('locked')) {

        } else {
            link.addClass('locked');
            e.preventDefault();

            if (link.hasClass('selected')) {
                link.removeClass('selected')
                $(submenu).slideUp(400, () => link.removeClass('locked'));
            } else {
                link.addClass('selected')
                $(submenu).slideDown(400, () => link.removeClass('locked'));
            }
        }
    })


    new SearchBar().init();
    Cart.init();
})
