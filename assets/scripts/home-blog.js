import Swiper, { Navigation, A11y, Autoplay } from 'swiper/swiper.esm'
import 'swiper/swiper-bundle.css'

Swiper.use([Navigation, A11y, Autoplay])

class MieteshopHomeBlogSlider extends window.HTMLDivElement {
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
    this.$slider = jQuery('[data-slider]', this)
    this.$buttonNext = jQuery('[data-slider-button="next"]', this)
    this.$buttonPrev = jQuery('[data-slider-button="prev"]', this)
  }

  connectedCallback () {
    this.initSlider()
  }

  initSlider () {
    const config = {
      speed: 1000,
      autoplay: {
        delay: 8000,
      },
      loop: false, //changed to false to fix bug with duplicate same item when only one
      navigation: {
        nextEl: this.$buttonNext.get(0),
        prevEl: this.$buttonPrev.get(0)
      },
      breakpoints : {
        320 : {
          slidesPerView: 1,
        },
        768 : {
          slidesPerView: 2,
          spaceBetween: 120,
        }
      }
    }
    
    this.slider = new Swiper(this.$slider.get(0), config)
  }
}

window.customElements.define('mieteshop-home-blog-slider', MieteshopHomeBlogSlider, { extends: 'div' })