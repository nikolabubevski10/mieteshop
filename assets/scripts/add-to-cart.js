jQuery(function(){
    
    jQuery('body').on('click', '.js-mieteshop-add-to-cart', function(e){
        e.preventDefault();
        
        const product_qty = jQuery(this).attr('data-quantity');
        const product_id = jQuery(this).attr('data-product_id');
        const variation_id = jQuery(this).attr('data-variation_id');
        const product_sku = jQuery(this).attr('data-product_sku');

        jQuery.ajax({
            type: 'post',
            dataType: 'json',
            url: wc_add_to_cart_params.ajax_url,
            data: {
                action: 'woocommerce_ajax_add_to_cart',
                product_id,
                product_sku,
                quantity: product_qty,
                variation_id,
            },
            beforeSend: function (response) {
                jQuery('body').append('<div id="js-ajax-add-to-cart-load-spinner" class="load-spinner"></div>');
            },
            complete: function (response) {
                jQuery('#js-ajax-add-to-cart-load-spinner').remove();
            },
            success: function (response) {
                if (response.error && response.product_url) {
                    window.location = response.product_url;
                    return;
                } else {
                    jQuery(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash]);
                    jQuery('body').append('<div id="js-ajax-add-to-cart-message-modal" class="message-modal">Το προϊόν προστέθηκε στο καλάθι σας</div>');
                    //jQuery('#js-ajax-add-to-cart-message-modal').delay(2500).fadeOut().remove();           
                    setTimeout(function () {
                        jQuery('#js-ajax-add-to-cart-message-modal').fadeOut(1500).remove();
                    }, 2000);                    
                }
            },
        });

        return false;
    })

    function addEventToCustomCartElement(){
        jQuery('.js-cart-product-quantity-button').on('click', function(){
            jQuery('#js-update-cart-btn').trigger('click');
        })

        jQuery('#js-cart-coupon-custom-form-button').on('click', function(){
            const couponVal = jQuery('#js-cart-coupon-custom-form-input').val();
    
            jQuery('#coupon_code').val(couponVal);
            jQuery('button[type=submit]', jQuery('#coupon_code').parent()).trigger('click');
        })
    }

    addEventToCustomCartElement()

    // at the cart page, whenever info will update, add event again
    jQuery(document.body).on('updated_cart_totals', function(){
        addEventToCustomCartElement()
    });
})