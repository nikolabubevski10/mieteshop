import Swiper, { Navigation, A11y, Autoplay, Thumbs } from 'swiper/swiper.esm'
import 'swiper/swiper-bundle.css'

Swiper.use([Navigation, A11y, Autoplay, Thumbs])

class MieteshopPostSlider extends window.HTMLDivElement {
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
    this.$slider = jQuery('[data-big-slider]', this)
    this.$buttonNext = jQuery('[data-slider-button="next"]', this)
    this.$buttonPrev = jQuery('[data-slider-button="prev"]', this)

    this.$smallSlider = jQuery('[data-small-slider]', this)
  }

  connectedCallback () {
    this.initSlider()
  }

  initSlider () {
    const smallConfig = {
      spaceBetween: 10,
      slidesPerView: 'auto',
      speed: 1000,
      autoplay: {
        delay: 5000,
      },
      // freeMode: true,
      // watchSlidesVisibility: true,
      // watchSlidesProgress: true,
      //loop: true,
    }
    
    this.smallSlider = new Swiper(this.$smallSlider.get(0), smallConfig)

    const config = {
      slidesPerView: 1,
      speed: 1000,
      autoplay: {
        delay: 5000,
      },
      loop: true,
      navigation: {
        nextEl: this.$buttonNext.get(0),
        prevEl: this.$buttonPrev.get(0)
      },
      thumbs: {
        swiper: this.smallSlider,
      }
    }
    
    this.bigSlider = new Swiper(this.$slider.get(0), config)
  }
}

window.customElements.define('mieteshop-post-slider', MieteshopPostSlider, { extends: 'div' })