import Swiper, { Pagination, A11y, Autoplay } from 'swiper/swiper.esm'
import 'swiper/swiper-bundle.css'

Swiper.use([Pagination, A11y, Autoplay])

class MieteshopProductMetaSection extends window.HTMLDivElement {
  constructor (...args) {
    const self = super(...args)
    self.init()
    return self
  }

  init () {
    this.reviewSlider = null;
    this.audioSlider = null;
    this.videoSlider = null;
    this.blogSlider = null;

    this.$ = jQuery(this)
    this.resolveElements()
  }

  resolveElements () {
    this.$tab = jQuery('[data-tab]', this)
    this.$reviewSlider = jQuery('[data-review-slider]', this)
    this.$reviewPagination = jQuery('[data-review-pagination]', this)
    this.$audioSlider = jQuery('[data-audio-slider]', this)
    this.$audioPagination = jQuery('[data-audio-pagination]', this)
    this.$videoSlider = jQuery('[data-video-slider]', this)
    this.$videoPagination = jQuery('[data-video-pagination]', this)
    this.$blogSlider = jQuery('[data-blog-slider]', this)
  }

  connectedCallback () {
    this.initReviewSlider()
    // this.initAudioSlider()
    // this.initVideoSlider()
    // this.initBlogSlider()
    this.initTab()
  }

  initReviewSlider () {
    const config = {
      slidesPerView: 1,
      speed: 1500,
      autoplay: {
        delay: 3000,
      },
      loop: true,
      pagination: {
        el: this.$reviewPagination.get(0),
        clickable: true,
      },
      observer: true,
      observeParents: true,
      spaceBetween: 50,
    }
    
    if( this.$reviewSlider.get(0) ){
      this.reviewSlider = new Swiper(this.$reviewSlider.get(0), config)
    }
  }

  initAudioSlider () {
    const config = {
      slidesPerView: 1,
      speed: 1500,
      autoplay: {
        delay: 3000,
      },
      loop: true,
      pagination: {
        el: this.$audioPagination.get(0),
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

    if( this.$audioSlider.get(0) ){
      this.audioSlider = new Swiper(this.$audioSlider.get(0), config)
    }
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
    
    if( this.$videoSlider.get(0) ){
      this.videoSlider = new Swiper(this.$videoSlider.get(0), config)
    }
  }

  initBlogSlider () {
    const config = {
      speed: 1500,
      autoplay: {
        delay: 3000,
      },
      loop: true,
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
    
    if( this.$blogSlider.get(0) ){
      this.blogSlider = new Swiper(this.$blogSlider.get(0), config)
    }
  }

  destoryReviewSlider(){
    if( this.reviewSlider ){
      this.reviewSlider.destroy(true, true);
    }
  }
  
  destoryAudioSlider(){
    if( this.audioSlider ){
      this.audioSlider.destroy(true, true);
    }
  }

  destoryVideoSlider(){
    if( this.videoSlider ){
      this.videoSlider.destroy(true, true);
    }
  }

  destoryBlogSlider(){
    if( this.blogSlider ){
      this.blogSlider.destroy(true, true);
    }
  }
  
  initTab () {
    const that = this;

    this.$tab.on('click', function(){
      if( !jQuery(this).hasClass('active') ){
        const sectionID = jQuery(this).attr('data-section-id');

        if( sectionID === 'review' ){
          that.initReviewSlider()
          that.destoryAudioSlider()
          that.destoryVideoSlider()
          that.destoryBlogSlider()
        } else if( sectionID === 'audio' ){
          that.initAudioSlider()
          that.destoryReviewSlider()
          that.destoryVideoSlider()
          that.destoryBlogSlider()
        } else if( sectionID === 'video' ){
          that.initVideoSlider()
          that.destoryReviewSlider()
          that.destoryAudioSlider()
          that.destoryBlogSlider()
        } else if( sectionID === 'article' ){
          that.initBlogSlider()
          that.destoryReviewSlider()
          that.destoryAudioSlider()
          that.destoryVideoSlider()
        }
  
        jQuery('.single-product-meta-tab-content-col').addClass('hide');
        jQuery(`#single-product-meta-tab-content--${sectionID}`).removeClass('hide');
  
        jQuery('.single-product-meta-tab-item').removeClass('active');
        jQuery(this).addClass('active');
      }
    })
  }
}

window.customElements.define('mieteshop-product-meta-section', MieteshopProductMetaSection, { extends: 'section' })

class MieteshopProductGallerySlider extends window.HTMLDivElement {
  constructor (...args) {
    const self = super(...args)
    self.init()
    return self
  }

  init () {
    this.$ = jQuery('.swiper-container', this)
    this.resolveElements()
  }

  resolveElements () {
    this.$pagination = jQuery('.single-product-gallery-slider__pagination', this)
  }

  connectedCallback () {
    this.initSlider()
  }

  initSlider () {
    const config = {
      slidesPerView: 1,
      spaceBetween: 0,
      // autoplay: {
      //   delay: 300,
      // },
      loop: true,
      pagination: {
        el: this.$pagination.get(0)
      }
    }

    this.slider = new Swiper(this.$.get(0), config)
  }
}

window.customElements.define('mieteshop-product-gallery-slider', MieteshopProductGallerySlider, { extends: 'div' })

jQuery(function(){
  jQuery('.single-product-tab-header-item').on('click', function(){
    if( !jQuery(this).hasClass('active') ){
      const sectionID = jQuery(this).attr('data-section-id');

      jQuery('.single-product-tab-content-item').addClass('hide');
      jQuery(`#single-product-tab-content-item--${sectionID}`).removeClass('hide');

      jQuery('.single-product-tab-header-item').removeClass('active');
      jQuery(this).addClass('active');
    }
  })
})