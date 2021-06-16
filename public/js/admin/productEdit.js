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