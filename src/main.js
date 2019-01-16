import Vue from 'vue'
import App from './App.vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import { router } from './router'
 
Vue.use(VueAxios, axios)

// var eventBus = new Vue();

window.axios = axios
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
new Vue({
  router,
  el: '#app',
  render: h => h(App)
}
)
