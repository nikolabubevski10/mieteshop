jQuery(function(){
    // search page -- search type click event
    // redirect page with search type param
    jQuery('.js-search-page-filter-item').on('click', function(){
        const searchType = jQuery(this).attr('data-search-type');

        const { protocol, host, pathname } = window.location;
        const fullUrlWithoutParams = `${protocol}//${host}${pathname}`;
        const url = new URL(window.location.href);
        const s = url.searchParams.get("s");

        window.location = `${fullUrlWithoutParams}?s=${s}&search_type=${searchType}`;
    })
});