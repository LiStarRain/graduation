<template>
  <div id="download-image">
    <div class="author">
      <img :src="authorInfo.head_img" alt="" class="head_img">
      <span class="name">{{ authorInfo.name }}</span>
    </div>
    <div class="download">
      <i @click="downloadImage(imageUrl)" class="fa fa-download"></i>
    </div>
  </div>
</template>

<script>
  import Glance from '../../../assets/js/Glance/Glance.js';
  export default {
    name: 'DownloadImage',
    props: ['authorInfo', 'imageUrl'],
    methods: {
      downloadImage(imageUrl) {
        // 下载图片
        Glance.download(imageUrl).then(res => {
          if (res.status === 200) {
            const data = res.data;
            const url = window.URL.createObjectURL(new Blob([data], {
              type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
            }));
            const link = document.createElement('a');
            link.style.display = 'none';
            link.href = url;
            const fileName = imageUrl.split('/').pop();
            link.setAttribute('download', fileName);
            document.body.append(link);
            link.click();
            link.remove();
          }
        }).catch(e => {
          console.log(e.message);
        });
      }
    },
  }
</script>

<style lang="less" scoped>
  @bgColor: #616166;
  @fontColor: #dedfe0;

  #download-image {
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    background-color: @bgColor;
    opacity: 0;
    width: 100%;
    transition: opacity .3s;
    padding: .5rem 1rem;
    box-sizing: border-box;
    // 形成BFC
    overflow: hidden;
    display: flex;
    justify-content: space-between;
    align-items: center;

    .author {
      display: flex;
      align-items: center;

      .head_img {
        width: 2rem;
        height: 2rem;
        border-radius: 50%;
        margin-right: .7rem;
      }

      .name {
        color: @fontColor;
      }
    }

    .download {
      align-self: flex-end;

      &:hover {
        color: @fontColor;
        cursor: pointer;
      }
    }
  }
</style>