<template>
  <div v-show="isShow" id="to-top">
    <button class="top" @click="toTop">
      <i class="fa fa-arrow-up"></i>
    </button>
  </div>
</template>

<script>
  export default {
    name: 'ToTop',
    data() {
      return {
        isShow: false
      }
    },
    methods: {
      toTop() {
        document.documentElement.scrollIntoView({
          block: 'start',
          behavior: 'smooth'
        });
      }
    },
    mounted() {
      window.addEventListener('scroll', () => {
        if (document.documentElement.scrollTop > document.documentElement.clientHeight) {
          this.isShow = true;
        } else {
          this.isShow = false;
        }
      });
    },
  }
</script>

<style lang="less" scoped>
  @bgColor: #fc8f00;
  @fontColor: #f0f0f0;

  #to-top {
    position: fixed;
    bottom: 5%;
    left: 2%;
    border-radius: 50%;
    box-shadow: 0 0 5px 1px @bgColor;
    box-sizing: border-box;
    z-index: 200;

    .top {
      border: none;
      outline: none;
      font-size: 1.2rem;
      color: @fontColor;
      border-radius: 50%;
      width: 2.5rem;
      height: 2.5rem;
      background-color: @bgColor;
      display: flex;
      justify-content: center;
      align-items: center;
      transition: transform .3s;

      &:hover {
        transform: rotate(360deg);
      }
    }
  }
</style>