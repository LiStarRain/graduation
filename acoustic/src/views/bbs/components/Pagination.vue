<template>
  <div id="pagination">
    <div class="overflow-auto">
      <b-pagination-nav :link-gen="linkGen" :number-of-pages="pages" use-router></b-pagination-nav>
    </div>
  </div>
</template>

<script>
  import Bbs from '../../../assets/js/Bbs/Bbs.js';
  export default {
    name: 'Pagination',
    data() {
      return {
        pages: 100,
      }
    },
    methods: {
      getArticleList() {
        console.log(this.currentPage);
      },
      linkGen(pageNum) {
        return `?page=${pageNum}`
      }
    },
    created() {
      Bbs.getPages().then(res => {
        if (res.status == 200) {
          this.pages = res.data;
        }
      }).catch(e => {
        console.log(e.message);
      });
    }
  }
</script>

<style lang="less" scoped>
  #pagination {
    width: 100%;
    padding: 1rem;
    display: flex;
    justify-content: center;
  }
</style>