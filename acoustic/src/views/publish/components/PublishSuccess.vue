<template>
  <div id="publish-success">
    <div class="pannel">
      <span>操作成功</span>
      <i class="fa fa-check"></i>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'PublishSuccss'
  }
</script>

<style lang="less" scoped>
  #publish-success {
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
      background-color: #6ab04c;
      padding: .5rem 1rem;
      border-radius: .3rem;
      display: flex;
      justify-content: space-around;
      align-items: center;
    }
  }
</style>