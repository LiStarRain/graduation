<template>
  <div id="comment">
    <div class="title">
      <h5>发表评论</h5>
    </div>
    <div id="comment-editor"></div>
    <div class="save-button">
      <button type="button" @click="publishComment">提交</button>
    </div>
  </div>
</template>

<script>
  import wangEditor from 'wangeditor';
  import Comments from '../../../assets/js/Comments/Comments.js';
  import {
    mapState
  } from 'vuex';

  export default {
    name: 'Comment',
    data() {
      return {
        editor: null,
        editorData: '',
        // 防抖
        timer: null
      }
    },
    computed: {
      ...mapState(['loginStatus'])
    },
    mounted() {
      const editor = new wangEditor('#comment-editor');
      // 配置onchange回调函数，将数据同步到vue中
      editor.config.onchange = (newHtml) => {
        this.editorData = newHtml;
      };
      // 创建编辑器
      editor.create();
      this.editor = editor;
    },
    methods: {
      publishComment() {
        // 未登录则跳转至登录页面
        if (!this.loginStatus) {
          this.$router.push('/login');
          return;
        }
        clearTimeout(this.timer);
        this.timer = setTimeout(() => {
          Comments.publishComment(this.editorData, this.$route.query['articleId']).then(res => {
            if (res.status === 200 && res.data) {
              this.$emit('publishSuccess');
            } else {
              this.$emit('publishFailed');
            }
          }).catch(e => {
            console.log(e.message);
          });
        }, 1000);
      }
    },
  }
</script>

<style lang="less" scoped>
  @bgColor: #fff;

  #comment {
    margin-top: 2rem;
    width: 100%;
    background-color: @bgColor;
    border-radius: .2rem;
    box-shadow: 0 0 3px 1px #ccc;
    padding: .5rem;
    box-sizing: border-box;

    @media screen and (max-width: 512px) {
      width: 100%;
    }

    .title {
      padding: .5rem;
      border-bottom: 2px solid #ccc;

      h5 {
        margin: 0;
      }
    }

    #comment-editor {
      margin-top: .5rem;
    }

    .save-button {
      margin-top: .5rem;

      button {
        border: 0;
        outline: 0;
        padding: .3rem 1rem;
        background-color: #0879fb;
        color: @bgColor;
        border-radius: .3rem;
        opacity: .8;

        &:hover {
          opacity: 1;
        }
      }
    }
  }
</style>