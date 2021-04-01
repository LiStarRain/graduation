<template>
  <div id="player">
    <div class="mask"></div>
    <div class="video-player">
      <div class="head">
        <div class="author">
          <img class="head_img" :src="video.author.head_img" alt="">
          <span class="name">{{ video.author.name}}</span>
        </div>
        <div class="close">
          <i @click="closePlayer" class="fa fa-times" aria-hidden="true"></i>
        </div>
      </div>
      <video disablePictureInPicture id="myVideo" controls preload="auto">
        <source :src="video.src" type="video/mp4">
      </video>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'Player',
    props: ['video'],
    methods: {
      closePlayer() {
        this.$emit('closePlayer');
      }
    },
  }
</script>

<style lang="less" scoped>
  @bgColor: #616166;
  @fontColor: #fff;

  #player {
    box-sizing: border-box;
    overflow: hidden;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1300;

    .mask {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: @bgColor;
      z-index: 100;
      box-sizing: border-box;
      opacity: .3;
      z-index: 150;
    }

    .video-player {
      position: fixed;
      top: 50%;
      left: 10%;
      width: 80%;
      z-index: 160;
      transform: translateY(-50%);

      .head {
        width: 100%;
        background-color: #000;
        opacity: .8;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: .3rem 1rem;

        .author {
          display: flex;
          align-items: center;

          .head_img {
            width: 2rem;
            height: 2rem;
            border-radius: 50%;
            margin-right: .6rem;
          }

          .name {
            color: @fontColor;
          }
        }

        .close {
          cursor: pointer;

          .fa {
            color: @fontColor;
          }
        }
      }

      video {
        width: 100%;
        height: auto;
      }
    }
  }
</style>