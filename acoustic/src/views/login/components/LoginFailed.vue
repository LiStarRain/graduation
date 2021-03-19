<template>
  <div id="loginFailed">
    <b-modal id="bv-modal-login-failed" hide-footer>
      <template #modal-title>
        登录失败
      </template>
      <div class="d-block text-center">
        <h3>请检查用户名和密码后重试</h3>
      </div>
      <b-button class="mt-3" block @click="$bvModal.hide('bv-modal-login-failed')">关闭</b-button>
    </b-modal>
  </div>
</template>

<script>
  export default {
    name: 'LoginFailed'
  }
</script>