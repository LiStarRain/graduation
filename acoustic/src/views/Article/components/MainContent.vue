<template>
  <div id="main-content">
    <main v-html="content"></main>
  </div>
</template>

<script>
  export default {
    name: 'MainContent',
    props: ['content']
  }
</script>

<style lang="less" scoped>
  #main-content {
    width: 100%;
    box-sizing: border-box;
    padding: 1rem;
  }
</style>