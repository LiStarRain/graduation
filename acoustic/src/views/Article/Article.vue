<template>
  <div id="article">
    <div class="content">
      <!-- 内容 -->
      <article-content :articleInfo="articleInfo"></article-content>
      <!-- 侧边栏 -->
      <community-aside></community-aside>
      <!-- 返回顶部 -->
      <to-top></to-top>
    </div>
  </div>
</template>

<script>
  import Bbs from '../../assets/js/Bbs/Bbs.js';
  import ArticleContent from './components/ArticleContent.vue';
  import CommunityAside from '../bbs/components/CommunityAside.vue';
  import ToTop from '../../commonComponents/ToTop.vue';

  export default {
    name: 'Article',
    components: {
      ArticleContent,
      CommunityAside,
      ToTop
    },
    data() {
      return {
        articleInfo: {}
      }
    },
    created() {
      Bbs.getArticle(this.$route.query.articleId).then(res => {
        if (res.status === 200) {
          this.articleInfo = res.data;
        }
      }).catch(e => {
        console.log(e.message);
      });
    },
  }
</script>

<style lang="less" scoped>
  @bgColor: #fff;

  #article {
    width: 100%;
    display: flex;
    justify-content: center;
    box-sizing: border-box;
    padding: 1rem;

    .content {
      width: 90%;
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      box-sizing: border-box;

      @media screen and (max-width: 512px) {
        flex-direction: column-reverse;
      }
    }
  }
</style>