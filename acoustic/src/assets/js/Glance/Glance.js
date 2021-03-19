import Axios from 'axios';
import qs from 'qs';

export default class Glance {
  // Glance页面图片处理类
  static download(imageUrl) {
    const url = '/controllers/imageControllers/downloadImage.php'
    // 处理图片地址
    let imagePath = this.formatUrl(imageUrl);
    return Axios({
      method: 'GET',
      url,
      responseType: 'arraybuffer',
      params: {
        imagePath
      }
    });
  }

  static formatUrl(url) {
    // 按照一定格式对url进行格式化，方便后端读取文件数据
    const reg = /^http:\/\/localhost:80\//;
    return url.replace(reg, '../../');
  }

  // 获取图片分类
  static getCategories() {
    const url = '/controllers/imageControllers/getCategories.php';
    return Axios.get(url);
  }

  // 获取图片资源，默认获取全部类型的12条数据
  static getImages(tag = 'all', startIndex = 0) {
    const url = '/controllers/imageControllers/getImages.php';
    return Axios.get(url, {
      params: {
        tag, startIndex
      }
    });
  }

  // 上传图片
  static uploadImages(data) {
    const url = '/controllers/imageControllers/uploadImages.php';
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

  // 获取用户上传过的所有图片
  static getUserImages() {
    const url = '/controllers/imageControllers/getUserImages.php';
    return Axios.get(url);
  }

  // 删除图片 
  static deleteImage(id) {
    const url = '/controllers/imageControllers/deleteUserImage.php';
    const postData = qs.stringify({
      id
    });
    return Axios.post(url, postData);
  }
}