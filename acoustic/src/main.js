import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import Axios from 'axios'

Vue.config.productionTip = false;
// 初始化默认布局
import './assets/css/reset.css';
// font-awesome
import '../node_modules/font-awesome/css/font-awesome.min.css';
// 搞个中间件用来传参
Vue.prototype.bus = new Vue();
// axios
Vue.prototype.$axios = Axios;
Axios.defaults.baseURL = '/api';
// User类
import User from './assets/js/User/User.js';
Vue.prototype.$User = User;
// 引入BootStrap
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';
import 'bootstrap-vue/dist/bootstrap-vue.css';
import 'bootstrap/dist/css/bootstrap.css';
// 使用中间件
Vue.use(BootstrapVue);
Vue.use(IconsPlugin);
// 引入animate.css
import animated from 'animate.css';
Vue.use(animated);
// 引入验证类
import Validate from './assets/js/Validate/Validate.js';
Vue.prototype.$validate = new Validate();
// 引入aplayer
import APlayer from '@moefe/vue-aplayer';
Vue.use(APlayer, {
  productionTip: true,
  defaultCover: 'https://github.com/u3u.png'
});

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')
