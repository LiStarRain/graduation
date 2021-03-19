<template>
  <div id="upload-image">
    <div class="container shadow p-3 mb-5 bg-white rounded">
      <div class="title row mb-3 justify-content-center">
        <img @click="toHome" src="../../assets/images/logo_long.png" alt="acoustic"
          class="w-50 img-responsive center-block">
      </div>
      <div class="text-center">
        <h1>图片上传</h1>
      </div>
      <!-- 图片上传表单 -->
      <upload-form @uploading="uploading" @uploadSuccess="uploadSuccess" @uploadFailed="uploadFailed"></upload-form>
      <!-- 上传成功 -->
      <upload-success @clearSuccessTimer="clearSuccessTimer"></upload-success>
      <!-- 上传失败 -->
      <upload-failed></upload-failed>
      <!-- 正在上传 -->
      <uploading v-show="uploadStatus"></uploading>
    </div>
  </div>
</template>

<script>
  import UploadFailed from './components/UploadFailed.vue';
  import UploadForm from './components/UploadForm.vue';
  import Uploading from './components/Uploading.vue';
  import UploadSuccess from './components/UploadSuccess';
  export default {
    name: 'UploadImage',
    components: {
      UploadForm,
      UploadSuccess,
      UploadFailed,
      Uploading
    },
    data() {
      return {
        // 上传成功的定时器
        timer: null,
        // 上传状态
        uploadStatus: false
      }
    },
    methods: {
      toHome() {
        this.$router.push('/');
      },
      uploading() {
        this.uploadStatus = true;
      },
      uploadSuccess() {
        this.uploadStatus = false;
        this.$bvModal.show('bv-modal-upload-success');
        this.timer = setTimeout(() => {
          this.$router.push('/glance');
        }, 3000);
      },
      clearSuccessTimer() {
        clearTimeout(this.timer);
      },
      uploadFailed() {
        this.uploadStatus = false;
        this.$bvModal.show('bv-modal-upload-failed');
      }
    },
  }
</script>

<style lang="less" scoped>
  #upload-image {
    width: 100%;
    box-sizing: border-box;

    .container {
      width: 100%;

      .title {
        cursor: pointer;
      }
    }
  }
</style>