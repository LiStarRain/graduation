<template>
  <div id="user" @click="toUserInfo">
    <div class="user-head">
      <img class="head-image" :src="userInfo.head_img" alt="头像">
      <i v-show="flag && haveNewMessages" class="fa fa-circle" aria-hidden="true"></i>
    </div>
    <div class="context-menu">
      <div class="arrow" v-if="isShow">
        <i @click.stop="showContext" :class="['fa','fa-arrow-down',isOn?'active':'']"></i>
        <ul ref="context" :class="['context',isOn?'on':'']">
          <li class="context-item">个人菜单</li>
          <li @click.stop="toWorksManagement" class="context-item">作品管理</li>
          <li @click.stop="toMessageBox" class="context-item message">
            消息
            <i v-show="flag && haveNewMessages" class="fa fa-circle" aria-hidden="true"></i>
          </li>
          <li @click.stop='logout' class="context-item logout">注销</li>
        </ul>
      </div>
      <div class="username" v-else>
        <div class="user-info">
          <div class="name"><span>{{ userInfo.username }}</span></div>
          <ul class="min-context-menu">
            <li class="context-item">个人菜单</li>
            <li @click.stop="toWorksManagement" class="context-item">作品管理</li>
            <li @click.stop="toMessageBox" class="context-item message">
              消息
              <i v-show="flag && haveNewMessages" class="fa fa-circle" aria-hidden="true"></i>
            </li>
            <li @click.stop='logout' class="context-item logout">注销</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import {
    mapState
  } from 'vuex';
  export default {
    name: 'User',
    data() {
      return {
        // true显示下拉箭头，false显示用户名
        isShow: false,
        // 功能列表
        content: ['个人信息', '消息'],
        // 是否显示下拉菜单
        isOn: false,
        // 用户信息
        userInfo: {},
        flag: true
      }
    },
    computed: {
      ...mapState(['haveNewMessages'])
    },
    methods: {
      // 作品管理
      toWorksManagement() {
        this.$router.push('/worksManagement');
      },
      // 去往用户信息页
      toUserInfo() {
        this.$router.push('/userInfo');
      },
      // 去往消息页面
      toMessageBox() {
        this.$router.push('/messageBox');
        // 关闭红点
        this.flag = false;
      },
      // 显示用户下拉菜单
      showContext() {
        this.isOn = !this.isOn;
        // 点击其它地方隐藏下拉菜单，注意在捕获阶段调用避开显示菜单的事件处理器
        window.addEventListener('click', (e) => {
          if (e.target !== this.$refs.context) {
            this.isOn = false;
          }
        }, true);
      },
      // 注销
      logout() {
        // 向服务器发送请求注销账户
        this.$User.logout().then(res => {
          // 刷新页面
          res.data ? this.$router.go(0) : '';
        }).catch(error => {
          console.log(error.message);
        });
      }
    },
    // 检测设备屏幕大小
    mounted() {
      const {
        clientWidth
      } = document.documentElement;
      if (clientWidth > 768) {
        this.isShow = true;
      }
    },
    // 获取用户数据
    created() {
      this.$User.getUserInfo().then(res => {
        if (res.status == 200) {
          this.userInfo = res.data;
        }
      }).catch(err => {
        console.log(err);
      });
    }
  }
</script>

<style lang="less" scoped>
  @arrowColor: #ea8f19;
  @fontSize: 1.2rem;
  @mainColor: #afafb7;
  @keywordsColor: #211f1d;

  .active {
    color: @arrowColor;
  }

  #user {
    display: flex;
    justify-content: flex-start;
    align-items: center;
    box-sizing: border-box;
    cursor: pointer;

    @media screen and (max-width:768px) {
      align-items: flex-start;
    }

    .user-head {
      transition: all .3s;
      transform-origin: center center;
      position: relative;

      .fa {
        margin: 0;
        font-size: .5rem;
        color: #e74c3c;
        position: absolute;
        top: 0;
        right: 1%;
      }

      .head-image {
        width: 2rem;
        height: 2rem;
        border-radius: 50%;
        margin-right: .3rem;
      }

      &:hover {
        transform: rotate(720deg) scale(1.2);
      }
    }

    .context-menu {
      position: relative;

      .fa-arrow-down:hover {
        color: @arrowColor;
      }

      .context {
        position: absolute;
        width: 10vw;
        background-color: #efefef;
        top: 2.2rem;
        right: 0%;
        border-top: none;
        border-bottom-left-radius: .5rem;
        border-bottom-right-radius: .5rem;
        opacity: 1;
        transition: all .3s;
        z-index: 200;
        // 形成BFC!!!!
        overflow: hidden;
        z-index: -1;
        height: 0;
        display: flex;
        flex-direction: column;
        justify-content: space-between;

        .message {
          display: flex;

          .fa {
            font-size: .3rem;
            color: #e74c3c;
            align-self: flex-start;
            margin-left: .2rem;
          }
        }

        &.on {
          opacity: 1;
          height: 10rem;
          z-index: 200;
        }

        .context-item {
          padding: .5rem;
          color: @keywordsColor;
          cursor: pointer;
          transition: all .2s;

          &:hover {
            transform: translateX(3%);
          }
        }

        .logout {
          color: @arrowColor;
        }
      }

      .user-info {
        margin-left: .5rem;

        .name {
          font-size: 1.2em;
          color: #000;
          margin-bottom: .3rem;
          padding: .3rem;
          font-weight: bold;
        }

        .min-context-menu {
          .context-item {
            padding: .3rem;
            border-bottom: 2px solid #ccc;
            margin-bottom: .5rem;

            &.message {
              .fa {
                color: #e74c3c;
              }
            }
          }
        }
      }
    }
  }
</style>