<template>
  <div id="upload-button">
    <button @click="toUpload" class="upload">
      <i class="fa fa-upload" aria-hidden="true"></i>
    </button>
  </div>
</template>

<script>
  import {
    mapState
  } from 'vuex';

  export default {
    name: 'UploadButton',
    methods: {
      toUpload() {
        if (this.loginStatus) {
          // 若用户登录了则直接跳转上传图片页面
          this.$router.push('/uploadVideo');
        } else {
          // 若用户未登录则直接跳转登录注册页面
          this.$router.push('/login');
        }
      }
    },
    computed: {
      ...mapState(["loginStatus"])
    }
  }
</script>

<style lang="less" scoped>
  @bgColor: #fc8f00;
  @fontColor: #f0f0f0;

  #upload-button {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    right: 2%;
    border-radius: 50%;
    box-shadow: 0 0 5px 1px #9a7651;

    .upload {
      border: none;
      outline: none;
      background-color: @bgColor;
      color: @fontColor;
      padding: .3rem;
      box-sizing: border-box;
      border-radius: 50%;
      width: 2rem;
      height: 2rem;
      transition: transform .3s;


      &:hover {
        transform: scale(1.5);
      }
    }
  }
</style>