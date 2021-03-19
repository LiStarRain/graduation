export default class Validate {
  email(email) {
    const reg = /^\w+@\w+\.(com|cn|org|net)$/;
    return reg.test(email);
  }

  username(username) {
    const reg = /^[\w|\p{sc=Han}]{3,15}$/u;
    return reg.test(username);
  }

  password(password) {
    return password.length > 8;
  }

  birthday(date) {
    let timeStamp = new Date(date).getTime();
    let diffHundred = new Date('2070-01-01 08:00:00') * 1;
    let minStamp = Date.now() - diffHundred;
    return timeStamp <= Date.now() && timeStamp >= minStamp ? true : false;
  }
}