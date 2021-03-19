<template>
  <div id="community-actions">
    <div class="title">
      <h4>社区动态</h4>
    </div>
    <!-- 动态列表 -->
    <actions v-if="Boolean(articleList)" :articleList="articleList"></actions>
    <!-- 分页栏 -->
    <pagination v-if="Boolean(articleList)"></pagination>
  </div>
</template>

<script>
  import Actions from './Actions.vue'
  import Pagination from './Pagination.vue'
  import Bbs from '../../../assets/js/Bbs/Bbs.js';

  export default {
    components: {
      Actions,
      Pagination
    },
    name: 'CommunityActions',
    data() {
      return {
        articleList: [],
      }
    },
    // 动态检测路由变化
    watch: {
      '$route'(to, from) {
        Bbs.getArticleList(to.query.page - 1).then(res => {
          if (res.status === 200) {
            this.articleList = res.data;
          }
        }).catch(e => {
          console.log(e.message);
        });
      }
    },
    created() {
      Bbs.getArticleList(0).then(res => {
        if (res.status === 200) {
          this.articleList = res.data;
        }
      }).catch(e => {
        console.log(e.message);
      });
    },
  }
</script>

<style lang="less" scoped>
  @bgColor: #fff;
  @titleColor: #211f1d;

  #community-actions {
    width: 73%;
    background-color: @bgColor;
    border-radius: .2rem;
    box-shadow: 0 0 3px 1px #ccc;
    padding: .5rem;
    box-sizing: border-box;

    @media screen and (max-width: 512px) {
      width: 100%;
    }

    .title {
      border-bottom: 2px solid #ccc;
      padding: .5rem .3rem;

      h4 {
        color: @titleColor;
        margin-bottom: 0;
      }
    }
  }
</style>