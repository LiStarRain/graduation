<template>
  <div id="login">
    <div class="container shadow p-3 mb-5 bg-white rounded">
      <div class="row mb-3 justify-content-center">
        <img @click="toHome" src="../../assets/images/logo_long.png" alt="acoustic"
          class="w-50 img-responsive center-block">
      </div>
      <div class="switch row text-center justify-content-center">
        <h2 @click="toSignIn" :class="['sign-in',this.componentId=='SignIn'?'text-dark':'text-muted']">登录</h2>
        <h2>/</h2>
        <h2 @click="toSignUp" :class="['sign-up',this.componentId=='SignUp'?'text-dark':'text-muted']">注册</h2>
      </div>
      <transition mode="out-in" enter-active-class="animate__animated animate__bounceIn">
        <component :is="componentId"></component>
      </transition>
    </div>
  </div>
</template>

<script>
  import SignIn from './components/SignIn.vue';
  import SignUp from './components/SignUp.vue';

  export default {
    name: 'Login',
    components: {
      SignIn,
      SignUp
    },
    data() {
      return {
        componentId: 'SignIn'
      }
    },
    methods: {
      toSignIn() {
        this.componentId = 'SignIn';
      },

      toSignUp() {
        this.componentId = 'SignUp';
      },

      toHome() {
        this.$router.push('/');
      }
    },
  }
</script>

<style lang="less" scoped>
  #login {
    .row {
      img {
        cursor: pointer;
      }
    }

    .switch {

      .sign-in,
      .sign-up {
        cursor: pointer;
      }
    }
  }
</style>