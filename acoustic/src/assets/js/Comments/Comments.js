import Axios from 'axios';
import qs from 'qs';

export default class Comments {
  // 上传评论
  static publishComment(comment, articleId) {
    const url = "/controllers/commentsControllers/publishComment.php";
    const postData = qs.stringify({
      comment,
      articleId
    });
    return Axios.post(url, postData);
  }

  // 获取文章的评论
  static getComments(articleId) {
    const url = "/controllers/commentsControllers/getComments.php";
    return Axios.get(url, {
      params: {
        articleId
      }
    });
  }

  // 回复评论
  static postReply(to, content, commentId) {
    const url = "/controllers/commentsControllers/postReply.php";
    const posData = qs.stringify({
      to,
      content,
      comment_id: commentId
    });
    return Axios.post(url, posData);
  }

  // 获取评论
  static getReplys(commentId) {
    const url = '/controllers/commentsControllers/getReplys.php';
    return Axios.get(url, {
      params: {
        commentId
      }
    });
  }

  static getUserReplys() {
    const url = '/controllers/commentsControllers/getUserReplys.php';
    return Axios.get(url);
  }

  static getUserComments() {
    const url = '/controllers/commentsControllers/getUserComments.php';
    return Axios.get(url);
  }

  // 删除评论
  static deleteUserComment(id) {
    const url = '/controllers/commentsControllers/deleteUserComment.php';
    const postData = qs.stringify({
      id
    });
    return Axios.post(url, postData);
  }

  // 删除回复
  static deleteUserReply(id) {
    const url = '/controllers/commentsControllers/deleteUserReply.php';
    const postData = qs.stringify({
      id
    });
    return Axios.post(url, postData);
  }
}