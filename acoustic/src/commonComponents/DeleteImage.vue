<template>
  <div @click.stop="deleteImage" id="delete" v-show="authority == 1">
    <button class="delete-button">
      <i class="fa fa-times"></i>
    </button>
  </div>
</template>

<script>
  import Glance from '../assets/js/Glance/Glance.js';
  import Video from '../assets/js/Video/Video.js';
  export default {
    name: 'DeleteImage',
    props: ['info'],
    data() {
      return {
        authority: 0
      }
    },
    methods: {
      deleteImage() {
        switch (this.info.type) {
          case 'glance':
            Glance.deleteImage(this.info.id).then(res => {
              if (res.status === 200 && res.data == 1) {
                this.$router.go(0);
              }
            }).catch(e => {
              console.log(e.message);
            });
            break;
          case 'video':
            Video.deleteUserVideo(this.info.id).then(res => {
              if (res.status === 200 && res.data == 1) {
                this.$router.go(0);
              }
            }).catch(e => {
              console.log(e.message);
            })
        }
      }
    },
    created() {
      this.$User.getUserInfo().then(res => {
        if (res.status === 200) {
          this.authority = res.data.authority;
        }
      }).catch(e => {
        console.log(e.message);
      });
    },
  }
</script>

<style lang="less" scoped>
  #delete {
    box-sizing: border-box;
    position: absolute;
    top: 0;
    right: 0;
    z-index: 1000;

    .delete-button {
      border: none;
      outline: none;
      padding: .3rem .5rem;
      background-color: #e74c3c;
      border-radius: .2rem;
      opacity: .8;
      transition: opacity .3s;

      &:hover {
        opacity: 1;
      }

      .fa {
        color: #fff
      }
    }
  }
</style>