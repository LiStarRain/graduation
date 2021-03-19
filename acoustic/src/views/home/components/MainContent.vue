<template>
  <!-- 主板块 -->
  <section id="main-content">
    <div class="title">
      <h1>Y.Acoustic Guitar</h1>
      <h3>网络社区</h3>
      <button @click.stop="getIt" class="getIt">Get it!
        <i class="fa fa-music" aria-hidden="true"></i>
      </button>
    </div>
    <div class="introduce">
      <div class="intro-item" v-for="(item,key) of introduce" :key="key">
        <h4 class="intro-title">
          {{ item.title }}
        </h4>
        <p class="intro-content">
          {{ item.content }}
        </p>
      </div>
    </div>
  </section>
</template>

<script>
  export default {
    name: 'MainContent',
    data() {
      return {
        introduce: [{
            title: '持续集成',
            content: '我们会不断更新网站的内容，营造一个良好的交流环境'
          },
          {
            title: '论坛交流',
            content: '在论坛中你可以与志同道合的朋友相互交流，互相切磋'
          },
          {
            title: '内容丰富',
            content: '你可以在这里观看视频，寻找音乐资源'
          }
        ],
      }
    },
    methods: {
      getIt() {
        this.$router.push('/glance');
      }
    }
  }
</script>

<style lang="less" scoped>
  @navHeight: 3.5rem;
  @titleColor: #211f1d;
  @loginColor: #fc8f00;
  @contentColor: #da8826;

  @font-face {
    font-family: "Pang";
    src: url('../../../assets/font/庞门正道真贵楷体.ttf') format("truetype");
  }

  #main-content {
    width: 100%;
    height: 100vh;
    box-sizing: border-box;
    display: flex;
    flex-direction: column;
    justify-content: space-evenly;
    align-items: center;
    position: relative;

    .title {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;

      h1 {
        font: bolder 3rem 'Pang', '微软雅黑';
        color: @loginColor;
        margin-bottom: 1.5rem;

        @media screen and (max-width:768px) {
          font-size: 2rem;
        }
      }

      h3 {
        font-size: 2rem;
        font-weight: bold;
        color: @titleColor;
        margin-bottom: 2rem;

        @media screen and (max-width:768px) {
          font-size: 1.5rem;
        }
      }

      .getIt {
        font-size: 2rem;
        cursor: pointer;
        border: none;
        outline: none;
        background-color: @loginColor;
        color: @titleColor;
        border-radius: 1rem;
        padding: 1rem;
        transition: all .3s;

        @media screen and (max-width:768px) {
          font-size: 1.5rem;
        }

        &:hover {
          transform: scale(1.1);
        }
      }
    }

    .introduce {
      display: flex;
      align-items: center;
      border-top: 1px solid @contentColor;
      border-bottom: 1px solid @contentColor;
      padding: 2rem 1rem;

      @media screen and (max-width: 768px) {
        flex-direction: column;
      }

      .intro-item {
        width: 15rem;
        line-height: 1.5rem;
        margin: 0 1rem;

        @media screen and (max-width: 768px) {
          margin-bottom: 1rem;
        }

        .intro-title {
          font-size: 1.2rem;
          font-weight: bold;
          color: @contentColor;
          margin-bottom: .5rem;
        }

        .intro-content {
          color: @contentColor;
          font-weight: bold;
        }

        &:last-child {
          margin-bottom: 0;

          .intro-content {
            margin-bottom: 0;
          }
        }
      }
    }
  }
</style>