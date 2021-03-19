<template>
  <div class="search-box">
    <i @click="resizeSearch" class="fa fa-search"></i>
    <input autocomplete="off" v-model="keywords" @focus="openPannel" @blur="closePannel" @keyup="getSearchResult"
      placeholder="搜索文章" ref="search" class="search" type="text" name="searchContent" />
    <ul @mouseenter="moveEnter" @mouseleave="moveLeave"
      :class="['show-result', openPannelStatus && searchResult ? 'open-pannel' : '']">
      <li @click.stop="toResult(res.id)" class="result-item" v-for="(res,key) of searchResult" :key="key">
        {{ res.title }}
      </li>
    </ul>
  </div>
</template>

<script>
  import Bbs from '../../../assets/js/Bbs/Bbs.js';
  export default {
    name: 'SearchBox',
    data() {
      return {
        // 用户所输入的关键字
        keywords: '',
        // 计时器
        timer: null,
        // 查询结果
        searchResult: [],
        openPannelStatus: false,
        inPannel: false
      }
    },
    methods: {
      // 打开查询面板
      openPannel() {
        let {
          width
        } = window.getComputedStyle(this.$refs.search);
        if (width && width != '0px' && this.searchResult) {
          this.openPannelStatus = true;
        }
      },

      // 关闭查询面板
      closePannel() {
        if (!this.inPannel) {
          this.openPannelStatus = false;
        }
      },

      // 设置面板判别参数，判断是否点击了面板内的元素
      moveEnter() {
        this.inPannel = true;
      },

      moveLeave() {
        this.inPannel = false;
      },

      // 获取查询记录
      getSearchResult() {
        if (!this.keywords) {
          this.searchResult = [];
          return;
        };
        // 通过闭包使用函数防抖减少请求次数
        clearTimeout(this.timer);
        this.timer = setTimeout(() => {
          // 向服务器发送请求
          Bbs.getSearchResult(this.keywords).then(res => {
            this.searchResult = res.data;
            this.openPannelStatus = true;
          });
        }, 500);
      },

      // 去往结果页面
      toResult(article_id) {
        this.$router.push({
          path: '/article',
          query: {
            articleId: article_id
          }
        });
        // 关闭菜单
        this.openPannelStatus = false;
        // 刷新页面
        this.$router.go(0);
      },

      // 查询按钮
      resizeSearch() {
        let {
          clientWidth
        } = document.documentElement;
        if (clientWidth <= 1050) {
          if (clientWidth > 768) {
            this.$refs.search.style.cssText = 'opacity: 1; width: 15rem;';
          } else {
            this.$refs.search.style.cssText = 'opacity: 1; width: 10rem;';
          }
          // 关闭搜索框，在捕获阶段调用与单击搜索按钮的时间错开
          window.addEventListener('click', (e) => {
            if (e.target != this.$refs.search && this.$refs.search) {
              this.$refs.search.style.cssText = '';
            }
          }, true);
        }
      },
    },
  }
</script>

<style lang="less" scoped>
  @fontSize: 1.2rem;
  @mainColor: #afafb7;
  @navfontColor: #616166;
  @keywordsColor: #211f1d;
  @focusColor: #dedfe0;

  .search-box {
    margin: 0 .3rem;
    position: relative;

    .fa-search {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      left: .3rem;
      color: @navfontColor;
      z-index: 1;

      @media screen and (max-width: 1050px) {
        cursor: pointer;
      }
    }

    .search {
      outline: none;
      border: 3px solid @navfontColor;
      border-radius: .4rem;
      padding: 0 .4rem;
      font-size: 1.2rem;
      padding-left: 1.2rem;
      width: 15rem;
      transition: width .3s;
      background-color: @mainColor;
      opacity: .8;
      color: @keywordsColor;
      box-sizing: content-box;

      &:focus {
        border: 3px solid @keywordsColor;
      }

      @media screen and (max-width: 1050px) {
        width: 0;
        opacity: 0;
      }
    }

    .show-result {
      position: absolute;
      top: 100%;
      left: 0;
      z-index: 150;
      width: 100%;
      background-color: @mainColor;
      border-bottom-left-radius: .5rem;
      border-bottom-right-radius: .5rem;
      box-shadow: 0px 2px 1px 1px @navfontColor;
      // 形成BFC
      overflow: hidden;
      display: none;

      &.open-pannel {
        display: block;
      }

      .result-item {
        padding: .5rem;
        width: 100%;
        box-sizing: border-box;
        border-bottom: 1px solid @focusColor;
        margin-bottom: .2rem;
        cursor: pointer;
        color: @keywordsColor;
        font-size: @fontSize;
        transition: transform .1s;

        &:last-child {
          margin-bottom: 0;
        }

        &:hover {
          transform: translateX(3%);
        }
      }
    }
  }
</style>