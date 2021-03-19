<template>
  <div @click="playVideo" id="play-button">
    <div class="info">
      <div class="video-title">
        <p class="title">{{ video.desc }}</p>
      </div>
      <div class="video-info">
        <div class="author">
          <img :src="video.author.head_img" alt="" class="head_img">
          <span class="name">{{ video.author.name }}</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'PlayButton',
    props: ['video'],
    methods: {
      playVideo() {
        this.$emit('playVideo');
      },
    },
  }
</script>

<style lang="less" scoped>
  @bgColor: #616166;
  @fontColor: #fff;

  #play-button {
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0;
    left: 0;
    overflow: hidden;
    z-index: 10;
    cursor: pointer;
    box-sizing: border-box;

    &:hover {
      .info {
        height: 100%;

        .video-title {
          .title {
            white-space: pre-line;
            text-overflow: unset;
          }
        }

        .video-info {
          display: flex;
        }
      }
    }

    .info {
      width: 100%;
      height: 2rem;
      position: absolute;
      bottom: 0;
      left: 0;
      z-index: 12;
      display: flex;
      flex-direction: column;
      justify-content: center;
      background-color: @bgColor;
      opacity: .8;
      transition: height .3s;

      .video-title {
        .title {
          font-size: 1.5rem;
          color: @fontColor;
          opacity: 1;
          margin: 0;
          white-space: nowrap;
          text-overflow: ellipsis;
          overflow: hidden;
          text-align: center;
        }
      }

      .video-info {
        width: 100%;
        position: absolute;
        bottom: 0;
        left: 0;
        // display: flex;
        display: none;
        justify-content: space-between;
        align-items: center;
        padding: .3rem 1rem;
        background-color: #000;
        opacity: .8;

        .author {
          display: flex;
          align-items: center;

          .head_img {
            width: 2rem;
            height: 2rem;
            border-radius: 50%;
            margin-right: 1rem;
          }

          .name {
            font-size: 1.2rem;
            color: @fontColor;
          }
        }

        .download {
          align-self: flex-end;

          .fa {
            color: @fontColor;
            cursor: pointer;

            &:hover {
              opacity: .8;
            }
          }
        }
      }
    }
  }
</style>