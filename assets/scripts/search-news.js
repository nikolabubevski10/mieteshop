jQuery(function(){
    // get blogs
    function searchNewsResultSearch(page){
        const nonce = jQuery('#js-search-news__results-row').attr('data-nonce');
        const searchKey = jQuery('#js-search-news__results-row').attr('data-search-key');
        const postsPerPage = 8;

        jQuery('#js-search-news__load-spinner').removeClass('hide');

        jQuery.ajax({
            type: 'get',
            dataType: 'json',
            url: window.MieteshopData.ajaxurl,
            data: {
                action: 'search_news_result',
                nonce,
                searchKey,
                page,
                postsPerPage
            },
            success: function (response) {
                jQuery('#js-search-news__results-row').html(response.result);
                jQuery('#js-search-news__results-navigation').html(response.navigation);
                
                jQuery('#js-blog-cat-list-page-navigation').removeClass('hide');

                // add page navigation click event into new added nav html
                addPageNavigationClickOfSearchNewsResultFunc();
                
                jQuery('#js-search-news__page-list').val(page);

                jQuery('#js-search-news__load-spinner').addClass('hide')
            }
        })
    }
    
    // page navigation click
    function addPageNavigationClickOfSearchNewsResultFunc(){
        jQuery('.js-search-news__results-navigation-item a').on('click', function(){

            // check this is current page
            if( !jQuery(this).parent().hasClass('active') ){
                const page = jQuery(this).attr('data-page');

                searchNewsResultSearch(page)
            }

            return false;
        })
    }

    addPageNavigationClickOfSearchNewsResultFunc();

    jQuery('#js-search-news__page-list').on('change', function(){
        const page = jQuery(this).val();

        searchNewsResultSearch(page);
    });
})