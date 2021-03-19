import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/home/Home.vue'
import Login from '../views/login/login.vue'
import Glance from '../views/glance/Glance.vue'
import HomePage from '../views/home/components/HomePage.vue'
import UserInfo from '../views/userInfo/UserInfo.vue'
import Video from '../views/video/Video.vue'
import Bbs from '../views/bbs/Bbs.vue'
import UploadImage from '../views/uploadImage/UploadImage.vue'
import UploadVideo from '../views/uploadVideo/UploadVideo.vue'
import Publish from '../views/publish/Publish.vue'
import Article from '../views/Article/Article.vue'
import MessageBox from '../views/messageBox/MessageBox.vue'
import WorksManagement from '../views/WorksManagement/WorksManagement.vue'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    component: Home,
    children: [
      {
        path: '/',
        name: 'Home',
        component: HomePage
      },
      {
        path: '/glance',
        name: 'Glance',
        component: Glance
      },
      {
        path: '/video',
        component: Video
      },
      {
        path: '/bbs',
        component: Bbs,
      },
      {
        path: 'publish',
        component: Publish
      },
      {
        path: '/article',
        name: 'Article',
        component: Article
      },
      {
        path: '/messageBox',
        name: 'MessageBox',
        component: MessageBox
      },
      {
        path: '/worksManagement',
        name: 'WorksManagement',
        component: WorksManagement
      }
    ]
  },
  {
    path: '/login',
    name: 'Login',
    component: Login
  },
  {
    path: '/userInfo',
    name: 'UserInfo',
    component: UserInfo
  },
  {
    path: '/uploadImage',
    name: 'UploadImage',
    component: UploadImage
  },
  {
    path: '/uploadVideo',
    name: 'UploadVideo',
    component: UploadVideo
  },
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

// 全局路由守卫改变导航状态
router.beforeEach((to, from, next) => {
  let activeClass = to.name ? to.name.toLowerCase() : '';
  // 向外触发事件改变导航状态
  Vue.prototype.bus.$emit('changeActiveClass', activeClass);
  next();
});

router.afterEach((to, from) => {
  if (to.name == 'Home') {
    setTimeout(() => {
      document.body.classList.add('guitar');
    }, 400);
  } else {
    document.body.classList.contains('guitar') ? document.body.classList.remove('guitar') : '';
  }
});

export default router
