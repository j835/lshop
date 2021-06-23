var translit = function(text) {
    return text.replace(/([а-яё])|([\s_-])|([^a-z\d])/gi,
      function(all, ch, space, words, i) {
        if (space || words) {
          return space ? '-' : '';
        }
        var code = ch.charCodeAt(0),
          index = code == 1025 || code == 1105 ? 0 :
          code > 1071 ? code - 1071 : code - 1039,
          t = ['yo', 'a', 'b', 'v', 'g', 'd', 'e', 'zh',
            'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p',
            'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh',
            'shch', '', 'y', '', 'e', 'yu', 'ya'
          ];
        return t[index];
      }).toLowerCase();
  };
  

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


function translitBind(rus_input, url_input) {
    $(rus_input).on('input', function(e) {
        url_input.value = translit(rus_input.value);
    })
}