import Swiper, { Pagination, A11y, Autoplay } from 'swiper/swiper.esm'
import 'swiper/swiper-bundle.css'

Swiper.use([Pagination, A11y, Autoplay])

class MieteshopContributorMetaSection extends window.HTMLDivElement {
  constructor (...args) {
    const self = super(...args)
    self.init()
    return self
  }

  init () {
    this.$ = jQuery(this)
    this.resolveElements()
  }

  resolveElements () {
    this.$tab = jQuery('[data-tab]', this)
    this.$videoSlider = jQuery('[data-video-slider]', this)
    this.$videoPagination = jQuery('[data-video-pagination]', this)
    this.$blogSlider = jQuery('[data-blog-slider]', this)
  }

  connectedCallback () {
    this.initVideoSlider()
    // this.initBlogSlider()
    this.initTab()
  }

  initVideoSlider () {
    const config = {
      slidesPerView: 1,
      speed: 1500,
      autoplay: {
        delay: 3000,
      },
      loop: true,
      pagination: {
        el: this.$videoPagination.get(0),
        clickable: true,
      },
      observer: true,
      observeParents: true,
      breakpoints : {
        320 : {
          spaceBetween: 50,
        },
        768 : {
          spaceBetween: 120,
        }
      }
    }
    
    this.videoSlider = new Swiper(this.$videoSlider.get(0), config)
  }

  initBlogSlider () {
    const config = {
      speed: 1500,
      autoplay: {
        delay: 3000,
      },
      loop: false,
      observer: true,
      observeParents: true,
      breakpoints : {
        320 : {
          slidesPerView: 1,
          spaceBetween: 50,
        },
        768 : {
          slidesPerView: 'auto',
          spaceBetween: 120,
        }
      }
    }
    
    this.blogSlider = new Swiper(this.$blogSlider.get(0), config)
  }

  destoryVideoSlider(){
    this.videoSlider.destroy(true, true);
  }
  
  destoryBlogSlider(){
    this.blogSlider.destroy(true, true);
  }

  initTab () {
    const that = this;
    
    this.$tab.on('click', function(){
      if( !jQuery(this).hasClass('active') ){
        const sectionID = jQuery(this).attr('data-section-id');

        if( sectionID === 'video' ){
          that.initVideoSlider()
          that.destoryBlogSlider()          
        } else if( sectionID === 'article' ){
          that.initBlogSlider()
          that.destoryVideoSlider()
        }
  
        jQuery('.single-contributor-meta-tab-content-col').addClass('hide');
        jQuery(`#single-contributor-meta-tab-content--${sectionID}`).removeClass('hide');
  
        jQuery('.single-contributor-meta-tab-item').removeClass('active');
        jQuery(this).addClass('active');
      }
    })
  }
}

window.customElements.define('mieteshop-contributor-meta-section', MieteshopContributorMetaSection, { extends: 'section' })

jQuery(function(){

  // get products with publisher and page
  function singleContributorProductSearch(page){
    const filterContributorId = jQuery('#js-single-contributor-product-row').attr('data-contributor-id');
    const nonce = jQuery('#js-single-contributor-product-row').attr('data-nonce');
    const productPerPage = jQuery('#js-single-contributor-product-row').attr('data-product-per-page');

    jQuery('#js-single-contributor-product-filter-load-spinner').removeClass('hide');

    jQuery.ajax({
      type: 'get',
      dataType: 'json',
      url: window.MieteshopData.ajaxurl,
      data: {
        action: 'filter_single_contributor_product',
        nonce,
        filterContributorId,
        page,
        productPerPage
      },
      success: function (response) {
        jQuery('#js-single-contributor-product-row').html(response.result);
        jQuery('#js-single-contributor-product-navigation').html(response.navigation);

        // add page navigation click event into new added nav html
        addPageNavigationClickOfSCProductFunc();

        jQuery('#js-sc-page-list').val(page);

        jQuery('#js-single-contributor-product-filter-load-spinner').addClass('hide')

        jQuery('html, body').animate({
          scrollTop: jQuery('#js-single-contributor-books').offset().top
        }, 500);
      }
    })
  }
  
  // page navigation click
  function addPageNavigationClickOfSCProductFunc(){
    jQuery('.js-sc-product-navigation-item a').on('click', function(){
      // check this is current page
      if( !jQuery(this).parent().hasClass('active') ){
        const page = jQuery(this).attr('data-page');

        singleContributorProductSearch(page)
      }

      return false;
    })
  }

  addPageNavigationClickOfSCProductFunc();

  jQuery('#js-sc-page-list').on('change', function(){
    const pageNumber = jQuery(this).val();

    singleContributorProductSearch(pageNumber);
  });

  jQuery('.js-sc-video-image-wrapper').on('click', function(){
    const parentElem = jQuery(this).parent();

    jQuery('#js-sc-video-popup__video-wrapper').html(jQuery('.single-contributor-video-hidden', parentElem).html());
    jQuery('#js-sc-video-popup').removeClass('hide')
  });

  jQuery('#js-sc-video-popup__close-btn').on('click', function(){
    jQuery('#js-sc-video-popup').addClass('hide');
    jQuery('#js-sc-video-popup__video-wrapper').html('');
  })

  jQuery('#js-sc-video-popup').on('click', function(){
    jQuery('#js-sc-video-popup').addClass('hide');
    jQuery('#js-sc-video-popup__video-wrapper').html('');
  })
})