jQuery(function(){

    function goBestSellersResultTop(){
        jQuery('html, body').animate({
            scrollTop: jQuery('#js-best-sellers-results-section').offset().top
        }, 1000)
    }

    // get products with page
    function bestSellersProductSearch(page){
        const nonce = jQuery('#js-best-sellers-results-section').attr('data-nonce');
        const productPerPage = jQuery('#js-best-sellers-products-per-page').val();

        const nextURL = `?current_page=${page}&productPerPage=${productPerPage}`
        const nextState = { additionalInformation: 'mieteshop-nav-hash-change' }

        // This will create a new entry in the browser's history, without reloading
        window.history.pushState(nextState, null, nextURL)

        jQuery('#js-best-sellers-product-filter-load-spinner').removeClass('hide');

        jQuery.ajax({
            type: 'get',
            dataType: 'json',
            url: window.MieteshopData.ajaxurl,
            data: {
                action: 'filter_best_sellers_product',
                nonce,
                page,
                productPerPage
            },
            success: function (response) {
                jQuery('#js-best-sellers-results-row').html(response.result);
                jQuery('#js-best-sellers-results-navigation').html(response.navigation);

                // add page navigation click event into new added nav html
                addBestSellersPageNavigationClickFunc();

                jQuery('#js-best-sellers-product-filter-load-spinner').addClass('hide')
                
                // reset page number list
                const pageCounts = parseInt(response.pageCounts);
                let pageHtmlInnterStr = '';

                for(let i = 1; i <= pageCounts; i++){
                    pageHtmlInnterStr += '<option value="' + i + '">' + i + '</option>'
                }

                jQuery('#js-best-sellers-products-page-list').html(pageHtmlInnterStr);
                jQuery('#js-best-sellers-products-page-list').val(page);

                // smoth go to the top of result section
                goBestSellersResultTop();
            }
        })
    }

    jQuery('#js-best-sellers-products-per-page').on('change', function(){
        bestSellersProductSearch(1);
    });

    jQuery('#js-best-sellers-products-page-list').on('change', function(){
        const pageNum = jQuery(this).val();

        bestSellersProductSearch(pageNum);
    });

    // page navigation click
    function addBestSellersPageNavigationClickFunc(){
        jQuery('.js-best-sellers-results-navigation-item a').on('click', function(){

            // check this is current page
            if( !jQuery(this).parent().hasClass('active') ){
                const page = jQuery(this).attr('data-page');

                bestSellersProductSearch(page)
            }

            return false;
        })
    }

    addBestSellersPageNavigationClickFunc();
})