import { disableBodyScroll, enableBodyScroll } from 'body-scroll-lock'

jQuery(function(){
  // Open sub menu and keep open. Close when hovering over a different menu item
  // jQuery('.js-header-nav-parent-menu').hover(
  //   function () {
  //     var menuID = jQuery(this).attr('data-menu-id');
  //     // jQuery(this).addClass('active');

  //     setTimeout(function () {
  //       jQuery('.header-sub-menu.active').removeClass('active')
  //       jQuery(`#header-sub-menu-${menuID}`).addClass('active');
  //     }, 200)
  //   }
  // )

  // jQuery('.header-sub-menu').hover(
  //   function () {
  //     var $this = jQuery(this);

  //     setTimeout(function () {
  //       jQuery('.header-sub-menu.active').removeClass('active')
  //       jQuery($this).addClass('active');
  //     }, 200)
  //   }
  // )

  // jQuery('.js-header-nav-menu').hover(
  //   function () {

  //     setTimeout(function () {
  //       // jQuery('.js-header-nav-parent-menu.active').removeClass('active')
  //       jQuery('.header-sub-menu.active').removeClass('active')
  //     }, 200)
  //   }
  // )

  // Close sub menu when not hovering header menu element
  // jQuery('.header-nav').hover(function () {}, function () {
  //   setTimeout(function () {
  //     // jQuery('.js-header-nav-parent-menu.active').removeClass('active')
  //     jQuery('.header-sub-menu.active').removeClass('active')
  //   }, 200)
  // })

  jQuery('.js-header-nav-parent-menu').on('click', 
    function () {
      var menuID = jQuery(this).attr('data-menu-id');
      
      if( jQuery(`#header-sub-menu-${menuID}`).hasClass('active') ){
        jQuery(`#header-sub-menu-${menuID}`).removeClass('active');
        jQuery(this).parent().removeClass('open');
        //jQuery(this).removeClass('open');
      } else {
        jQuery('.header-sub-menu.active').removeClass('active');
        jQuery(`#header-sub-menu-${menuID}`).addClass('active');
        jQuery(this).parent().addClass('open');
        //jQuery(this).addClass('open');
      }

      return false;
    }
  )

  // header top search icon click
  jQuery('#js-header-top-search-icon').click(function(){
    if( jQuery('#js-header-top-search-popup').hasClass('active') ){
      jQuery('#js-header-top-search-popup').removeClass('active');
      jQuery(this).removeClass('active');
    } else {
      jQuery('#js-header-top-search-popup').addClass('active');
      jQuery(this).addClass('active');

      // after appearing auto complete box, set focus the inputfield
      // as the popup has fade in effect for .2s, we need the time delay
      setTimeout(function(){
        document.getElementById('js-header-top-search-form-text').focus();
      }, 300);
    }
  })

  // header top favorite icon click
  jQuery('body').on('click', '#js-header-top-favorite-icon', function(){
    if( jQuery('#js-header-top-favorite-popup').hasClass('active') ){
      jQuery('#js-header-top-favorite-popup').removeClass('active');
      jQuery(this).removeClass('active');
    } else {
      jQuery('#js-header-top-favorite-popup').addClass('active');
      jQuery(this).addClass('active');
    }
  })

  // header top busket icon click
  jQuery('#js-header-top-busket-icon').click(function(){
    if( jQuery('#js-header-top-busket-popup').hasClass('active') ){
      jQuery('#js-header-top-busket-popup').removeClass('active');
      jQuery(this).removeClass('active');
    } else {
      jQuery('#js-header-top-busket-popup').addClass('active');
      jQuery(this).addClass('active');
    }
  })

  // header top user icon click
  jQuery('#js-header-top-user-icon').click(function(){
    if( jQuery('#js-header-top-user-popup').hasClass('active') ){
      jQuery('#js-header-top-user-popup').removeClass('active');
      jQuery(this).removeClass('active');
    } else {
      jQuery('#js-header-top-user-popup').addClass('active');
      jQuery(this).addClass('active');
    }
  })

  // close header popup when the outside of popup is clicked
  jQuery(document).on("click", function (event) {
    if( jQuery('#js-header-top-search-popup').hasClass('active') ){
      if (jQuery(event.target).closest("#js-header-top-search-popup,#js-header-top-search-icon").length === 0) {
        jQuery('#js-header-top-search-popup').removeClass('active');
        jQuery('#js-header-top-search-icon').removeClass('active');
      }
    }

    if( jQuery('#js-header-top-favorite-popup').hasClass('active') ){
      if (jQuery(event.target).closest("#js-header-top-favorite-popup,#js-header-top-favorite-icon").length === 0) {
        jQuery('#js-header-top-favorite-popup').removeClass('active');
        jQuery('#js-header-top-favorite-icon').removeClass('active');
      }
    }

    if( jQuery('#js-header-top-busket-popup').hasClass('active') ){
      if (jQuery(event.target).closest("#js-header-top-busket-popup,#js-header-top-busket-icon").length === 0) {
        jQuery('#js-header-top-busket-popup').removeClass('active');
        jQuery('#js-header-top-busket-icon').removeClass('active');
      }
    }

    if( jQuery('#js-header-top-user-popup').hasClass('active') ){
      if (jQuery(event.target).closest("#js-header-top-user-popup,#js-header-top-user-icon").length === 0) {
        jQuery('#js-header-top-user-popup').removeClass('active');
        jQuery('#js-header-top-user-icon').removeClass('active');
      }
    }
  });

  jQuery('#js-header-top-mobile-menu-btn').on('click', function(){
    if( jQuery(this).hasClass('is-open') ){
      enableBodyScroll(document.querySelector('#js-header-nav .container'))

      jQuery(this).removeClass('is-open')
      jQuery('#js-header-top-right').removeClass('hide');
      jQuery('#js-header-nav').removeClass('header-nav-mobile-visible')
    } else {
      disableBodyScroll(document.querySelector('#js-header-nav .container'))

      jQuery(this).addClass('is-open')
      jQuery('#js-header-top-right').addClass('hide');
      jQuery('#js-header-nav').addClass('header-nav-mobile-visible')

      // Measure height of window
      jQuery('#js-header-nav').innerHeight(window.innerHeight)
    }
  })

  // at the mobile, when portrait and landspace is changing, calculate window height and set it to the mobile menu container
  jQuery(window).on('resize', function(){
    // Measure height of window
    if( window.innerWidth < 768 ){
      jQuery('#js-header-nav').innerHeight(window.innerHeight)
    } else {
      jQuery('#js-header-nav').removeAttr('style')
    }
  })


  jQuery('.js-header-nav-mobile-arrow-wrapper').on('click', function(){
    const parentElem = jQuery(this).parent();

    if( jQuery(this).hasClass('is-open') ){
      jQuery('.js-header-nav-mobile-sub-wrapper', parentElem).slideUp();
      jQuery(this).removeClass('is-open');
    } else {
      jQuery('.js-header-nav-mobile-sub-wrapper', parentElem).slideDown();
      jQuery(this).addClass('is-open');
    }
  })

  jQuery('.js-header-nav-mobile-sub-arrow-wrapper').on('click', function(){
    const parentElem = jQuery(this).parent();

    if( jQuery(this).hasClass('is-open') ){
      jQuery('.js-header-nav-mobile-sub-sub-wrapper', parentElem).slideUp();
      jQuery(this).removeClass('is-open');
    } else {
      jQuery('.js-header-nav-mobile-sub-sub-wrapper', parentElem).slideDown();
      jQuery(this).addClass('is-open');
    }
  })
})

jQuery('.header-nav-mobile-sub-sub a').on('click', function(event){
  event.stopImmediatePropagation(); //so that menu sub item a can be clickable
})
