<template>
  <div id="publish-failed">
    <div class="pannel">
      <span>操作失败</span>
      <i class="fa fa-time"></i>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'PublishFailed'
  }
</script>

<style lang="less" scoped>
  #publish-failed {
    width: 100%;
    position: fixed;
    top: 1.5rem;
    left: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 2222;

    .pannel {
      width: 10rem;
      color: #fff;
      background-color: #eb4d4b;
      padding: .5rem 1rem;
      border-radius: .3rem;
      display: flex;
      justify-content: space-around;
      align-items: center;
    }
  }
</style>