import Swiper, { Navigation, A11y, Autoplay } from 'swiper/swiper.esm'
import 'swiper/swiper-bundle.css'

Swiper.use([Navigation, A11y, Autoplay])

class MieteshopThreeBanner1Slider extends window.HTMLDivElement {
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
      slidesPerView: 1,
      spaceBetween: 0,
      speed: 1000,
      autoplay: {
        delay: 8000,
      },
      loop: true,
      navigation: {
        nextEl: this.$buttonNext.get(0),
        prevEl: this.$buttonPrev.get(0)
      }
    }
    
    this.slider = new Swiper(this.$slider.get(0), config)
  }
}

window.customElements.define('mieteshop-three-banner-1-slider', MieteshopThreeBanner1Slider, { extends: 'div' })