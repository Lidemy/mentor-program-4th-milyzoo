/* eslint-disable no-alert */
// ---------------- 漢堡選單 ----------------
const mobileMenu = document.querySelector('.mobile-menu');
const navbar = document.querySelector('.navbar');
mobileMenu.addEventListener('click', () => {
  navbar.classList.toggle('open');
  mobileMenu.classList.toggle('open');
});

// ------------------ 抽獎 ------------------
const apiUrl = 'https://dvwhnbka7d.execute-api.us-east-1.amazonaws.com/default/lottery';
const errorMessage = '系統不穩定，請再試一次';

// 獎品對應的內容
function checkPrize(prize) {
  const prizeContent = document.querySelector('.lottery-result__content');
  const lottery = document.querySelector('.lottery');
  switch (true) {
    case (prize === 'FIRST'):
      prizeContent.innerText = '恭喜你中頭獎了！日本東京來回雙人遊！';
      lottery.classList.add('lfirst-prize');
      break;
    case (prize === 'SECOND'):
      prizeContent.innerText = '二獎！90 吋電視一台！';
      lottery.classList.add('second-prize');
      break;
    case (prize === 'THIRD'):
      prizeContent.innerText = '恭喜你抽中三獎：知名 YouTuber 簽名握手會入場券一張，bang！';
      lottery.classList.add('third-prize');
      break;
    case (prize === 'NONE'):
      prizeContent.innerText = '銘謝惠顧';
      lottery.classList.add('none-prize');
      break;
    default:
      alert(errorMessage);
      break;
  }
}

// 抽獎 api
function draw(cb) {
  const xhr = new XMLHttpRequest();
  xhr.open('GET', apiUrl, true);
  xhr.onload = () => {
    if (xhr.status >= 200 && xhr.status < 400) {
      let data;
      try {
        data = JSON.parse(xhr.response);
      } catch (err) {
        cb(errorMessage);
        return;
      }

      if (!data.prize) { // 如果 data.prize 是空值
        cb(errorMessage);
        return;
      }
      cb(null, data);
    } else {
      cb(errorMessage);
    }
  };
  xhr.onerror = () => {
    cb(errorMessage);
  };
  xhr.send();
}

document.querySelector('.lottery__btn').addEventListener('click', (e) => {
  draw((err, data) => {
    if (err) {
      alert(err);
      return;
    }

    // 點擊抽獎後把原本的活動資訊隱藏
    e.target.parentNode.classList.add('lottery-hide');
    document.querySelector('.lottery-result').classList.remove('lottery-hide');
    checkPrize(data.prize);
  });
});
