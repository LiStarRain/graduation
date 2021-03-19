<template>
  <div id="uploading">
    <b-spinner variant="danger"></b-spinner>
  </div>
</template>

<script>
  export default {
    name: 'Uploading'
  }
</script>

<style lang="less" scoped>
  @bgColor: #dedce0;

  #uploading {
    width: 100vw;
    height: 100vh;
    box-sizing: border-box;
    position: fixed;
    top: 0;
    left: 0;
    background-color: @bgColor;
    opacity: .8;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 200;
  }
</style>