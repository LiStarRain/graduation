import Axios from 'axios';
import qs from 'qs';

// video页面处理类
export default class Video {
  static getCategories() {
    const url = '/controllers/videoControllers/getCategories.php';
    return Axios.get(url);
  }

  static getVideos(tag = 'all', startIndex = 0) {
    const url = '/controllers/videoControllers/getVideos.php';
    return Axios.get(url, {
      params: {
        tag, startIndex
      }
    });
  }

  static format(url) {
    const reg = /^https?:\/\/localhost(:80)?\//;
    return url.replace(reg, '../../');
  }

  static uploadVideos(data) {
    const url = '/controllers/videoControllers/uploadVideos.php';
    const formData = new FormData();
    for (const [key, value] of Object.entries(data)) {
      if (key === 'files') {
        for (const file of Object.values(data[key])) {
          formData.append(file.name, file);
        }
      } else {
        formData.append(key, value);
      }
    }
    let config = {
      headers: { 'Content-Type': 'multipart/form-data' }
    };
    return Axios.post(url, formData, config);
  }

  // 获取用户上传的所有视频
  static getUserVideos() {
    const url = '/controllers/videoControllers/getUserVideos.php';
    return Axios.get(url);
  }

  // 删除用户所上传的视频
  static deleteUserVideo(id) {
    const url = '/controllers/videoControllers/deleteUserVideo.php';
    const postData = qs.stringify({
      id
    });
    return Axios.post(url, postData);
  }
}