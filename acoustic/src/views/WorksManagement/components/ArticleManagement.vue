<template>
  <div id="article-management">
    <h3>文章管理</h3>
    <div v-if="!Boolean(articles.length)" class="no-articles">
      <h2>您暂时还没有上传任何文章哦！</h2>
    </div>
    <div v-else class="show-articles">
      <div class="article" v-for="(article,index) of articles" :key="index">
        <div class="title">
          <span @click="toArticle(article.id)" class="article-title">{{ article.title }}</span>
          <span class="publish-time">{{ article.publish_time }}</span>
        </div>
        <div class="delete">
          <span @click="deleteUserArticle(article.id, index)">删除</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import Bbs from '../../../assets/js/Bbs/Bbs.js';
  import {
    mapActions
  } from 'vuex';

  export default {
    name: 'ArticleManagement',
    data() {
      return {
        articles: []
      }
    },

    methods: {
      ...mapActions(['getUserComments', 'getUserMessages']),
      deleteUserArticle(article_id, index) {
        Bbs.deleteUserArticle(article_id).then(res => {
          if (res.status === 200 && res.data) {
            this.articles.splice(index, 1);
            // 更新localstorage中的消息状态
            this.getUserComments();
            this.getUserMessages();
          }
        }).catch(e => {
          console.log(e.message);
        });
      },

      toArticle(id) {
        this.$router.push({
          path: '/article',
          query: {
            articleId: id
          }
        });
      }
    },

    created() {
      Bbs.getUserArticles().then(res => {
        if (res.status === 200 && res.data.length > 0) {
          this.articles = res.data;
        }
      }).catch(e => {
        console.log(e.message);
      });
    },
  }
</script>

<style lang="less" scoped>
  @titleColor: #211f1d;

  #article-management {
    width: 100%;
    box-sizing: border-box;
    margin-top: 2rem;

    h3 {
      border-bottom: 2px solid #ccc;
    }

    .no-articles {
      padding: 1rem;
      display: flex;
      justify-content: center;
      border-bottom: 2px solid #ccc;
    }

    .show-articles {
      padding: .5rem;

      .article {
        padding: .5rem 0;
        border-bottom: 2px solid #ccc;

        .title {
          display: flex;
          justify-content: space-between;

          .article-title {
            font-size: 1.5rem;
            cursor: pointer;
            color: @titleColor;
            opacity: .8;

            &:hover {
              opacity: 1;
            }
          }

          .publish-time {
            align-self: flex-end;
          }
        }

        .delete {
          margin-top: .5rem;
          display: flex;
          justify-content: flex-end;


          span {
            color: #bdc3c7;
            cursor: pointer;

            &:hover {
              color: @titleColor;
            }
          }
        }
      }
    }
  }
</style>