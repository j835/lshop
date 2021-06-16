function catalogMenu(link_base) {
    let links = document.querySelectorAll('.category>a');
    for (let link of links) {
        link.href = link_base + '?category_id=' + link.dataset.id;
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
            link.href = link_base + '?category_id=' + link.dataset.id;
        }
    }
}