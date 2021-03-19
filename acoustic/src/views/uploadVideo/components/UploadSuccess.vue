<template>
  <div id="upload-success">
    <b-modal id="bv-modal-upload-success" hide-footer>
      <template #modal-title>
        上传成功
      </template>
      <div class="d-block text-center">
        <h3>3s后自动跳转</h3>
      </div>
      <b-button class="mt-3" block @click="toVideo">点我跳转</b-button>
    </b-modal>
  </div>
</template>

<script>
  export default {
    name: 'UploadSuccess',
    methods: {
      toVideo() {
        this.$emit('clearSuccessTimer');
        this.$router.push('/video');
      },
    },
  }
</script>