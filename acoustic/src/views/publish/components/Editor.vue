<template>
  <div id="editor">
    <div id="my-editor"></div>
    <div class="submit">
      <button @click="publish" type="button">保存提交</button>
    </div>
  </div>
</template>

<script>
  import wangEditor from 'wangeditor';

  export default {
    name: 'Editor',
    data() {
      return {
        editor: null,
        editorData: '',
        // 节流
        timer: null
      }
    },
    methods: {
      publish() {
        clearTimeout(this.timer);
        setTimeout(() => {
          this.$emit('publish', this.editorData);
        }, 1000);
      }
    },
    mounted() {
      const editor = new wangEditor('#my-editor');
      // 配置onchange回调函数，将数据同步到vue中
      editor.config.onchange = (newHtml) => {
        this.editorData = newHtml;
      };
      // 创建编辑器
      editor.create();
      this.editor = editor;
    },
  }
</script>

<style lang="less" scoped>
  #editor {
    padding: .5rem;

    .submit {
      margin-top: 1rem;

      button {
        border: none;
        outline: none;
        padding: .5rem 1rem;
        color: #fff;
        background-color: #0879fb;
        border-radius: .3rem;
        opacity: .8;

        &:hover {
          opacity: 1;
        }
      }
    }
  }
</style>