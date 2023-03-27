jQuery(function(){

    function goOffersResultTop(){
        jQuery('html, body').animate({
            scrollTop: jQuery('#js-offers-results-section').offset().top
        }, 1000)
    }

    // get products with page
    function offersProductSearch(page){
        const nonce = jQuery('#js-offers-results-section').attr('data-nonce');
        const productPerPage = jQuery('#js-offers-products-per-page').val();
        const productOrder = jQuery('#js-offers-product-display-order').val();

        const nextURL = `?current_page=${page}&productPerPage=${productPerPage}&productOrder=${productOrder}`
        const nextState = { additionalInformation: 'mieteshop-nav-hash-change' }

        // This will create a new entry in the browser's history, without reloading
        window.history.pushState(nextState, null, nextURL)

        jQuery('#js-offers-product-filter-load-spinner').removeClass('hide');

        jQuery.ajax({
            type: 'get',
            dataType: 'json',
            url: window.MieteshopData.ajaxurl,
            data: {
                action: 'filter_offers_product',
                nonce,
                page,
                productPerPage,
                productOrder
            },
            success: function (response) {
                jQuery('#js-offers-results-row').html(response.result);
                jQuery('#js-offers-results-navigation').html(response.navigation);

                // add page navigation click event into new added nav html
                addOffersPageNavigationClickFunc();

                jQuery('#js-offers-product-filter-load-spinner').addClass('hide')
                
                // reset page number list
                const pageCounts = parseInt(response.pageCounts);
                let pageHtmlInnterStr = '';

                for(let i = 1; i <= pageCounts; i++){
                    pageHtmlInnterStr += '<option value="' + i + '">' + i + '</option>'
                }

                jQuery('#js-offers-products-page-list').html(pageHtmlInnterStr);
                jQuery('#js-offers-products-page-list').val(page);

                // smoth go to the top of result section
                goOffersResultTop();
            }
        })
    }

    jQuery('#js-offers-products-per-page').on('change', function(){
        offersProductSearch(1);
    });

    jQuery('#js-offers-products-page-list').on('change', function(){
        const pageNum = jQuery(this).val();

        offersProductSearch(pageNum);
    });

    // page navigation click
    function addOffersPageNavigationClickFunc(){
        jQuery('.js-offers-results-navigation-item a').on('click', function(){

            // check this is current page
            if( !jQuery(this).parent().hasClass('active') ){
                const page = jQuery(this).attr('data-page');

                offersProductSearch(page)
            }

            return false;
        })
    }

    addOffersPageNavigationClickFunc();

    jQuery('#js-offers-product-display-order').on('change', function(){
        offersProductSearch(1);
    })
})