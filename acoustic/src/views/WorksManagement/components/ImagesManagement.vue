<template>
  <div id="images-management">
    <h3>图片管理</h3>
    <div class="content">
      <div v-if="!Boolean(images.length)" class="no-images">
        <h2>您暂时还没有上传任何图片哦！</h2>
      </div>
      <div v-else class="show-images">
        <div class="images">
          <div :title="image.desc" class="image-wrapper" v-for="(image,index) of images" :key="index">
            <i @click="deleteImage(image.id,index)" title="删除" class="fa fa-times" aria-hidden="true"></i>
            <img :src="image.img" alt="">
            <div class="mask"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import Glance from '../../../assets/js/Glance/Glance.js';

  export default {
    name: 'ImagesManagement',
    data() {
      return {
        images: []
      }
    },
    methods: {
      deleteImage(image_id, index) {
        Glance.deleteImage(image_id).then(res => {
          if (res.status === 200 && res.data == 1) {
            this.images.splice(index, 1);
          }
        }).catch(e => {
          console.log(e.message);
        });
      }
    },
    created() {
      Glance.getUserImages().then(res => {
        if (res.status === 200 && res.data.length > 0) {
          this.images = res.data;
        }
      }).catch(e => {
        console.log(e.message);
      });
    },
  }
</script>

<style lang="less" scoped>
  #images-management {
    width: 100%;
    box-sizing: border-box;

    h3 {
      border-bottom: 2px solid #ccc;
    }

    .no-images {
      padding: 1rem;
      display: flex;
      justify-content: center;
      border-bottom: 2px solid #ccc;
    }

    .show-images {
      padding: .5rem;
      display: flex;
      justify-content: center;
      border-bottom: 2px solid #ccc;

      .images {
        display: flex;
        flex-wrap: wrap;
        overflow: hidden;
        justify-content: center;

        .image-wrapper {
          height: 10rem;
          width: 10rem;
          position: relative;

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