import Vue from 'vue'
import Vuex from 'vuex'
import Comments from '../assets/js/Comments/Comments';

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    loginStatus: '',
    userInfo: {},
    messages: [],
    comments: [],
    haveNewMessages: false
  },
  mutations: {
    // 修改状态
    setLoginStatus(state, status) {
      state.loginStatus = status;
    },
    // 设置用户资料
    setUserInfo(state, info) {
      state.userInfo = info;
    },
    // 设置用户的回复数据
    setUserMessages(state, messages) {
      state.messages = messages;
    },
    // 用户是否有新消息来了
    setNewMessages(state) {
      state.haveNewMessages = true;
    },
    // 设置评论
    setUserComments(state, comments) {
      state.comments = comments;
    }
  },
  actions: {
    // 判断用户是否登陆过网站，浏览器中是否有相关的cookie
    getLoginStatus(context) {
      Vue.prototype.$User.getLoginStatus().then(res => {
        if (res.status === 200) {
          // 提交
          context.commit('setLoginStatus', res.data);
        }
      }).catch(error => {
        console.log(error.message);
      });
    },

    // 获取用户的资料
    getUserInfo(context) {
      Vue.prototype.$User.getUserInfo().then(res => {
        if (res.status === 200) {
          // 提交数据
          context.commit('setUserInfo', res.data);
        }
      }).catch(error => {
        console.log(error.message);
      });
    },

    // 获取用户的消息
    getUserMessages(context) {
      Comments.getUserReplys().then(res => {
        if (res.status === 200 && res.data instanceof Array && res.data.length > 0) {
          let temp = document.cookie.split(';').filter(item => item.includes('username'))[0];
          let username = temp.split('=')[1];
          // 提交数据
          context.commit('setUserMessages', res.data);
          // 初始化消息数目
          if (!localStorage.getItem(`messages${username}`)) {
            localStorage.setItem(`messages${username}`, res.data.length);
            context.commit('setNewMessages');
          } else {
            if (localStorage.getItem(`messages${username}`) < res.data.length) {
              // 有新消息来了
              context.commit('setNewMessages');
              localStorage.setItem(`messages${username}`, res.data.length);
            }
          }
        }
      }).catch(e => {
        console.log(e.message);
      });
    },

    getUserComments(context) {
      Comments.getUserComments().then(res => {
        if (res.status === 200 && res.data instanceof Array && res.data.length > 0) {
          let temp = document.cookie.split(';').filter(item => item.includes('username'))[0];
          let username = temp.split('=')[1];
          // 提交数据
          context.commit('setUserComments', res.data);
          // 初始化消息数目
          if (!localStorage.getItem(`comments${username}`)) {
            localStorage.setItem(`comments${username}`, res.data.length);
            context.commit('setNewMessages');
          } else {
            if (localStorage.getItem(`comments${username}`) < res.data.length) {
              // 有新消息来了
              context.commit('setNewMessages');
              localStorage.setItem(`comments${username}`, res.data.length);
            }
          }
        }
      }).catch(e => {
        console.log(e.message);
      });
    }
  }
});
