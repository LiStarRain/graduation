<template>
  <div id="publish">
    <div class="publish-container">
      <div class="title">
        <h4>发表帖子</h4>
      </div>
      <div class="input-title">
        <b-form-input :state="Boolean(data.title)" v-model="data.title" placeholder="请输入帖子标题" type="text"
          name="article_title">
        </b-form-input>
      </div>
      <editor @publish="publish"></editor>
      <!-- 上传成功/失败 -->
      <transition mode="out-in" enter-active-class="animate__animated animate__bounceIn">
        <component :is="componentId"></component>
      </transition>
    </div>
  </div>
</template>

<script>
  import Editor from './components/Editor.vue'
  import Bbs from '../../assets/js/Bbs/Bbs.js';
  import PublishSuccess from './components/PublishSuccess.vue';
  import PublishFailed from './components/PublishFailed.vue';
  export default {
    name: 'Publish',
    components: {
      Editor,
      PublishSuccess,
      PublishFailed
    },
    data() {
      return {
        data: {
          title: '',
          content: ''
        },
        componentId: null
      }
    },
    methods: {
      clearSuccessTimer() {
        clearTimeout(this.timer);
      },

      publish(editorData) {
        if (!this.data.title) {
          return;
        }
        this.data.content = editorData;
        Bbs.publish(this.data).then(res => {
          if (res.status === 200 && res.data === 1) {
            this.componentId = 'PublishSuccess';
            setTimeout(() => {
              this.componentId = null;
              this.$router.push('/bbs');
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
      }
    },
  }
</script>

<style lang="less" scoped>
  #publish {
    width: 100%;
    display: flex;
    justify-content: center;
    box-sizing: border-box;
    padding: 1rem;

    .publish-container {
      width: 90%;
      box-sizing: border-box;
      background-color: #fff;
      border-radius: .2rem;
      box-shadow: 0 0 3px 1px #ccc;
      padding: .5rem;
      box-sizing: border-box;

      .title {
        padding: .5rem;
        border-bottom: 2px solid #ccc;

        h4 {
          margin: 0;
        }
      }

      .input-title {
        margin-top: .5rem;
        padding: .5rem;
      }
    }
  }
</style>