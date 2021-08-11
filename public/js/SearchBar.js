class SearchBar {
    constructor() {
        this.searchInput = document.querySelector('#search-form input.search-input');
        this.resultsWindow = document.querySelector('#search-results');
        this.resultsBody = document.querySelector('#search-results .search-body');
        this.closeButton = document.querySelector('#search-results .close');
        this.bottomLink = document.querySelector('#search-results .search-footer a');
    }


    search(query) {
        query = query.trim();
        if(!query) {
            return false;
        }
        let SearchBar = this;
        ajax('/api/quicksearch/?q=' + query, 'GET' ,{})
            .then(response => response.json())
            .then(function (result) {
                console.log(result);
                SearchBar.resultsBody.innerHTML = '';
                for (let item of result) {
                    $(SearchBar.resultsBody).append('<a class="search-product" href="' + item.link + '">' + item.name + '</a>');
                }
                if(!result.length) {
                    SearchBar.resultsBody.innerHTML = '<span>По данному запросу ничего не найдено </span>';
                }

                SearchBar.bottomLink.href = '/search/?q=' + query.trim();
                SearchBar.showSearchResults();
            })
    }

    showSearchResults() {
        if(this.resultsWindow.classList.contains('closed')) {
            $(this.resultsWindow).slideDown(400, () => this.resultsWindow.classList.remove('closed'));
        }
    }

    hideSearchResults() {
        if(!this.resultsWindow.classList.contains('closed')) {
            $(this.resultsWindow).slideUp(400, () => this.resultsWindow.classList.add('closed'));
        }
    }



    init() {
        let SearchBar = this;

        this.searchInput.addEventListener('input', function () {
            if(this.dataset.timeout) {
                clearTimeout(parseInt(this.dataset.timeout));
            }
            this.dataset.timeout = setTimeout(() => SearchBar.search(this.value), 800);
        });

        this.searchInput.addEventListener('focus', () => SearchBar.resultsBody.innerHTML ? SearchBar.showSearchResults() : false);

        this.closeButton.addEventListener('click', () => SearchBar.hideSearchResults());

        document.body.addEventListener('click', () => SearchBar.hideSearchResults());
    }

}