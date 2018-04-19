
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.Vue = require('vue');
import VueRouter from 'vue-router'
import { router } from './routes'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import Vue2Filters from 'vue2-filters'

Vue.use(Vue2Filters) 
Vue.use(Vuetify)
Vue.use(VueRouter)

window.toQueryFilter = (array) => {
  const filters = array.filter(value => value).join('&')
  return filters ? '?' + filters : ''
}

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import App from './views/App'

const app = new Vue({
    el: '#app',
    components: { App },
    router,
});
