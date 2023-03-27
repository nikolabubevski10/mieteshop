import jquery from 'jquery';
import $ from 'jquery';
import 'select2';
import 'select2/dist/css/select2.css';

jQuery(function(){

    function goSearchResultTop(){
        $('html, body').animate({
            scrollTop: jQuery('#js-pcat-results-section').offset().top
        }, 1000)
    }

    // beforeFilterTermIds need to get author/publisher list when selected category was changed.
    let beforeFilterTermIds = jQuery('#js-pcat-filter-detail-row').attr('data-filter-term-list');
    if (typeof beforeFilterTermIds === 'undefined'){ beforeFilterTermIds = ""; }

    // get products with term, author, publisher and page
    function categoryProductSearch(page){
        let filterTermIds = jQuery('#js-pcat-filter-detail-row').attr('data-filter-term-list');
        if (typeof filterTermIds === 'undefined'){ filterTermIds = ""; }

        //console.log("beforeFilterTermIds: " + beforeFilterTermIds);
        //console.log("filterTermIds: " + filterTermIds); 

        const changedSelectedTermIds = filterTermIds !== beforeFilterTermIds;
        beforeFilterTermIds = filterTermIds;
        
        const filterAuthorId = jQuery('#js-pcat-author-list').val();
        const filterPublisherId = jQuery('#js-pcat-publisher-list').val();
        const nonce = jQuery('#js-pcat-list-title').attr('data-nonce');
        const mainProductCatId = jQuery('#js-pcat-list-title').attr('data-main-product-cat-id');
        const productPerPage = jQuery('#js-pcat-products-per-page').val();
        const productOrder = jQuery('#js-pcat-product-display-order').val();

        const nextURL = `?filterTermIds=${filterTermIds}&filterAuthorId=${filterAuthorId}&filterPublisherId=${filterPublisherId}&mainProductCatId=${mainProductCatId}&page=${page}&productPerPage=${productPerPage}&productOrder=${productOrder}`
        const nextState = { additionalInformation: 'mieteshop-nav-hash-change' }

        // This will create a new entry in the browser's history, without reloading
        window.history.pushState(nextState, null, nextURL)

        jQuery('#js-category-product-filter-load-spinner').removeClass('hide');

        jQuery.ajax({
            type: 'get',
            dataType: 'json',
            url: window.MieteshopData.ajaxurl,
            data: {
                action: 'filter_category_product',
                nonce,
                filterTermIds,
                filterAuthorId,
                filterPublisherId,
                page,
                mainProductCatId,
                productPerPage,
                productOrder,
                changedSelectedTermIds
            },
            success: function (response) {
                jQuery('#js-pcat-results-row').html(response.result);
                jQuery('#js-pcat-results-count').html(response.count);
                jQuery('#js-pcat-results-navigation').html(response.navigation);

                // add page navigation click event into new added nav html
                addPageNavigationClickFunc();

                jQuery('#js-category-product-filter-load-spinner').addClass('hide')
                
                // reset page number list
                const pageCounts = parseInt(response.pageCounts);
                
                if( pageCounts > 1 ){
                    jQuery('#js-pcat-results-navigation-wrapper').removeClass('hide');
                } else {
                    jQuery('#js-pcat-results-navigation-wrapper').addClass('hide');
                }

                let pageHtmlInnterStr = '';

                for(let i = 1; i <= pageCounts; i++){
                    pageHtmlInnterStr += '<option value="' + i + '">' + i + '</option>'
                }

                jQuery('#js-pcat-products-page-list').html(pageHtmlInnterStr);
                jQuery('#js-pcat-products-page-list').val(page);

                // smoth go to the top of result section
                goSearchResultTop();

                if( changedSelectedTermIds ){
                    $('#js-pcat-author-list').empty();
                    $('#js-pcat-publisher-list').empty();

                    let authorListHtml = '<option></option>';
                    for(let authorID in response.author_list_in_search_result){
                        authorListHtml += '<option value="' + authorID + '">' + response.author_list_in_search_result[authorID] + '</option>';
                    }

                    jQuery('#js-pcat-author-list').html(authorListHtml);

                    let publisherListHtml = '<option></option>';
                    for(let publisherID in response.publisher_terms_in_search_result){
                        publisherListHtml += '<option value="' + publisherID + '">' + response.publisher_terms_in_search_result[publisherID] + '</option>';
                    }

                    jQuery('#js-pcat-publisher-list').html(publisherListHtml);
                    
                    $('#js-pcat-author-list').select2({
                        placeholder: "Συγγραφείς",
                        allowClear: true
                    })
                    
                    $('#js-pcat-publisher-list').select2({
                        placeholder: "Εκδότες",
                        allowClear: true
                    })
                }
            }
        })
    }

    $('#js-pcat-author-list').select2({
        placeholder: "Συγγραφείς",
        allowClear: true
    }).on('change', function(){
        if( !jQuery('#js-pcat-author-list-wrapper').hasClass('hide') ){
            categoryProductSearch(1);
        }
    });
    
    $('#js-pcat-publisher-list').select2({
        placeholder: "Εκδότες",
        allowClear: true
    }).on('change', function(){
        if( !jQuery('#js-pcat-publisher-list-wrapper').hasClass('hide') ){
            categoryProductSearch(1);
        }
    });

    jQuery('#js-pcat-products-per-page').on('change', function(){
        categoryProductSearch(1);
    });

    jQuery('#js-pcat-products-page-list').on('change', function(){
        const pageNum = jQuery(this).val();

        categoryProductSearch(pageNum);
    });

    function updateFilterCountLabel(){
        // check filter params
        let filterTermIds = [];

        // check parent filter active
        jQuery('.js-pcat-filter-detail-parent.active').each(function(index, elem){
            const termId = jQuery(elem).attr('data-term-id');

            filterTermIds.push(termId);
        });

        jQuery('.js-pcat-filter-detail-child.active').each(function(index, elem){
            const $parentElem = jQuery(elem).parent();

            // if the parent category was activated, ignore this child cat in search param
            if( !jQuery('.js-pcat-filter-detail-parent', $parentElem).hasClass('active') ){
                const termId = jQuery(elem).attr('data-term-id');

                filterTermIds.push(termId);
            }
        });

        jQuery('#js-pcat-filter-detail-row').attr('data-filter-term-list', filterTermIds.join(','))
        // categoryProductSearch(1);

        // when category is clicked, rest author and publisher
        const choiceType = jQuery('.js-pcat-author-publisher-choice-item:checked').val();
        
        if( choiceType === 'publisher' ){
            // the following will happen categoryProductSearch(1);
            $('#js-pcat-publisher-list').val(null).trigger('change');
        } else if( choiceType === 'author' ){
            // the following will happen categoryProductSearch(1);
            $('#js-pcat-author-list').val(null).trigger('change');
        }

        const filterCount = jQuery('#js-pcat-extra-thematic-filter-row .pcat-extra-thematic-filter-col').length;

        if( filterCount === 0 ){
            // if there is nothing in filter, remove filter tags section
            jQuery('#js-pcat-extra-thematic-filter').addClass('hide');
        } else {
            jQuery('#js-pcat-extra-thematic-filter').removeClass('hide');
            jQuery('#js-pcat-extra-thematic-filter-title span').text(filterCount);
        }
    }
    
    jQuery('.js-pcat-filter-detail-parent').on('click', function(){
        const termID = jQuery(this).attr('data-term-id')
        const $parentElem = jQuery(this).parent();

        // this is for blackbar tag list. so about the root category item, the tag will be uppercase
        const uppercaseCss = jQuery(this).hasClass('pcat-filter-detail-root') ? 'pcat-extra-thematic-filter-item--root' : '';

        if( jQuery(this).hasClass('active') ){
            jQuery('.pcat-filter-detail-child', $parentElem).removeClass('disable');
            jQuery(this).removeClass('active')
            jQuery(`#js-pcat-extra-thematic-filter-col-${termID}`).remove();
        } else {
            jQuery('.pcat-filter-detail-child', $parentElem).addClass('disable');
            const labelName = jQuery(this).text()

            jQuery(this).addClass('active')

            const $newElem = jQuery(`
                <div id="js-pcat-extra-thematic-filter-col-${termID}" class="pcat-extra-thematic-filter-col">
                    <div class="pcat-extra-thematic-filter-item ${uppercaseCss}">${labelName}<span data-term-id="${termID}"></span></div>
                </div>
            `);

            // add close button event
            jQuery('span', $newElem).on('click', function(){
                const termID = jQuery(this).attr('data-term-id');

                jQuery(`#js-pcat-extra-thematic-filter-col-${termID}`).remove();
                jQuery('.js-pcat-filter-detail-parent[data-term-id=' + termID + ']').removeClass('active');
                jQuery('.pcat-filter-detail-child', jQuery('.js-pcat-filter-detail-parent[data-term-id=' + termID + ']').parent()).removeClass('disable');

                updateFilterCountLabel();
            })

            jQuery('#js-pcat-extra-thematic-filter-row').append($newElem);
        }

        updateFilterCountLabel();
    });

    jQuery('.js-pcat-filter-detail-child').on('click', function(){
        if( !jQuery(this).hasClass('disable') ){
            const termID = jQuery(this).attr('data-term-id')

            if( jQuery(this).hasClass('active') ){
                jQuery(this).removeClass('active')
                jQuery(`#js-pcat-extra-thematic-filter-col-${termID}`).remove();
            } else {
                const labelName = jQuery(this).text()

                jQuery(this).addClass('active')

                const $newElem = jQuery(`
                    <div id="js-pcat-extra-thematic-filter-col-${termID}" class="pcat-extra-thematic-filter-col">
                        <div class="pcat-extra-thematic-filter-item">${labelName}<span data-term-id="${termID}"></span></div>
                    </div>
                `);

                // add close button event
                jQuery('span', $newElem).on('click', function(){
                    const termID = jQuery(this).attr('data-term-id');

                    jQuery(`#js-pcat-extra-thematic-filter-col-${termID}`).remove();
                    jQuery('.js-pcat-filter-detail-child[data-term-id=' + termID + ']').removeClass('active');

                    updateFilterCountLabel();
                })

                jQuery('#js-pcat-extra-thematic-filter-row').append($newElem);
            }

            updateFilterCountLabel();
        }
    })

    // the thematic filter clear all button click
    jQuery('#js-pcat-extra-thematic-filter-link-clear').on('click', function(){
        jQuery('#js-pcat-extra-thematic-filter-row').html('');
        jQuery('.js-pcat-filter-detail-child').removeClass('active disable');
        jQuery('.js-pcat-filter-detail-parent').removeClass('active');
        jQuery('#js-pcat-extra-thematic-filter').addClass('hide');

        updateFilterCountLabel();

        return false;
    });

    // filter detail box hidden/show
    jQuery('#js-pcat-filter-row-wrapper').on('click', function(){
        if( jQuery('#js-pcat-filter-button-inner').hasClass('active') ){
            jQuery('#js-pcat-filter-button-inner').removeClass('active')
            jQuery('#js-pcat-filter-detail-row').slideUp();
        } else {
            jQuery('#js-pcat-filter-button-inner').addClass('active')
            jQuery('#js-pcat-filter-detail-row').slideDown();
        }
    })

    // page navigation click
    function addPageNavigationClickFunc(){
        jQuery('.js-pcat-results-navigation-item a').on('click', function(){

            // check this is current page
            if( !jQuery(this).parent().hasClass('active') ){
                const page = jQuery(this).attr('data-page');
              
                categoryProductSearch(page)
            }

            return false;
        })
    }

    addPageNavigationClickFunc();

    jQuery('.js-pcat-author-publisher-choice-item').on('change', function(){
        const choiceType = jQuery('.js-pcat-author-publisher-choice-item:checked').val();
        
        if( choiceType === 'publisher' ){
            $('#js-pcat-author-list').val(null).trigger('change');
            jQuery('#js-pcat-author-list-wrapper').addClass('hide');
            jQuery('#js-pcat-publisher-list-wrapper').removeClass('hide');
        } else if( choiceType === 'author' ){
            $('#js-pcat-publisher-list').val(null).trigger('change');
            jQuery('#js-pcat-publisher-list-wrapper').addClass('hide');
            jQuery('#js-pcat-author-list-wrapper').removeClass('hide');
        }
    });

    // mobile product category click
    jQuery('.js-pcat-filter-detail-root-icon').on('click', function(e){
        e.preventDefault();
        const parentElem = jQuery(this).parent().parent();

        if( jQuery(this).hasClass('active') ){
            jQuery(this).removeClass('active');
            jQuery('.pcat-filter-detail-child-wrapper', parentElem).slideUp();
        } else {
            jQuery(this).addClass('active');
            jQuery('.pcat-filter-detail-child-wrapper', parentElem).slideDown();
        }

        return false;
    });

    jQuery('#js-pcat-product-display-order').on('change', function(){
        categoryProductSearch(1);
    })

    // set event to initial category label list
    jQuery('div[id^=js-pcat-extra-thematic-filter-col-] span').on('click', function(){
        const termID = jQuery(this).attr('data-term-id');

        // check this is parent or child
        if( jQuery(this).parent().hasClass('pcat-extra-thematic-filter-item--root') > 0 ){
            jQuery(`#js-pcat-extra-thematic-filter-col-${termID}`).remove();
            jQuery('.js-pcat-filter-detail-parent[data-term-id=' + termID + ']').removeClass('active');
            jQuery('.pcat-filter-detail-child', jQuery('.js-pcat-filter-detail-parent[data-term-id=' + termID + ']').parent()).removeClass('disable');
        } else {
            jQuery(`#js-pcat-extra-thematic-filter-col-${termID}`).remove();
            jQuery('.js-pcat-filter-detail-child[data-term-id=' + termID + ']').removeClass('active');
        }

        updateFilterCountLabel();
    })
})