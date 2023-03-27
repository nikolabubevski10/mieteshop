import Swiper, { Navigation, A11y, Autoplay } from 'swiper/swiper.esm'
import 'swiper/swiper-bundle.css'

Swiper.use([Navigation, A11y, Autoplay])

class MieteshopBookSlider extends window.HTMLDivElement {
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
      // autoplay: {
      //   delay: 15000,
      // },
      loop: true,
      navigation: {
        nextEl: this.$buttonNext.get(0),
        prevEl: this.$buttonPrev.get(0)
      },
      breakpoints : {
        320 : {
          slidesPerView: 1,
          slidesPerGroup: 1,
        },
        768 : {
          slidesPerView: 4,
          slidesPerGroup: 4,
          spaceBetween: 50,
        }
      }
    }
    
    this.slider = new Swiper(this.$slider.get(0), config)
  }
}

window.customElements.define('mieteshop-book-slider', MieteshopBookSlider, { extends: 'section' })