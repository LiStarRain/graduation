<template>
  <div id="glance">
    <div class="show">
      <div class="head">
        <h1 class="title">一览风采</h1>
        <upload-button></upload-button>
      </div>
      <!-- 分类按钮 -->
      <category-buttons @filterImages="filterImages" :categories="categories"></category-buttons>
      <!-- 图片展示 -->
      <show-images :showImages="showImages"></show-images>
      <!-- 回到顶部按钮 -->
      <to-top></to-top>
      <!-- 加载更多图片 -->
      <show-more @loadMoreImages="loadMoreImages">
        <img v-if="loadingStatus" src="../../assets/images/loading.gif" alt="">
        <span v-else>加载更多图片</span>
      </show-more>
    </div>
  </div>
</template>

<script>
  import ToTop from '../../commonComponents/ToTop.vue';
  import CategoryButtons from './components/CategoryButtons.vue';
  import ShowImages from './components/ShowImages.vue';
  import UploadButton from './components/UploadButton.vue';
  import Glance from '../../assets/js/Glance/Glance.js';
  import ShowMore from './components/ShowMore.vue';

  export default {
    name: 'Glance',
    components: {
      CategoryButtons,
      ShowImages,
      ToTop,
      UploadButton,
      ShowMore,
    },
    data() {
      return {
        // 分类标签
        categories: null,
        // 展示的图片资源
        showImages: [],
        // 图片资源缓存
        images: [],
        // 图片类别
        tag: 'all',
        // 获取过的图片数量
        count: 0,
        // 图片加载状态
        loadingStatus: false
      }
    },
    methods: {
      filterImages(tag) {
        // 图片过滤
        this.tag = tag;
        this.showImages = this.images.filter(image => image.tag.includes(tag));
      },
      loadMoreImages() {
        this.loadingStatus = true;
        // 注意是加载同类型的更多图片
        Glance.getImages(this.tag, this.count).then(res => {
          if (res.status === 200 && res.data.length) {
            this.showImages = this.showImages.concat(res.data);
            this.images = this.images.concat(res.data);
            this.count += res.data.length;
          }
        }).catch(error => {
          console.log(error.message);
        }).finally(() => {
          this.loadingStatus = false;
        });
      }
    },
    created() {
      // 获取分类按钮数据
      Glance.getCategories().then(res => {
        if (res.status === 200) {
          this.categories = res.data;
        }
      }).catch(error => {
        console.log(error.message);
      });
      // 获取图片资源
      Glance.getImages().then(res => {
        if (res.status === 200) {
          this.images = this.showImages = res.data;
          this.count += res.data.length;
        }
      }).catch(error => {
        console.log(error.message);
      });
    }
  }
</script>

<style lang="less" scoped>
  @titleColor: #211f1d;

  #glance {
    width: 100%;
    padding: 1rem;

    .show {
      display: flex;
      flex-direction: column;

      .head {
        position: relative;

        .title {
          text-align: center;
          color: @titleColor;
        }
      }
    }
  }
</style>