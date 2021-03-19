<template>
  <div id="home">
    <app-header></app-header>
    <transition mode="out-in" name="slade">
      <router-view></router-view>
    </transition>
    <app-footer></app-footer>
  </div>
</template>

<script>
  import AppHeader from './components/AppHeader.vue';
  import {
    mapState,
    mapActions
  } from 'vuex';
  import AppFooter from './components/AppFooter.vue';

  export default {
    name: 'Home',
    components: {
      AppHeader,
      AppFooter
    },
    methods: {
      ...mapActions(['getLoginStatus', 'getUserInfo', 'getUserMessages', 'getUserComments'])
    },
    computed: {
      ...mapState(['loginStatus'])
    },
    mounted() {
      let status = this.getLoginStatus();
      if (status) {
        this.getUserInfo();
        this.getUserMessages();
        this.getUserComments();
      }
    }
  }
</script>

<style lang="less" scoped>
  #home {
    width: 100%;
    overflow: hiden;

    // 路由动画
    .slade-enter {
      transform: translateX(100%);
      opacity: 0;
    }

    .slade-enter-active,
    .slade-leave-active {
      transition: all .3s;
    }

    .slade-leave-to {
      transform: translateX(-100%);
      opacity: 0;
    }

    .slade-enter-to,
    .slade.leave {
      transform: translateX(0);
      opacity: 1;
    }
  }
</style>