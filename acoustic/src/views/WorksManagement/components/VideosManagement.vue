<template>
  <div id="videos-management">
    <h3>视频管理</h3>
    <div v-if="!Boolean(videos.length)" class="no-videos">
      <h2>您暂时还没有上传任何视频哦！</h2>
    </div>
    <div v-else class="show-videos">
      <div class="videos">
        <div :title="video.desc" class="video-wrapper" v-for="(video,index) of videos" :key="index">
          <i @click="deleteVideo(video.id, index)" title="删除" class="fa fa-times" aria-hidden="true"></i>
          <img :src="video.poster" alt="">
          <div @click="playVideo(video)" class="mask"></div>
        </div>
      </div>
    </div>

    <!-- 播放器 -->
    <transition mode="out-in" enter-active-class="animate__animated animate__bounceIn">
      <component :video="videoInfo" @closePlayer="closePlayer" :is="componentId"></component>
    </transition>
  </div>
</template>

<script>
  import Video from '../../../assets/js/Video/Video.js';
  import Player from '../../video/components/Player.vue';

  export default {
    name: 'VideosManagement',
    components: {
      Player
    },
    data() {
      return {
        videos: [],
        componentId: null,
        videoInfo: {}
      }
    },
    methods: {
      closePlayer() {
        this.componentId = null;
      },
      playVideo(video) {
        this.videoInfo = video;
        this.componentId = 'Player';
      },
      deleteVideo(video_id, index) {
        Video.deleteUserVideo(video_id).then(res => {
          if (res.status === 200 && res.data == 1) {
            this.videos.splice(index, 1);
          }
        }).catch(e => {
          console.log(message);
        });
      }
    },
    created() {
      Video.getUserVideos().then(res => {
        if (res.status === 200 && res.data.length > 0) {
          this.videos = res.data;
        }
      }).catch(e => {
        console.log(e.message);
      });
    },
  }
</script>

<style lang="less" scoped>
  #videos-management {
    margin-top: 2rem;
    width: 100%;
    box-sizing: border-box;

    h3 {
      border-bottom: 2px solid #ccc;
    }

    .no-videos {
      padding: 1rem;
      display: flex;
      justify-content: center;
      border-bottom: 2px solid #ccc;
    }

    .show-videos {
      padding: .5rem;
      display: flex;
      justify-content: center;
      border-bottom: 2px solid #ccc;

      .videos {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        overflow: hidden;

        .video-wrapper {
          height: 10rem;
          width: 10rem;
          position: relative;
          cursor: pointer;

          .fa {
            position: absolute;
            right: 1%;
            top: 1%;
            font-size: 2em;
            color: #e67e22;
            cursor: pointer;
            z-index: 22;
          }

          img {
            width: 100%;
            height: 100%;
          }

          .mask {
            width: 100%;
            height: 100%;
            background-color: #2c3e50;
            opacity: .5;
            z-index: 21;
            position: absolute;
            top: 0;
            left: 0;
          }
        }
      }
    }
  }
</style>