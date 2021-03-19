<template>
  <div id="replys" v-show="Boolean(replys.length)">
    <div class="reply" v-for="(reply,index) of replys" :key="index">
      <div class="user">
        <img :src="reply.head_img" alt="">
        <span class="username">{{ reply.from_username }}</span>
        <span> 回复 </span>
        <span class="username">{{ reply.to_username }}: </span>
      </div>
      <div class="content">
        <p>{{ reply.content }}</p>
      </div>
      <div class="reply-button">
        <div @click="replyContent(reply.from_username,reply.to_username)" class="reply-content">
          <i class="fa fa-reply" aria-hidden="true"></i>
          <span>回复</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import Comments from '../../../assets/js/Comments/Comments';
  export default {
    name: 'Reply',
    props: ['commentId', 'flag'],
    data() {
      return {
        replys: []
      }
    },
    methods: {
      replyContent(from, to) {
        this.bus.$emit('replyContent', from, this.flag);
      }
    },
    created() {
      Comments.getReplys(this.commentId).then(res => {
        if (res.status == 200 && res.data.length) {
          this.replys = res.data;
        }
      }).catch(e => {
        console.log(e.message);
      });
    },
  }
</script>

<style lang="less" scoped>
  @titleColor: #211f1d;

  #replys {
    width: 100%;
    padding: .5rem;
    margin-bottom: .5rem;
    border-bottom: 2px solid #ccc;

    .reply {
      .user {
        img {
          width: 2rem;
          height: 2rem;
          border-radius: .2rem;
          margin-right: .2rem
        }

        .username {
          color: #0879fb;
        }
      }

      .content {
        margin-top: 1rem;

        p {
          margin: 0;
          line-height: 2rem;
        }
      }

      .reply-button {
        display: flex;
        justify-content: flex-end;
        align-items: center;

        .reply-content {
          display: flex;
          justify-content: flex-end;
          align-items: center;
          cursor: pointer;
          color: #7f8c8d;

          .fa {
            margin-right: .5rem;
            color: #7f8c8d;
          }

          &:hover,
          &:hover .fa {
            color: @titleColor;
          }
        }
      }
    }
  }
</style>