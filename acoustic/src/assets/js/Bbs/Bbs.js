import Axios from 'axios';
import qs from 'qs';

export default class Bbs {
  // 上传文章
  static publish(article) {
    const url = `/controllers/bbsControllers/publishArticle.php`;
    article = qs.stringify({
      article
    });
    return Axios.post(url, article);
  }

  // 获取文章列表
  static getArticleList(page = 0) {
    const url = `/controllers/bbsControllers/getArticleList.php`;
    return Axios.get(url, {
      params: {
        page
      }
    });
  }

  // 获取页数
  static getPages() {
    const url = `/controllers/bbsControllers/getPages.php`;
    return Axios.get(url);
  }

  // 获取文章内容
  static getArticle(articleId) {
    const url = `/controllers/bbsControllers/getArticle.php`;
    return Axios.get(url, {
      params: {
        article_id: articleId
      }
    });
  }

  // 获取查询数据
  static getSearchResult(keywords) {
    const url = `/controllers/bbsControllers/getSearchResult.php`;
    return Axios.get(url, {
      params: {
        keywords
      }
    });
  }

  // 获取用户所发表过的文章
  static getUserArticles() {
    const url = `/controllers/bbsControllers/getUserArticles.php`;
    return Axios.get(url);
  }

  // 删除用户发表的文章
  static deleteUserArticle(id) {
    const url = `/controllers/bbsControllers/deleteUserArticle.php`;
    const postData = qs.stringify({
      id
    });
    return Axios.post(url, postData);
  }
}