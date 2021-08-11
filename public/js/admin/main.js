
function translitBind(rus_input, url_input) {
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

    if(typeof(rus_input) === 'string') {
      rus_input = $('#' + rus_input);
    }

    if(typeof(url_input) === 'string') {
      url_input = $('#' + url_input);
    }

    $(rus_input).on('input', function(e) {
        $(url_input).val(translit($(rus_input).val()));
    })
}


function formSubmitConfirm(form, message) {
    if(typeof(form) === 'string') {
      form = document.getElementById(form);
    }

    $(form).submit(function(e) {
        if(!confirm(message)) {
          e.preventDefault();
        }
    })
}

document.addEventListener('DOMContentLoaded', function() {
    $('.nav-header').click(function(e) {
      let button = $(this);
      let submenu = button.next('.nav-group');

      if(button.hasClass('locked')) {
          return false;
      }
      button.addClass('locked');

      if(button.hasClass('opened')) {
          submenu.slideUp(200, () => button.removeClass('locked') && button.removeClass('opened'));
      } else {
          submenu.slideDown(200, () => button.removeClass('locked') && button.addClass('opened'));
      }
    })
})
