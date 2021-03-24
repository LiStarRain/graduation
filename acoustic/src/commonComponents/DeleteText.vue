<template>
  <div id="delete-text">
    <i @click.stop="deleteText" class="fa fa-times"></i>
  </div>
</template>

<script>
  import Bbs from '../assets/js/Bbs/Bbs.js';
  import Comments from '../assets/js/Comments/Comments.js';
  export default {
    name: 'DeleteText',
    props: ['info'],
    data() {
      return {
        authority: 0
      }
    },
    methods: {
      deleteText() {
        switch (this.info.type) {
          case 'article':
            Bbs.deleteUserArticle(this.info.id).then(res => {
              if (res.status == 200 && res.data == 1) {
                this.$router.go(0);
              }
            }).catch(e => {
              console.log(e.message);
            });
            break;

          case 'comment':
            Comments.deleteUserComment(this.info.id).then(res => {
              if (res.status == 200 && res.data == 1) {
                this.$router.go(0);
              }
            }).catch(e => {
              console.log(e.message);
            });
            break;

          case 'reply':
            Comments.deleteUserReply(this.info.id).then(res => {
              if (res.status == 200 && res.data == 1) {
                this.$router.go(0);
              }
            }).catch(e => {
              console.log(e.message);
            });
            break;
        }
      }
    },
  }
</script>

<style lang="less" scoped>
  #delete-text {
    box-sizing: border-box;
    position: absolute;
    top: 0%;
    left: 0%;
    transform: translateY(-50%);
    z-index: 100;

    .fa {
      font-size: 1.2rem;
      color: #e74c3c;
      cursor: pointer;
      opacity: .8;

      &:hover {
        opacity: 1;
      }
    }
  }
</style>