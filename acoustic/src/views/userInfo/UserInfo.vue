<template>
  <div id="user-info">
    <div class="container shadow p-3 mb-5 bg-white rounded">
      <div class="row mb-3 justify-content-center">
        <img @click="toHome" src="../../assets/images/logo_long.png" alt="acoustic"
          class="w-50 img-responsive center-block logo">
      </div>
      <h2 class="text-center">用户资料</h2>
      <!-- 用户资料，用动态组件来在读取数据之后加载组建 -->
      <component :userInfo="userInfo" @editSuccess="editSuccess" :is="componentId"></component>
      <!-- 模态框 -->
      <edit-success @clearTimer="clearTimer"></edit-success>
    </div>
  </div>
</template>

<script>
  import EditSuccess from './components/EditSuccess.vue';
  import Profile from './components/Profile.vue';

  export default {
    components: {
      Profile,
      EditSuccess
    },
    name: 'UserInfo',
    data() {
      return {
        // 模态框跳转计时器
        timer: null,
        userInfo: null,
        componentId: ''
      }
    },
    methods: {
      toHome() {
        this.$router.push('/');
      },
      clearTimer() {
        clearTimeout(this.timer);
      },
      editSuccess() {
        this.$bvModal.show('bv-modal-edit-success');
        this.timer = setTimeout(() => {
          this.$router.replace('/');
        }, 3000);
      }
    },
    created() {
      this.$User.getUserInfo().then(res => {
        if (res.status === 200) {
          this.userInfo = res.data;
          this.componentId = 'Profile';
        }
      }).catch(e => {
        console.log(e.message);
      });
    },
  }
</script>

<style lang="less" scoped>
  #user-info {
    .container {
      .logo {
        cursor: pointer;
      }
    }
  }
</style>