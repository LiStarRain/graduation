<template>
  <div id="bbs">
    <div class="content">
      <!-- 动态 -->
      <community-actions></community-actions>
      <!-- 侧边栏 -->
      <community-aside></community-aside>
    </div>
  </div>
</template>

<script>
  import CommunityActions from './components/CommunityActions.vue';
  import CommunityAside from './components/CommunityAside.vue';

  export default {
    components: {
      CommunityActions,
      CommunityAside
    },
    name: 'Bbs'
  }
</script>

<style lang="less" scoped>
  @bgColor: #fff;

  #bbs {
    width: 100%;
    display: flex;
    justify-content: center;
    box-sizing: border-box;
    padding: 1rem;

    .content {
      width: 90%;
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      box-sizing: border-box;

      @media screen and (max-width: 512px) {
        flex-direction: column-reverse;
      }
    }
  }
</style>