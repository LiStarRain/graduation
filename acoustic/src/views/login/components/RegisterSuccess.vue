<template>
  <div id="registerSuccess">
    <b-modal id="bv-modal-register-success" hide-footer>
      <template #modal-title>
        注册成功！
      </template>
      <div class="d-block text-center">
        <h3>欢迎光临，请自便</h3>
      </div>
      <b-button class="mt-3" block @click="$bvModal.hide('bv-modal-register-success')">关闭（3s后自动跳转）</b-button>
    </b-modal>
  </div>
</template>

<script>
  export default {
    name: 'RegisterSuccess'
  }
</script>