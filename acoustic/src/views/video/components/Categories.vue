<template>
  <div id="categories">
    <div @click="setTag(category.tag)" :class="['category-button',category.tag]" v-for="(category,index) of categories"
      :key="index">
      <img class="tag-img" :src="category.img" alt="">
      <span class="tag-desc">{{ category.desc }}</span>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'Categories',
    props: ['categories'],
    methods: {
      setTag(tag) {
        // 设置图片标签
        this.$emit('filterVideos', tag);
      }
    }
  }
</script>

<style lang="less" scoped>
  @bgColor: #dedfe0;
  @titleColor: #211f1d;
  @shadowColor: #616166;

  #categories {
    width: 100%;
    display: flex;
    justify-content: flex-start;
    align-items: center;
    overflow-x: auto;
    box-sizing: border-box;
    padding: .5rem;

    .category-button {
      display: flex;
      justify-content: flex-start;
      align-items: center;
      padding: .3rem;
      margin-right: .5rem;
      box-shadow: 0 2px 5px 1px @shadowColor;
      border-radius: 1rem;
      box-sizing: border-box;
      background-color: @bgColor;
      cursor: pointer;
      flex-shrink: 0;

      &:hover {
        background-color: #f0f0f0;
      }

      .tag-img {
        width: 2rem;
        height: 2rem;
        border-radius: 50%;
        margin-right: .3rem;
      }

      .tag-desc {
        color: @titleColor;
        font-size: 1.2rem;
      }
    }
  }
</style>