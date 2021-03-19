<template>
  <div id="works-management">
    <div class="container p-3 mb-5 bg-white rounded">
      <div class="row mb-3 justify-content-center">
        <img @click="toHome" src="../../assets/images/logo_long.png" alt="acoustic"
          class="w-50 img-responsive center-block">
      </div>
      <div class="content">
        <h2>作品管理</h2>

        <!-- 用户所上传的图片管理 -->
        <images-management></images-management>

        <!-- 用户上传的视频管理 -->
        <videos-management></videos-management>

        <!-- 用户发表的文章管理 -->
        <article-management></article-management>

        <!-- 返回顶部 -->
        <to-top></to-top>
      </div>
    </div>
  </div>
</template>

<script>
  import ToTop from '../../commonComponents/ToTop.vue';
  import ArticleManagement from './components/ArticleManagement.vue';
  import ImagesManagement from './components/ImagesManagement.vue';
  import VideosManagement from './components/VideosManagement.vue';
  export default {
    components: {
      ImagesManagement,
      ToTop,
      VideosManagement,
      ArticleManagement
    },
    name: 'WorksManagement',
    methods: {
      toHome() {
        this.$router.push('/');
      }
    },
  }
</script>

<style lang="less" scoped>
  #works-management {
    width: 100%;
    box-sizing: border-box;
    overflow: hidden;

    .container {
      img {
        cursor: pointer;
      }

      .content {
        h2 {
          text-align: center;
        }
      }
    }
  }
</style>