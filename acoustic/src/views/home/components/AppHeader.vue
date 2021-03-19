<template>
  <div id="appHeader" :class="onSticky ? 'sticky' : ''">
    <ul class="burger" @click="open">
      <li class="line"></li>
      <li class="line"></li>
      <li class="line"></li>
    </ul>
    <div class="logo" @click="toHome">{{ logoName }}</div>
    <div class="navbar">
      <!-- 联想搜索 -->
      <search-box></search-box>
      <div ref="nav" :class="['nav',isNavOpen?'open':'']">
        <router-link :class="['navItem',nav.className, activeClass===nav.className?'active':'']"
          v-for="(nav,key) of navContent" :to="nav.path" :key="key">
          {{ nav.name }}
        </router-link>
        <div v-if="!loginStatus" class="login" @click="toLogin">登录</div>
        <user v-else class="user-info"></user>
      </div>
    </div>
  </div>
</template>

<script>
  import User from './User.vue';
  import {
    mapState
  } from 'vuex';
  import SearchBox from './SearchBox.vue';

  export default {
    name: 'AppHeader',
    components: {
      User,
      SearchBox
    },
    data() {
      return {
        // 导航栏是否开启
        isNavOpen: false,
        onSticky: false,
        // 导航信息
        navContent: [{
            name: '主页',
            className: 'home',
            path: '/'
          },
          {
            name: '一览风采',
            className: 'glance',
            path: '/glance'
          },
          {
            name: '视频观赏',
            className: 'video',
            path: '/video'
          },
          {
            name: '论坛',
            className: 'bbs',
            path: '/bbs'
          }
        ],
        // 焦点导航元素
        activeClass: '',
      };
    },
    methods: {
      // 跳转到首页
      toHome() {
        if (this.$route.path !== '/') {
          this.$router.push('/');
        }
      },

      // 跳转到登录页面
      toLogin() {
        this.$router.push('/login');
      },

      // 打开菜单
      open() {
        this.isNavOpen = !this.isNavOpen;
        // 点击其他地方时自动关闭菜单，在捕获阶段调用错开打开导航的事件
        window.addEventListener('click', (e) => {
          if (e.target != this.$refs.nav) {
            this.isNavOpen = false;
          }
        }, true);
        window.addEventListener('scroll', (e) => {
          if (e.target != this.$refs.nav) {
            this.isNavOpen = false;
          }
        }, true);
      },

      // 改变焦点
      changeActiveClass(activeClass) {
        this.activeClass = activeClass;
      }
    },
    computed: {
      logoName() {
        let {
          clientWidth
        } = document.documentElement;
        if (clientWidth <= 612) {
          return 'YA';
        } else {
          return 'yAcoustic';
        }
      },
      ...mapState(['loginStatus'])
    },
    created() {
      if (this.$route.path == '/') {
        this.activeClass = 'home';
      }
      // 监听事件用来改变焦点类
      this.bus.$on('changeActiveClass', this.changeActiveClass);
    },
  }
</script>

<style lang="less" scoped>
  @font-face {
    font-family: 'Parisienne';
    src: url('../../../assets/font/Parisienne.ttf') format('truetype');
  }

  @fontSize: 1.2rem;
  @mainColor: #afafb7;
  @navfontColor: #616166;
  @titleColor: #211f1d;
  @loginColor: #ea8f19;

  a,
  a:hover {
    text-decoration: none !important;
  }

  .active {
    border: 3px solid @navfontColor  !important;
  }

  #appHeader {
    width: 100%;
    height: 3.5rem;
    box-sizing: border-box;
    padding: 0.8rem 3rem;
    display: flex;
    justify-content: space-between;
    align-items: center;

    * {
      flex-shrink: 0;
    }

    .logo {
      font: bolder italic 1.8rem 'Parisienne';
      text-transform: capitalize;
      color: @titleColor;
      margin-right: 1rem;
      cursor: pointer;
    }

    .navbar {
      display: flex;
      align-items: center;

      .nav {
        display: flex;
        align-items: center;

        .navItem,
        .login {
          padding: .3rem;
          margin: 0 0.3rem;
          cursor: pointer;
          font-size: @fontSize;
          border-radius: .3rem;
          border: 3px solid transparent;
          transition-property: border;
          transition-duration: .3s;
          color: @titleColor;

          &:hover {
            border: 3px solid @navfontColor ;
          }
        }

        .user-info {
          margin-left: .3rem;
        }
      }
    }

    .burger {
      display: none;
      padding: .3rem;
      cursor: pointer;
      margin: 0;

      .line {
        width: 1.5rem;
        height: .2rem;
        background-color: #333;
        margin: 3px 0;
      }
    }

    @media screen and (max-width: 768px) {
      justify-content: flex-start;
      padding: 0.8rem 1rem;

      .burger {
        display: block;
      }

      .logo {
        margin-left: 1rem;
        margin-right: auto;
      }

      .navbar {
        .nav {
          width: 45vw;
          height: 100vh;
          display: flex;
          flex-direction: column;
          justify-content: flex-start;
          align-items: flex-start;
          position: fixed;
          z-index: 150;
          left: -50vw;
          top: 3.5rem;
          transition: all .3s;
          background-color: @mainColor;
          opacity: .9;
          overflow: hidden;

          a {
            display: block;
            margin: .5rem .3rem !important;
          }

          .user-info,
          .login {
            padding: 0.5rem;
            padding-left: .3rem;
            margin: 0;
            box-sizing: border-box;
            cursor: pointer;
            border-radius: .3rem;
            border: 3px solid transparent;
            transition: border .3s;
            width: 100%;
            position: relative;
            background-color: inherit;
            color: inherit;

            &:hover {
              border: 3px solid @navfontColor;
            }

            &::after {
              content: '';
              display: block;
              width: 100%;
              height: 1px;
              background-color: @navfontColor;
              position: absolute;
              top: 120%;
              left: 0;
            }
          }

          .login {
            padding-left: .8rem;
          }

          &.open {
            transform: translateX(50vw);
          }
        }
      }
    }
  }
</style>