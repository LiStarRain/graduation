import Axios from 'axios';
import qs from 'qs';

// 用户操作类
export default class User {
  // 后端接口地址
  static controllerUrl = '/controllers/userControllers/loginController.php';

  // 获取登录状态
  static getLoginStatus() {
    return Axios.get(this.controllerUrl, {
      params: {
        action: 'getLoginStatus'
      }
    });
  }

  // 获取用户信息
  static getUserInfo() {
    return Axios.get(this.controllerUrl, {
      params: {
        action: 'getUserInfo'
      }
    });
  }

  // 用户登录
  static login(email, password, captcha) {
    let postData = qs.stringify({
      action: 'login',
      email,
      password,
      captcha
    });
    return Axios.post(this.controllerUrl, postData);
  }

  // 注销用户
  static logout() {
    return Axios.get(this.controllerUrl, {
      params: {
        action: 'logout',
      }
    });
  }

  // 注册用户
  static register(accountInfo) {
    const formData = new FormData();
    formData.append('action', 'register');
    for (const [key, value] of Object.entries(accountInfo)) {
      formData.append(key, value);
    }
    let config = {
      headers: { 'Content-Type': 'multipart/form-data' }
    };
    return Axios.post(this.controllerUrl, formData, config);
  }

  // 更新用户信息
  static updateUserInfo(info) {
    const url = '/controllers/userControllers/updateUserInfo.php';
    const formData = new FormData();
    for (const [key, value] of Object.entries(info)) {
      formData.append(key, value);
    }
    let config = {
      headers: { 'Content-Type': 'multipart/form-data' }
    };
    return Axios.post(url, formData, config);
  }
}