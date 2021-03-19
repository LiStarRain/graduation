<template>
  <div id="video">
    <div class="show">
      <div class="head">
        <h1 class="title">视频观赏</h1>
        <upload-button></upload-button>
      </div>
      <!-- 分类按钮 -->
      <categories @filterVideos="filterVideos" :categories="categories"></categories>
      <!-- 视频展示 -->
      <show-videos @playVideo="playVideo" :showPosters="showVideos"></show-videos>
      <!-- 返回顶部 -->
      <to-top></to-top>
      <!-- 视频播放 -->
      <transition mode="out-in" enter-active-class="animate__animated animate__bounceIn">
        <component :video="video" @closePlayer="closePlayer" :is="componentId"></component>
      </transition>
      <!-- 加载更多 -->
      <show-more @loadMoreVideos="loadMoreVideos">
        <img v-if="loadingStatus" src="../../assets/images/loading.gif" alt="">
        <span v-else>加载更多视频</span>
      </show-more>
    </div>
  </div>
</template>

<script>
  import Video from '../../assets/js/Video/Video.js';
  import Categories from './components/Categories.vue';
  import UploadButton from './components/UploadButton.vue';
  import ShowVideos from './components/ShowVideos.vue';
  import ToTop from '../../commonComponents/ToTop.vue';
  import ShowMore from './components/ShowMore.vue';
  import Player from './components/Player.vue';

  export default {
    name: 'Video',
    components: {
      Categories,
      UploadButton,
      ShowVideos,
      ToTop,
      ShowMore,
      Player
    },
    data() {
      return {
        // 分类数据
        categories: [],
        // 视频封面
        showVideos: [],
        // 缓存数据
        videos: [],
        // 记录获取数据的条数
        count: 0,
        // 图片加载状态
        loadingStatus: false,
        // 当前tag
        tag: 'all',
        // 播放器
        componentId: '',
        video: '',
      }
    },
    methods: {
      loadMoreVideos() {
        this.loadingStatus = true;
        // 注意是加载同类型的更多视频
        Video.getVideos(this.tag, this.count).then(res => {
          if (res.status === 200 && res.data.length) {
            this.showVideos = this.showVideos.concat(res.data);
            this.videos = this.videos.concat(res.data);
            this.count += res.data.length;
          }
        }).catch(error => {
          console.log(error.message);
        }).finally(() => {
          this.loadingStatus = false;
        });
      },

      filterVideos(tag) {
        this.tag = tag;
        this.showVideos = this.videos.filter(video => video.tag.includes(tag));
      },

      playVideo(video) {
        this.video = video;
        this.componentId = 'Player';
      },

      // 关闭播放器
      closePlayer() {
        this.componentId = '';
      }
    },
    created() {
      // 获取分类数据
      Video.getCategories().then(res => {
        if (res.status === 200) {
          this.categories = res.data;
        }
      }).catch(e => {
        console.log(e.message);
      });

      // 获取视频封面图片
      Video.getVideos().then(res => {
        if (res.status === 200) {
          this.videos = this.showVideos = res.data;
          this.count = res.data.length;
        }
      }).catch(e => {
        console.log(e.message);
      });
    },
  }
</script>

<style lang="less" scoped>
  @titleColor: #211f1d;

  #video {
    width: 100%;
    padding: 1rem;

    .show {
      .head {
        position: relative;

        .title {
          text-align: center;
        }
      }
    }
  }
</style>