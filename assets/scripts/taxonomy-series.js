import Swiper, { Pagination, A11y, Autoplay } from 'swiper/swiper.esm'
import 'swiper/swiper-bundle.css'

Swiper.use([Pagination, A11y, Autoplay])

class MieteshopSeriesMetaSection extends window.HTMLDivElement {
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
    this.$videoSlider = jQuery('[data-video-slider]', this)
    this.$videoPagination = jQuery('[data-video-pagination]', this)
  }

  connectedCallback () {
    this.initVideoSlider()
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
}  
  
window.customElements.define('mieteshop-series-meta-section', MieteshopSeriesMetaSection, { extends: 'section' })

jQuery(function(){
  // get products with series term and page
  function taxonomySeriesProductSearch(page){
    const seriesTermId = jQuery('#js-taxonomy-series-product-row').attr('data-series-term-id');
    const nonce = jQuery('#js-taxonomy-series-product-row').attr('data-nonce');
    const productPerPage = jQuery('#js-taxonomy-series-product-row').attr('data-product-per-page');
    const productOrder = jQuery('#js-ts-product-display-order').val();

    jQuery('#js-ts-product-filter-load-spinner').removeClass('hide');

    jQuery.ajax({
      type: 'get',
      dataType: 'json',
      url: window.MieteshopData.ajaxurl,
      data: {
        action: 'filter_taxonomy_series_product',
        nonce,
        seriesTermId,
        page,
        productPerPage,
        productOrder
      },
      success: function (response) {
        jQuery('#js-taxonomy-series-product-row').html(response.result);
        jQuery('#js-taxonomy-series-product-navigation').html(response.navigation);

        // add page navigation click event into new added nav html
        addPageNavigationClickOfTaxonomySeriesFunc();

        jQuery('#js-ts-products-page-list').val(page);

        jQuery('#js-ts-product-filter-load-spinner').addClass('hide')

        jQuery('html, body').animate({
          scrollTop: jQuery('#js-tax-series-books').offset().top
        }, 500);
      }
    })
  }
  
  // page navigation click
  function addPageNavigationClickOfTaxonomySeriesFunc(){
    jQuery('.js-ts-product-navigation-item a').on('click', function(){

      // check this is current page
      if( !jQuery(this).parent().hasClass('active') ){
        const page = jQuery(this).attr('data-page');

        taxonomySeriesProductSearch(page)
      }

      return false;
    })
  }

  addPageNavigationClickOfTaxonomySeriesFunc();

  jQuery('#js-ts-products-page-list').on('change', function(){
    const pageNum = jQuery(this).val();

    taxonomySeriesProductSearch(pageNum);
  })

  jQuery('#js-ts-product-display-order').on('change', function(){
    taxonomySeriesProductSearch(1);
  })
})