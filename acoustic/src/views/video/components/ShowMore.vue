<template>
  <div id="show-more">
    <!-- 点击加载更多图片 -->
    <button @click="loadMore" class="load">
      <slot></slot>
    </button>
  </div>
</template>

<script>
  export default {
    name: 'ShowMore',
    methods: {
      loadMore() {
        this.$emit('loadMoreVideos');
      }
    },
  }
</script>

<style lang="less" scoped>
  @bgColor: #fc8f00;
  @fontColor: #f0f0f0;

  #show-more {
    width: 100%;
    display: flex;
    justify-content: center;
    box-sizing: border-box;

    .load {
      border: none;
      outline: none;
      padding: 0.2rem 1rem;
      background: @bgColor;
      color: @fontColor;
      border-radius: .6rem;
      box-shadow: 0 0 5px 1px @bgColor;

      &:hover {
        opacity: .9;
      }
    }
  }
</style>