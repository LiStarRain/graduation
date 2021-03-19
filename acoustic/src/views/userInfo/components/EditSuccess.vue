<template>
  <div id="edit-success">
    <b-modal id="bv-modal-edit-success" hide-footer>
      <template #modal-title>
        修改成功
      </template>
      <div class="d-block text-center">
        <h3>3s后自动跳转</h3>
      </div>
      <b-button class="mt-3" block @click="toHome">手动跳转</b-button>
    </b-modal>
  </div>
</template>

<script>
  export default {
    name: 'EditSuccess',
    methods: {
      toHome() {
        this.$emit('clearTimer');
        this.$router.replace('/');
      }
    },
  }
</script>