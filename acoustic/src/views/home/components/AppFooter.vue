<template>
  <!-- 页脚 -->
  <div id="footer">
    <p>滇ICP备 2020006948 号</p>
    <p>&copy;2021 云南原声吉他馆</p>
  </div>
</template>

<script>
  export default {
    name: 'AppFooter'
  }
</script>

<style lang="less" scoped>
  @fontColor: #211f1d;

  #footer {
    box-sizing: border-box;
    width: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    color: @fontColor;
    padding: 1rem;
    font-size: 1.5rem;
    border-top: 1px solid @fontColor;

    p {
      line-height: 1.5rem;

      @media screen and (max-width:768px) {
        line-height: 1.2rem;
        font-size: 1rem;
      }
    }
  }
</style>