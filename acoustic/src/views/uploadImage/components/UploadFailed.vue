<template>
  <div id="upload-failed">
    <b-modal id="bv-modal-upload-failed" hide-footer>
      <template #modal-title>
        上传失败
      </template>
      <div class="d-block text-center">
        <h3>抱歉，请稍候再试</h3>
      </div>
      <b-button class="mt-3" block @click="$bvModal.hide('bv-modal-upload-failed')">关闭</b-button>
    </b-modal>
  </div>
</template>

<script>
  export default {
    name: 'UploadFailed'
  }
</script>