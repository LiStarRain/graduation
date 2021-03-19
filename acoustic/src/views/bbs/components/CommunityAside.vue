<template>
  <div id="community-aside">
    <div class="title">
      <h5>社区小帖</h5>
    </div>
    <div class="content">
      <p class="tip">原声音乐社区是一个主张友好、分享、自由的音乐交流社区</p>
    </div>
    <div class="post">
      <button @click="publish" type="button">发帖交流</button>
    </div>
  </div>
</template>

<script>
  import {
    mapState
  } from 'vuex';
  export default {
    name: 'CommunityAside',
    computed: {
      ...mapState(['loginStatus'])
    },
    methods: {
      publish() {
        // 发表帖子
        if (!this.loginStatus) {
          this.$router.push('/login');
          return;
        }
        this.$router.push('/publish');
      }
    },
  }
</script>

<style lang="less" scoped>
  @bgColor: #fff;
  @titleColor: #211f1d;
  @btnColor: #0879fb;

  #community-aside {
    width: 25%;
    background-color: @bgColor;
    border-radius: .2rem;
    box-shadow: 0 0 3px 1px #ccc;
    padding: .5rem;
    box-sizing: border-box;

    @media screen and (max-width: 512px) {
      width: 100%;
      margin-bottom: 2rem;
    }

    .title {
      border-bottom: 2px solid #ccc;
      padding: .5rem .3rem;

      h5 {
        color: @titleColor;
        margin-bottom: 0;
      }
    }

    .content {
      padding: .5rem;
      border-bottom: 2px solid #ccc;

      .tip {
        margin: 0;
        font-size: 1.2rem;
        color: @titleColor;
      }
    }

    .post {
      display: flex;
      justify-content: center;
      padding: .5rem;

      button {
        border: none;
        outline: none;
        padding: .3rem 1rem;
        background-color: @btnColor;
        color: @bgColor;
        border-radius: .3rem;
        box-shadow: 0 0 3px 1px #ccc;
        opacity: .9;

        &:hover {
          opacity: 1;
        }
      }
    }
  }
</style>