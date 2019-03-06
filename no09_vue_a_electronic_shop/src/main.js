import axios from 'axios'
import 'bootstrap'
import Loading from 'vue-loading-overlay'
import 'vue-loading-overlay/dist/vue-loading.css'
import TW from 'vee-validate/dist/locale/zh_TW'
import VeeValidate from 'vee-validate'

import Vue from 'vue'
import App from './App.vue'
import router from './router'
import './bus'
import currencyFilter from './currency'

Vue.use(VeeValidate)
VeeValidate.Validator.localize('tw', TW)
Vue.config.productionTip = false
Vue.prototype.$http = axios
axios.defaults.withCredentials = true
Vue.component('Loading', Loading)
Vue.filter('currency', currencyFilter)

router.beforeEach((to, from, next) => {
  console.log('to', to, 'from', from, 'next', next)
  if (to.meta.requiresAuth) {
    const api = `${process.env.VUE_APP_API}/api/user/check`
    axios.post(api).then((response) => {
      console.log('check', response.data)
      if (response.data.success) {
        next()
      } else {
        next({
          path: '/login'
        })
      }
    })
      .catch((err) => {
        console.log('哀沒網路啦...', err)
        alert('哀got some problem啦...', err)
        next()
      })
  } else {
    next()
  }
})

new Vue({
  router,
  render: h => h(App)
}).$mount('#app')
