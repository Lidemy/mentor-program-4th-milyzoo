/* eslint-disable no-undef, no-use-before-define, no-restricted-syntax */
// 側邊選單收合
document.querySelector('.navbar-btn').addEventListener('click', (e) => {
  e.target.closest('.container').classList.toggle('navbar-hide');
});

// 漢堡選單
document.querySelector('.burger-btn').addEventListener('click', () => {
  document.querySelector('.nav').classList.toggle('open');
  document.querySelector('.burger-btn').classList.toggle('open');
});

const API_URL = 'https://api.twitch.tv/kraken';
const CLIENT_ID = '6gpi6hlo1yzk790szczeb0pwfna9wk';

// 取得前幾名遊戲頻道
getGames((games) => {
  for (game of games) { // 讓 games 裡的每個值都做迴圈內的動作
    const li = document.createElement('li');
    document.querySelector('.nav').append(li);
    li.classList.add('nav__item');
    li.innerText = game.game.name; // 將取到的遊戲頻道名稱填入 li
  }
  // 顯示第一個遊戲的實況
  changeGames(games[0].game.name);
});

// 切換分頁
document.querySelector('.nav').addEventListener('click', (e) => {
  if (e.target.tagName === 'LI') {
    const gameName = e.target.innerText;
    changeGames(gameName);
  }
});

function changeGames(gameName) {
  document.querySelector('.tittle').innerText = gameName;
  document.querySelector('.channel').innerHTML = ''; // 先清空原本的頻道內容
  getStreams(gameName, (data) => {
    for (vale of data) { // 取 games 裡面的每個值
      const channel = document.createElement('a');
      document.querySelector('.channel').append(channel);
      channel.classList.add('channel__item');
      channel.setAttribute('target', '_blank'); // 另開視窗
      channel.setAttribute('href', vale.channel.url); // 帶入直播連結
      channel.innerHTML = `<div class="channel__img"><img src="${vale.preview.large}"></div>
        <div class="avatar">
            <div class="avatar__img"><img src="${vale.channel.logo}" alt=""></div>
            <div class="avatar__info">
                <p class="avatar__tittle">${vale.channel.status}</p>
                <p class="avatar__name">${vale.channel.name}</p>
            </div>
        </div>
        <p class="channel__live-people">${vale.viewers} viewers</p>`;
    }
  }); // 抓取指定遊戲的實況內容
}

function getGames(callback) {
  const request = new XMLHttpRequest();
  request.open('GET', `${API_URL}/games/top?limit=5`, true);
  request.setRequestHeader('Accept', 'application/vnd.twitchtv.v5+json');
  request.setRequestHeader('Client-ID', CLIENT_ID);
  request.onload = () => {
    if (request.status >= 200 && request.status < 400) {
      const games = JSON.parse(request.response).top;
      callback(games);
    }
  };
  request.send();
}

function getStreams(gameName, callback) {
  const request = new XMLHttpRequest();
  request.open('GET', `${API_URL}/streams?game=${encodeURIComponent(gameName)}`, true);
  request.setRequestHeader('Accept', 'application/vnd.twitchtv.v5+json');
  request.setRequestHeader('Client-ID', CLIENT_ID);
  request.onload = () => {
    if (request.status >= 200 && request.status < 400) {
      const data = JSON.parse(request.response).streams;
      callback(data);
    }
  };
  request.send();
}
