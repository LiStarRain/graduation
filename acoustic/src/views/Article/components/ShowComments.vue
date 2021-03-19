<template>
  <div id="show-comments">
    <!-- 文章没有评论的时候 -->
    <div v-if="!Boolean(comments.length)" class="no-comments">
      <h4>该文章暂时还没有评论，留下你的脚印吧！</h4>
    </div>

    <!-- 文章有评论时候 -->
    <div v-else class="comments">
      <div class="comment" v-for="(comment,index) of comments" :key="index">
        <div class="title">
          <div class="head_img">
            <img :src="comment.user.head_img" alt="">
          </div>
          <div class="comment-info">
            <p class="userrname">{{ comment.user.username }}</p>
            <p class="publish_time">
              <i class="fa fa-clock-o" aria-hidden="true"></i>
              <span>{{ comment.content.publish_time }}</span>
            </p>
          </div>
        </div>
        <div class="content">
          <article v-html="comment.content.text"></article>
        </div>

        <!-- 显示回复评论 -->
        <replys :flag="index" :commentId="comment.comment_id"></replys>

        <!-- 回复评论 -->
        <div v-if="index === replyFlag" class="reply-input">
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text" id="basic-addon1">@{{replyUsername}}</span>
            </div>
            <input v-model="replyContent" type="text" class="form-control" placeholder="请输入回复内容" aria-label="Username"
              aria-describedby="basic-addon1">
          </div>
          <button @click="postReply(comment.comment_id)">发送</button>
        </div>
        <div @click="reply(index,comment.user.username)" class="reply">
          <i class="fa fa-reply" aria-hidden="true"></i>
          <span>回复</span>
        </div>
      </div>
    </div>

    <!-- 回复成功/失败 -->
    <transition mode="out-in" enter-active-class="animate__animated animate__bounceIn">
      <component :is="componentId"></component>
    </transition>
  </div>
</template>

<script>
  import Comments from '../../../assets/js/Comments/Comments.js';
  import Replys from './Replys.vue';
  import PublishSuccess from '../../publish/components/PublishSuccess.vue';
  import PublishFailed from '../../publish/components/PublishFailed.vue';

  export default {
    name: 'ShowComments',
    components: {
      Replys,
      PublishSuccess,
      PublishFailed
    },
    data() {
      return {
        comments: [],
        replyFlag: -1,
        replyUsername: '',
        // 回复的内容
        replyContent: '',
        componentId: null
      }
    },
    methods: {
      reply(index, username) {
        this.replyFlag = index;
        this.replyUsername = username;
      },
      postReply(commentId) {
        Comments.postReply(this.replyUsername, this.replyContent, commentId).then(res => {
          if (res.status === 200 && res.data == 1) {
            this.componentId = 'PublishSuccess';
            setTimeout(() => {
              this.componentId = null;
              this.$router.go(0);
            }, 1500);
          } else {
            this.componentId = 'PublishFailed';
            setTimeout(() => {
              this.componentId = null;
            }, 1500);
          }
        }).catch(e => {
          console.log(e.message);
        });
      },
      onReply(from, flag) {
        this.replyFlag = flag;
        this.replyUsername = from;
      }
    },
    created() {
      // 获取文章的评论
      Comments.getComments(this.$route.query.articleId).then(res => {
        if (res.status === 200) {
          this.comments = res.data;
        }
      }).catch(e => {
        console.log(e.message);
      });
    },
    mounted() {
      this.bus.$on('replyContent', this.onReply);
    },
  }
</script>

<style lang="less" scoped>
  @titleColor: #211f1d;
  @bgColor: #fff;

  #show-comments {
    margin-top: 2rem;
    width: 100%;
    box-sizing: border-box;

    @media screen and (max-width: 512px) {
      width: 100%;
    }

    .no-comments {
      h4 {
        padding: .5rem;
        text-align: center;
        margin: 0;
      }
    }

    .comments {
      .comment {
        background-color: @bgColor;
        border-radius: .2rem;
        box-shadow: 0 0 3px 1px #ccc;
        padding: .5rem;
        margin-bottom: 1rem;

        .title {
          padding: .5rem;
          display: flex;
          align-items: flex-start;
          border-bottom: 2px solid #ccc;

          .head_img {
            margin-right: 1rem;

            img {
              width: 3rem;
              height: 3rem;
              border-radius: .2rem;
            }
          }

          .comment-info {
            display: flex;
            flex-direction: column;
            justify-content: space-around;

            .publish_time {
              .fa {
                margin-right: .3rem;
              }
            }

            p {
              margin: 0;
            }
          }
        }

        .content {
          margin-top: 1rem;
          padding: .5rem;
          border-bottom: 2px solid #ccc;
        }

        .reply {
          padding: .5rem;
          color: #7f8c8d;
          cursor: pointer;
          width: max-content;

          .fa {
            margin-right: .2rem;
            color: #7f8c8d;
          }

          &:hover,
          &:hover .fa {
            color: @titleColor;
          }
        }

        .reply-input {
          padding: .5rem;

          button {
            margin-top: .5rem;
            padding: .3rem .5rem;
            background-color: #0879fb;
            border-radius: .2rem;
            opacity: .8;
            border: none;
            outline: none;
            color: @bgColor;

            &:hover {
              opacity: 1;
            }
          }
        }
      }
    }
  }
</style>