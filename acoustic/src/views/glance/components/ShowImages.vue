<template>
  <div id="show-images">
    <!-- 第一列 -->
    <div class="images-column">
      <div :title="image.desc" v-for="(image,index) of columnOneImages" class="image-wrapper" :key="index">
        <a :href="image.img">
          <img class="image-item" :src="image.img" alt="">
        </a>
        <download-image :imageUrl="image.img" :authorInfo="image.author"></download-image>
      </div>
    </div>
    <!-- 第二列 -->
    <div v-if="columns.length >= 2" class="images-column">
      <div :title="image.desc" v-for="(image,index) of columnTwoImages" class="image-wrapper" :key="index">
        <a :href="image.img">
          <img class="image-item" :src="image.img" alt="">
        </a>
        <download-image :imageUrl="image.img" :authorInfo="image.author"></download-image>
      </div>
    </div>
    <!-- 第三列 -->
    <div v-if="columns.length === 3" class="images-column">
      <div :title="image.desc" v-for="(image,index) of columnThreeImages" class="image-wrapper" :key="index">
        <a :href="image.img">
          <img class="image-item" :src="image.img" alt="">
        </a>
        <download-image :imageUrl="image.img" :authorInfo="image.author"></download-image>
      </div>
    </div>
  </div>
</template>

<script>
  import DownloadImage from './DownloadImage';
  export default {
    name: 'ShowImages',
    components: {
      DownloadImage
    },
    props: ['showImages'],
    data() {
      return {
        // 显示的列数
        columns: '',
        // 过滤标签
        filterTag: 'all'
      }
    },
    computed: {
      n() {
        return Math.ceil(this.showImages.length / 3) - this.columns.length;
      },
      step() {
        return Math.floor(this.showImages.length / this.columns.length);
      },
      columnOneImages() {
        if (this.showImages.length < this.columns.length) {
          return this.showImages.slice(0, 1);
        }

        if (this.columns.length === 1) {
          return this.showImages;
        }

        if (this.columns.length === 2) {
          if (this.showImages % 2 === 1) {
            return this.showImages.slice(0, this.step + 1);
          }
        }

        if (this.columns.length === 3) {
          if (this.showImages.length % 3 === 1 || this.showImages.length % 3 === 2) {
            return this.showImages.slice(0, this.step + 1);
          }
        }

        return this.showImages.slice(0, this.step);
      },
      columnTwoImages() {
        if (this.showImages.length === 2) {
          return this.showImages.slice(1, 2);
        }

        if (this.columns.length == 2) {
          if (this.showImages % 2 === 1) {
            return this.showImages.slice(this.step + 1, this.showImages.length);
          }
        }

        if (this.columns.length === 3) {
          if (this.showImages.length % 3 === 1) {
            return this.showImages.slice(this.step + 1, this.step * 2 + 1)
          }

          if (this.showImages.length % 3 === 2) {
            return this.showImages.slice(this.step + 1, this.step * 3 - this.n);
          }
        }

        return this.showImages.slice(this.step, this.step * 2);
      },
      columnThreeImages() {
        if (this.showImages.length >= 3) {
          if (this.showImages.length % 3 === 1) {
            return this.showImages.slice(this.step * 2 + 1, this.showImages.length);
          }

          if (this.showImages.length % 3 === 2) {
            return this.showImages.slice(this.step * 3 - this.n, this.showImages.length);
          }

          return this.showImages.slice(this.step * 2, this.showImages.length);
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

  #show-images {
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