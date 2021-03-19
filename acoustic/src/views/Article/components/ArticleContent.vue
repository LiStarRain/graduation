<template>
  <div id="article-content">
    <!-- 文章的内容 -->
    <div class="content">
      <div class="title">
        <h2>{{ articleInfo.title }}</h2>
        <div class="info">
          <div class="author">
            <img :src="articleInfo.head_img" alt="">
            <span class="name">{{ articleInfo.username }}</span>
          </div>
          <div class="publish_time">
            <span>更新于</span>
            <span>{{ articleInfo.publish_time }}</span>
          </div>
        </div>
      </div>
      <main-content :content="articleInfo.content"></main-content>
    </div>
    <!-- 文章的评论 -->
    <show-comments></show-comments>
    <!-- 发表文章评论 -->
    <comment @publishSuccess="publishSuccess" @publishFailed="publishFailed"></comment>
    <!-- 上传成功/失败 -->
    <transition mode="out-in" enter-active-class="animate__animated animate__bounceIn">
      <component :is="componentId"></component>
    </transition>
  </div>
</template>

<script>
  import Comment from './Comment.vue'
  import MainContent from './MainContent.vue'
  import ShowComments from './ShowComments.vue'
  import PublishSuccess from '../../publish/components/PublishSuccess.vue';
  import PublishFailed from '../../publish/components/PublishFailed.vue';

  export default {
    name: 'ArticleContent',
    props: ['articleInfo'],
    components: {
      MainContent,
      Comment,
      ShowComments,
      PublishSuccess,
      PublishFailed
    },
    data() {
      return {
        componentId: null
      }
    },
    methods: {
      publishSuccess() {
        this.componentId = 'PublishSuccess';
        setTimeout(() => {
          this.componentId = null;
          this.$router.go(0);
        }, 1500);
      },
      publishFailed() {
        this.componentId = 'PublishFailed';
        setTimeout(() => {
          this.componentId = null;
        }, 1500);
      }
    },
  }
</script>

<style lang="less" scoped>
  @bgColor: #fff;

  #article-content {
    width: 73%;
    box-sizing: border-box;

    @media screen and (max-width: 512px) {
      width: 100%;
    }

    .content {
      background-color: @bgColor;
      padding: .5rem;
      border-radius: .2rem;
      box-shadow: 0 0 3px 1px #ccc;

      .title {
        padding: 1rem;
        border-bottom: 2px solid #ccc;

        h2 {
          margin-bottom: 1rem;
        }

        .info {
          display: flex;
          align-items: center;

          .author {
            img {
              width: 2rem;
              height: 2rem;
              border-radius: 50%;
              margin-right: .5rem;
            }

            margin-right: 1rem;
          }
        }
      }
    }
  }
</style>