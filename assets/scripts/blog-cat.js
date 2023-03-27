jQuery(function(){
    // get blogs
    function blogCatResultSearch(page){
        const nonce = jQuery('#js-blog-cat-result-row').attr('data-nonce');
        const catId = jQuery('#js-blog-cat-result-row').attr('data-cat-id');
        const postsPerPage = 8;

        jQuery('#js-blog-cat-filter-load-spinner').removeClass('hide');

        jQuery.ajax({
            type: 'get',
            dataType: 'json',
            url: window.MieteshopData.ajaxurl,
            data: {
                action: 'blog_cat_result',
                nonce,
                catId,
                page,
                postsPerPage
            },
            success: function (response) {
                jQuery('#js-blog-cat-result-row').html(response.result);
                jQuery('#js-blog-cat-results-navigation').html(response.navigation);
                
                // reset page number list
                const pageCounts = parseInt(response.pageCounts);

                if( pageCounts === 0 ){
                    jQuery('#js-blog-cat-list-page-navigation').addClass('hide');
                } else {
                    jQuery('#js-blog-cat-list-page-navigation').removeClass('hide');

                    // add page navigation click event into new added nav html
                    addPageNavigationClickOfBlogCatResultFunc();

                    let pageHtmlInnterStr = '';

                    for(let i = 1; i <= pageCounts; i++){
                        pageHtmlInnterStr += '<option value="' + i + '">' + i + '</option>'
                    }

                    jQuery('#js-blog-cat-page-list').html(pageHtmlInnterStr);
                    jQuery('#js-blog-cat-page-list').val(page);
                }

                jQuery('#js-blog-cat-filter-load-spinner').addClass('hide')
            }
        })
    }
    
    // page navigation click
    function addPageNavigationClickOfBlogCatResultFunc(){
        jQuery('.js-blog-cat-result-navigation-item a').on('click', function(){

            // check this is current page
            if( !jQuery(this).parent().hasClass('active') ){
                const page = jQuery(this).attr('data-page');

                blogCatResultSearch(page)
            }

            return false;
        })
    }

    addPageNavigationClickOfBlogCatResultFunc();

    jQuery('#js-blog-cat-page-list').on('change', function(){
        const page = jQuery(this).val();

        blogCatResultSearch(page);
    });
})