import $ from 'jquery';
import 'select2';
import 'select2/dist/css/select2.css';

jQuery(function(){

    function goSearchArtObjectResultTop(){
        $('html, body').animate({
            scrollTop: jQuery('#js-search-art-object__results-section').offset().top
        }, 1000)
    }

    // get products with term, author, publisher and page
    function searchArtObject(page){
        const filterTermId = jQuery('#js-search-art-object__product-category-list').val();
        const filterAuthorId = jQuery('#js-search-art-object__author-list').val();
        const filterPublisherId = jQuery('#js-search-art-object__publisher-list').val();
        const productPerPage = jQuery('#js-search-art-object__per-page').val();
        const nonce = jQuery('#js-search-art-object__results-section').attr('data-nonce');
        const searchKey = jQuery('#js-search-art-object__results-section').attr('data-search-key');
        const productOrder = jQuery('#js-search-art-object__display-order').val();

        jQuery('#js-search-art-object__load-spinner').removeClass('hide');

        jQuery.ajax({
            type: 'get',
            dataType: 'json',
            url: window.MieteshopData.ajaxurl,
            data: {
                action: 'filter_search_art_object',
                nonce,
                filterTermId,
                filterAuthorId,
                filterPublisherId,
                page,
                productPerPage,
                searchKey,
                productOrder
            },
            success: function (response) {
                jQuery('#js-search-art-object__results-row').html(response.result);
                jQuery('#js-search-art-object__results-count').html(response.count);
                jQuery('#js-search-art-object__results-navigation').html(response.navigation);

                // add page navigation click event into new added nav html
                addSearchArtObjectPageNavigationClickFunc();

                jQuery('#js-search-art-object__load-spinner').addClass('hide')

                // reset page number list
                const pageCounts = parseInt(response.pageCounts);
                let pageHtmlInnterStr = '';

                for(let i = 1; i <= pageCounts; i++){
                    pageHtmlInnterStr += '<option value="' + i + '">' + i + '</option>'
                }

                jQuery('#js-search-art-object__page-list').html(pageHtmlInnterStr);
                jQuery('#js-search-art-object__page-list').val(page);

                // smoth go to the top of result section
                goSearchArtObjectResultTop();
            }
        })
    }

    $('#js-search-art-object__product-category-list').select2({
        placeholder: "Θεματικές",
        allowClear: true
    }).on('change', function(){
        searchArtObject(1);
    });

    $('#js-search-art-object__author-list').select2({
        placeholder: "Συγγραφείς",
        allowClear: true
    }).on('change', function(){
        searchArtObject(1);
    });

    $('#js-search-art-object__publisher-list').select2({
        placeholder: "Εκδότες",
        allowClear: true
    }).on('change', function(){
        searchArtObject(1);
    });

    jQuery('#js-search-art-object__per-page').on('change', function(){
        searchArtObject(1);
    });

    // page navigation click
    function addSearchArtObjectPageNavigationClickFunc(){
        jQuery('.js-search-art-object__results-navigation-item a').on('click', function(){

            // check this is current page
            if( !jQuery(this).parent().hasClass('active') ){
                const page = jQuery(this).attr('data-page');
                
                searchArtObject(page)
            }

            return false;
        })
    }

    addSearchArtObjectPageNavigationClickFunc();

    jQuery('#s-search-art-object__page-list').on('change', function(){
        const pageNum = jQuery(this).val();

        searchArtObject(pageNum);
    });

    jQuery('#s-search-art-object__display-order').on('change', function(){
        searchArtObject(1);
    })
});