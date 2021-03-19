import Axios from 'axios';

// 获取网易云音乐的音乐资源
export default class Netease {
  static API_PROXY = 'https://bird.ioliu.cn/v1/?url=';
  constructor(songList = 6654461034) {
    this.songList = songList;
  }

  async make() {
    const songList = await this.getSongList(this.songList);
    return this.format(songList);
  }

  // 格式化
  async format(songList) {
    let songs = [];
    songList.forEach(async song => {
      let artist = [];
      song.artists.forEach(person => {
        artist.push(person.name);
      });
      // 歌词
      let lyric = await this.getLyric(song.id);
      songs.push({
        name: song.name,
        cover: song.album.picUrl,
        artist: artist[0],
        url: this.getSong(song.id),
        lrc: lyric
      });
    });
    return songs;
  }

  // 获取歌单里的歌曲信息
  getSongList(songList) {
    const url = `${Netease.API_PROXY}https://music.163.com/api/playlist/detail?id=${songList}`;
    return Axios.get(url).then(res => {
      if (res.data.code == 200) {
        return res.data.result.tracks;
      }
    }).catch(e => {
      console.log(e.message);
    });
  }

  // 获取歌曲播放地址
  getSong(song_id) {
    return `http://music.163.com/song/media/outer/url?id=${song_id}.mp3`;
  }

  // 获取歌曲的歌词
  getLyric(song_id) {
    const url = `${Netease.API_PROXY}https://music.163.com/api/song/lyric?id=${song_id}&lv=1&kv=1&tv=-1`;
    return Axios.get(url).then(res => {
      if (res.data.code === 200) {
        return res.data.lrc.lyric;
      }
    }).catch(e => {
      console.log(e.message);
    });
  }
}