$('#productDeleteForm').submit(function(e) {
    if(!confirm('Вы действительно хотите навсегда удалить товар? Восстановление невозможно')) {
        e.preventDefault();
    }
})

$('.delete-image-form').submit(function(e) {
    if(!confirm('Вы действительно хотите удалить изображение? Восстановление невозможно')) {
        e.preventDefault();
    }
})


$('#product-images .card-body>a').simpleLightbox()


let IMG_INPUT_INDEX = 1;
$('#moreImg').click(function(e) {
    let input = document.createElement('INPUT');
    input.type = 'file';
    input.classList.add('form-control');
    input.name = 'image_' + IMG_INPUT_INDEX;
    document.querySelector('.add-image-form .image-inputs').appendChild(input);
    IMG_INPUT_INDEX++;
})


$('.tab-nav').click(function(e) {

    if($(this).hasClass('active')) {
        return false;
    } else {
        $('.tab-nav').removeClass('active');
        $(this).addClass('active');
        let id = this.dataset.tab;
        $('#tabs>div').removeClass('active');
        $('#' + id).addClass('active');
    }
})

$(document).ready(function() {

    let links = document.querySelectorAll('.category>a');
    for (let link of links) {

        let submenu = $(link).siblings('.submenu')[0];
        if (submenu) {
            link.href = '#'
            link.classList.add('arrow');
            $(link).click(function (e) {
                e.preventDefault();
                if (link.classList.contains('collapsed')) {
                    $(submenu).slideUp();
                    link.classList.remove('collapsed');
                } else {
                    $(submenu).slideDown();
                    link.classList.add('collapsed');
                }
            })
        } else {
            $(link).click(function(e) {
                e.preventDefault();
                document.querySelector('#category-id-input').value = link.dataset.id;
                link.rel = 'modal:close';
            })
        }
    }

})
