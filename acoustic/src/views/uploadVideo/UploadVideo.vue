<template>
  <div id="upload-video">
    <div class="container shadow p-3 mb-5 bg-white rounded">
      <div class="title row mb-3 justify-content-center">
        <img @click="toHome" src="../../assets/images/logo_long.png" alt="acoustic"
          class="w-50 img-responsive center-block">
      </div>
      <div class="text-center">
        <h1>视频上传</h1>
      </div>
      <!-- 视频上传表单 -->
      <upload-form @uploading="uploading" @uploadFilaed="uploadFailed" @uploadSuccess="uploadSuccess"></upload-form>
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
  import UploadSuccess from './components/UploadSuccess.vue';
  import UploadForm from './components/UploadForm.vue';
  import UploadFailed from './components/UploadFailed.vue';
  import Uploading from './components/Uploading.vue';
  export default {
    components: {
      UploadForm,
      UploadSuccess,
      UploadFailed,
      Uploading
    },
    name: 'UploadVideo',
    data() {
      return {
        timer: null,
        uploadStatus: false
      }
    },
    methods: {
      toHome() {
        this.$router.push('/');
      },
      uploadSuccess() {
        this.uploadStatus = false;
        this.$bvModal.show('bv-modal-upload-success');
        this.timer = setTimeout(() => {
          this.$router.push('/video');
        }, 3000);
      },
      clearSuccessTimer() {
        clearTimeout(this.timer);
      },
      uploadFailed() {
        this.uploadStatus = false;
        this.$bvModal.show('bv-modal-upload-failed');
      },
      uploading() {
        this.uploadStatus = true;
      }
    },
  }
</script>

<style lang="less" scoped>
  #upload-video {
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