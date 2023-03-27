import 'normalize.css/normalize.css'
import './main.scss'

import installCE from 'document-register-element/pony'


window.lazySizesConfig = window.lazySizesConfig || {}
window.lazySizesConfig.preloadAfterLoad = true
require('lazysizes')

installCE(window, {
  type: 'force',
  noBuiltIn: true
})

function importAll (r) {
  r.keys().forEach(r)
}

importAll(require.context('./scripts/', true, /\/*\.js$/))

// when browser back / forward was clicked, hash change will reload page
window.addEventListener('popstate', function(event){
  // if( event.state && event.state.additionalInformation && event.state.additionalInformation === 'mieteshop-nav-hash-change' ){
    location.reload();
  // }
});