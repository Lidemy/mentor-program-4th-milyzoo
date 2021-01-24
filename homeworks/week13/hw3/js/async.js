/* eslint-disable no-undef, no-use-before-define, no-restricted-syntax, quote-props */

// 側邊選單收合
document.querySelector('.navbar-btn').addEventListener('click', (e) => {
  e.target.closest('.container').classList.toggle('navbar-hide');
});

// 漢堡選單
document.querySelector('.burger-btn').addEventListener('click', () => {
  document.querySelector('.nav').classList.toggle('open');
  document.querySelector('.burger-btn').classList.toggle('open');
});

// 因為不會換頁，所以點擊後要自動關閉漢堡選單
document.querySelector('.nav').addEventListener('click', (e) => {
  if (e.target.classList.contains('nav__item')) {
    document.querySelector('.nav').classList.remove('open');
    document.querySelector('.burger-btn').classList.remove('open');
  }
});

const API_URL = 'https://api.twitch.tv/kraken';
const CLIENT_ID = '6gpi6hlo1yzk790szczeb0pwfna9wk';

// 取得前幾名遊戲頻道放到 navbar，並把第一個遊戲資料渲染到畫面上
async function renderGames() {
  try {
    const data = await getGames(); // 拿到 API 資料
    appendGames(data.top); // 將遊戲頻道渲染到 navbar 上
    changeGames(data.top[0].game.name); // 顯示第一個遊戲的實況
  } catch (err) {
    console.log(`錯誤：${err}`);
  }
}
renderGames();

// 切換分頁
document.querySelector('.nav').addEventListener('click', (e) => {
  if (e.target.tagName === 'LI') {
    const gameName = e.target.innerText;
    changeGames(gameName);
  }
});

// 將遊戲頻道渲染到 navbar 上
function appendGames(gamesData) {
  for (game of gamesData) { // 讓 games 裡的每個值都做迴圈內的動作
    const li = document.createElement('li');
    document.querySelector('.nav').append(li);
    li.classList.add('nav__item');
    li.innerText = game.game.name; // 將取到的遊戲頻道名稱填入 li
  }
}

// 將頻道資料渲染到畫面上
function appendStreams(streamsData) {
  for (vale of streamsData) { // 取 games 裡面的每個值
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
}

async function changeGames(gameName) {
  document.querySelector('.tittle').innerText = gameName;
  document.querySelector('.channel').innerHTML = ''; // 先清空原本的頻道內容
  try {
    const data = await getStreams(gameName);
    appendStreams(data.streams);
  } catch (err) {
    console.log(`錯誤：${err}`);
  }
}

async function getGames() {
  const response = await fetch(`${API_URL}/games/top?limit=5`, {
    headers: {
      'Accept': 'application/vnd.twitchtv.v5+json',
      'Client-ID': CLIENT_ID,
    },
  }); // 沒有寫 method 就是默認 GET
  const data = await response.json();
  return data;
}

async function getStreams(gameName) {
  const response = await fetch(`${API_URL}/streams?game=${encodeURIComponent(gameName)}&limit=20`, {
    headers: {
      'Accept': 'application/vnd.twitchtv.v5+json',
      'Client-ID': CLIENT_ID,
    },
  }); // 沒有寫 method 就是默認 GET
  const data = await response.json();
  return data;
}