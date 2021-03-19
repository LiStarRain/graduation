<template>
  <div id="message-box">
    <div class="container p-3 mb-5 bg-white rounded">
      <div class="row mb-3 justify-content-center">
        <img @click="toHome" src="../../assets/images/logo_long.png" alt="acoustic"
          class="w-50 img-responsive center-block">
      </div>
      <div class="content">
        <h2>消息盒子</h2>
        <section class="reply">
          <h4>评论回复</h4>
          <div @click="toArticle(message.id)" class="message" v-for="(message,index) of messages" :key="index">
            <div class="user">
              <img :src="message.head_img" alt="">
              <span class="username">{{ message.username }}</span>
              <span> 回复了你:</span>
            </div>
            <div class="content">
              <p>{{ message.content }}</p>
            </div>
          </div>
        </section>

        <section>
          <h4>文章评论</h4>
          <div @click="toArticle(comment.article_id)" class="message" v-for="(comment,index) of comments" :key="index">
            <div class="user">
              <img :src="comment.data.user.head_img" alt="">
              <span class="username">{{ comment.data.user.username }}</span>
              <span> 回复了你:</span>
            </div>
            <div class="content">
              <p v-html="comment.data.content.text"></p>
            </div>
          </div>
        </section>
      </div>
    </div>
    <to-top></to-top>
  </div>
</template>

<script>
  import {
    mapState
  } from 'vuex';
  import ToTop from '../../commonComponents/ToTop.vue';

  export default {
    name: 'MessageBox',
    computed: {
      ...mapState(['messages', 'comments'])
    },
    components: {
      ToTop
    },
    methods: {
      toHome() {
        this.$router.push('/');
      },
      toArticle(articleId) {
        this.$router.push({
          path: '/article',
          query: {
            articleId
          }
        });
      }
    }
  }
</script>

<style lang="less" scoped>
  #message-box {
    box-sizing: border-box;
    width: 100%;

    .container {
      img {
        cursor: pointer;
      }

      .content {
        h2 {
          text-align: center;
        }

        section {
          &.reply {
            margin-bottom: 3rem;
          }

          .message {
            cursor: pointer;
            padding: .5rem;
            margin-bottom: 1rem;
            border: 2px solid #ccc;
            border-radius: .3rem;

            .user {
              display: flex;
              align-items: center;
              margin-bottom: .5rem;

              img {
                width: 2rem;
                height: 2rem;
                border-radius: 50%;
                margin-right: .5rem;
              }

              .username {
                color: #0879fb;
              }
            }

            .content {
              margin-left: 1rem;

              p {
                margin: 0;
                width: 100%;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
              }
            }
          }
        }
      }
    }
  }
</style>