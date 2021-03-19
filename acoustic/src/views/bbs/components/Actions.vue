<template>
  <div id="actions-container">
    <div class="actions">
      <div class="action" v-for="(article,key) of articleList" :key="key">
        <div class="head_img">
          <img :src="article.head_img" alt="">
        </div>
        <div class="content">
          <p @click="toArticle(article.id)" class="action-content">
            {{ article.title }}
          </p>
          <p class="author">
            <span class="top" v-show="article.top == 1">置顶</span>
            <span class="username">{{ article.username }}</span>
            <span class="time"> • 发表于{{ article.publish_time }}</span>
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'Actions',
    props: ['articleList'],
    methods: {
      toArticle(article_id) {
        this.$router.push({
          path: '/article',
          query: {
            articleId: article_id
          }
        });
      }
    },
  }
</script>

<style lang="less" scoped>
  p {
    margin: 0;
  }

  #actions-container {
    padding: .5rem .3rem;
    box-sizing: border-box;

    .actions {
      padding: rem 0;

      .action {
        padding: 1rem .2rem;
        border-bottom: 2px solid #ccc;
        display: grid;
        grid-template-columns: 1fr 11fr;
        justify-content: space-between;

        .head_img {
          width: 4rem;
          height: 4rem;
          border-radius: .3rem;
          box-shadow: 0 0 3px 1px #ccc;
          margin-right: 1rem;

          img {
            width: 100%;
            height: 100%;
          }
        }

        .content {
          width: 100%;
          overflow: hidden;
          display: flex;
          justify-content: space-between;
          flex-direction: column;

          .action-content {
            width: 100%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-size: 1.2rem;
            cursor: pointer;

            &:hover {
              opacity: .8;
            }
          }

          .author {
            .top {
              background-color: #e74c3c;
              color: #fff;
              padding: .2rem;
              border-radius: .3rem;
              margin-right: .3rem;
            }
          }
        }
      }
    }
  }
</style>