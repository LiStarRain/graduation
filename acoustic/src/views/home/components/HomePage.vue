<template>
  <div id="home-page">
    <!-- 主板块 -->
    <main-content></main-content>
    <!-- 合作伙伴 -->
    <partners></partners>
  </div>
</template>

<script>
  import MainContent from './MainContent.vue';
  import Partners from './Partners.vue';

  export default {
    name: 'HomePage',
    components: {
      MainContent,
      Partners,
    }
  }
</script>

<style lang="less" scoped>
  @navHeight: 3.5rem;
  @mainColor: #afafb7;

  // 第一块显示区布局
  #home-page {
    position: relative;
    overflow: hidden;
  }
</style>