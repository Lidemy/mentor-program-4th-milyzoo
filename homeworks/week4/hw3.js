const request = require('request');
const process = require('process');

const country = process.argv[2];

request(
  `https://restcountries.eu/rest/v2/name/${country}`,
  (error, response, body) => {
    const info = JSON.parse(body);
    if (error) {
      console.log('抓取失敗', error);
      return;
    }
    if (!country) {
      console.log('請輸入國家名稱');
      return;
    }
    for (let i = 0; i < info.length; i += 1) {
      console.log('============');
      console.log(`國家：${info[i].name}`);
      console.log(`首都：${info[i].capital}`);
      console.log(`貨幣：${info[i].currencies[0].code}`); // currencies 是一個 Object
      console.log(`國碼：${info[i].callingCodes[0]}`);
    }
  },
);
