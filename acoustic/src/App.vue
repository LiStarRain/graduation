<template>
  <div id="app">
    <router-view />
    <aplayer v-show="isShow" fixed :audio="audio" :lrcType="0" />
  </div>
</template>

<script>
  import Netease from './assets/js/Netease/Netease.js';
  export default {
    name: 'App',
    data() {
      return {
        model: '',
        // 播放列表
        audio: [],
        isShow: false,
      }
    },
    beforeMount() {
      let {
        clientWidth
      } = document.documentElement;
      this.model = clientWidth >= 768 ? 'hijiki' : 'tororo';
    },
    created() {
      setTimeout(() => {
        window.L2Dwidget.init({
          pluginRootPath: '/acoustic/',
          pluginJsPath: 'lib/',
          pluginModelPath: `live2d-widget-model-${this.model}/assets/`,
          tagMode: false,
          debug: false,
          model: {
            jsonPath: `../static/live2dw/live2d-widget-model-${this.model}/assets/${this.model}.model.json`
          },
          display: {
            superSample: 1,
            position: 'right',
            width: 350,
            height: 400,
            hOffset: -90,
            vOffset: 0,
          },
          react: {
            opacityDefault: 1, // 默认透明度
            opacityOnHover: 1 // 鼠标移上透明度
          },
          mobile: {
            show: true,
            motion: true
          },
          log: false
        })
      }, 500);
    },
    async mounted() {
      // 绑定网易云歌单
      const netease = new Netease();
      const data = await netease.make();
      this.audio = data;
      this.isShow = true;
    },
  }
</script>

<style lang="less">
  @mainColor: #dedce0;

  body {
    // overflow-x: hidden;
    width: 100%;
    box-sizing: border-box;
    background-repeat: no-repeat;
    background-size: 100% 100%;
    background-color: @mainColor  !important;

    &.guitar {
      background-image: url('./assets/images/guitar1.png');
    }

    @media screen and (max-width: 1024px) {
      background-size: cover;
      background-position: 25% center;
    }
  }
</style>