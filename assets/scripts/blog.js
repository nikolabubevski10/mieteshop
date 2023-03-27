jQuery(function(){
    // get blogs
    function blogResultSearch(page){
        const nonce = jQuery('#js-blog-result-row').attr('data-nonce');
        const catId = jQuery('#js-blog-cat-filter-select').val();
        // const postsPerPage = jQuery('#js-blog-per-page').val();
        const postsPerPage = 9;

        jQuery('#js-blog-filter-load-spinner').removeClass('hide');

        jQuery.ajax({
            type: 'get',
            dataType: 'json',
            url: window.MieteshopData.ajaxurl,
            data: {
                action: 'filter_blog_result',
                nonce,
                catId,
                page,
                postsPerPage
            },
            success: function (response) {
                jQuery('#js-blog-first').html(response.hero);
                jQuery('#js-blog-result-row').html(response.result);
                jQuery('#js-blog-results-navigation').html(response.navigation);
                
                // reset page number list
                const pageCounts = parseInt(response.pageCounts);

                if( pageCounts === 0 ){
                    jQuery('#js-blog-list-page-navigation').addClass('hide');
                } else {
                    jQuery('#js-blog-list-page-navigation').removeClass('hide');

                    // add page navigation click event into new added nav html
                    addPageNavigationClickOfBlogResultFunc();

                    let pageHtmlInnterStr = '';

                    for(let i = 1; i <= pageCounts; i++){
                        pageHtmlInnterStr += '<option value="' + i + '">' + i + '</option>'
                    }

                    jQuery('#js-blog-page-list').html(pageHtmlInnterStr);
                    jQuery('#js-blog-page-list').val(page);
                }

                jQuery('#js-blog-filter-load-spinner').addClass('hide')
            }
        })
    }
    
    // page navigation click
    function addPageNavigationClickOfBlogResultFunc(){
        jQuery('.js-blog-result-navigation-item a').on('click', function(){

            // check this is current page
            if( !jQuery(this).parent().hasClass('active') ){
                const page = jQuery(this).attr('data-page');

                blogResultSearch(page)
            }

            return false;
        })
    }

    addPageNavigationClickOfBlogResultFunc();

    jQuery('#js-blog-page-list').on('change', function(){
        const page = jQuery(this).val();

        blogResultSearch(page);
    });

    jQuery('#js-blog-cat-filter-select').on('change', function(){
        blogResultSearch(1);
    })
    
    jQuery('#js-blog-per-page').on('change', function(){
        blogResultSearch(1);
    })
})