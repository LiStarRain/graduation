<template>
  <div id="show-videos">
    <!-- 第一列 -->
    <div class="images-column">
      <div v-for="(video,index) of columnOneImages" :title="video.desc" class="image-wrapper" :key="index">
        <a @click.prevent="">
          <img class="image-item" :src="video.poster" alt="">
        </a>
        <play-button :video="video" @playVideo="playVideo(video)"></play-button>
      </div>
    </div>
    <!-- 第二列 -->
    <div v-if="columns.length >= 2" class="images-column">
      <div v-for="(video,index) of columnTwoImages" :title="video.desc" class="image-wrapper" :key="index">
        <a @click.prevent="">
          <img class="image-item" :src="video.poster" alt="">
        </a>
        <play-button :video="video" @playVideo="playVideo(video)"></play-button>
      </div>
    </div>
    <!-- 第三列 -->
    <div v-if="columns.length === 3" class="images-column">
      <div v-for="(video,index) of columnThreeImages" :title="video.desc" class="image-wrapper" :key="index">
        <a @click.prevent="">
          <img class="image-item" :src="video.poster" alt="">
        </a>
        <play-button :video="video" @playVideo="playVideo(video)"></play-button>
      </div>
    </div>
  </div>
</template>

<script>
  import PlayButton from './PlayButton.vue';
  export default {
    components: {
      PlayButton
    },
    name: 'ShowVideos',
    props: ['showPosters'],
    data() {
      return {
        // 显示的列数
        columns: [],
        // 计数器

      }
    },
    methods: {
      playVideo(video) {
        this.$emit('playVideo', video);
      }
    },
    computed: {
      n() {
        return Math.ceil(this.showPosters.length / 3) - 3;
      },
      step() {
        return Math.floor(this.showPosters.length / this.columns.length);
      },
      columnOneImages() {
        if (this.showPosters.length < this.columns.length) {
          return this.showPosters.slice(0, 1);
        }

        if (this.columns.length === 1) {
          return this.showPosters;
        }

        if (this.columns.length === 2) {
          if (this.showPosters.length % 2 === 1) {
            return this.showPosters.slice(0, this.step + 1);
          }
        }

        if (this.columns.length === 3) {
          if (this.showPosters.length % 3 === 1 || this.showPosters.length % 3 === 2) {
            return this.showPosters.slice(0, this.step + 1);
          }
        }

        return this.showPosters.slice(0, this.step);
      },
      columnTwoImages() {
        if (this.showPosters.length === 2) {
          return this.showPosters.slice(1, 2);
        }

        if (this.columns.length === 2) {
          if (this.showPosters.length % 2 === 1) {
            return this.showPosters.slice(this.step + 1, this.showPosters.length);
          }
        }

        if (this.columns.length === 3) {
          if (this.showPosters.length % 3 === 1) {
            return this.showPosters.slice(this.step + 1, this.step * 2 + 1)
          }

          if (this.showPosters.length % 3 === 2) {
            return this.showPosters.slice(this.step + 1, this.step * 3 - this.n);
          }
        }

        return this.showPosters.slice(this.step, this.step * 2);
      },
      columnThreeImages() {
        if (this.showPosters.length >= 3) {
          if (this.showPosters.length % 3 === 1) {
            return this.showPosters.slice(this.step * 2 + 1, this.showPosters.length);
          }

          if (this.showPosters.length % 3 === 2) {
            return this.showPosters.slice(this.step * 3 - this.n, this.showPosters.length);
          }

          return this.showPosters.slice(this.step * 2, this.showPosters.length);
        }
        return [];
      }
    },
    created() {
      // 根据设备大小动态设置列数以及数据
      const {
        clientWidth
      } = document.documentElement;
      if (clientWidth > 1200) {
        this.columns = [1, 2, 3];
      } else if (clientWidth > 600) {
        this.columns = [1, 2];
      } else {
        this.columns = [1];
      }
    },
  }
</script>

<style lang="less" scoped>
  @bgColor: #616166;
  @fontColor: #dedfe0;

  #show-videos {
    width: 100%;
    display: flex;
    justify-content: center;
    box-sizing: border-box;
    padding-top: 1rem;

    .images-column {
      margin-right: .5rem;
      flex-grow: 1;
      flex-basis: 30%;

      @media screen and (max-width:1200px) {
        flex-basis: 50%;
      }

      @media screen and (max-width:600px) {
        margin-right: 0;
        flex-basis: 100%;
      }

      &:last-child {
        margin-right: 0;
      }

      .image-wrapper {
        width: 100%;
        position: relative;
        margin-bottom: .5rem;

        &:hover #download-image {
          opacity: .8;
        }

        a {
          display: block;
          width: 100%;

          .image-item {
            width: 100%;
            height: auto;
          }
        }
      }
    }
  }
</style>