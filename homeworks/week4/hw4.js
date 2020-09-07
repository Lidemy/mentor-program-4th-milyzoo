const request = require('request');

const CLIENT_ID = '6gpi6hlo1yzk790szczeb0pwfna9wk';

const topGame = {
  url: 'https://api.twitch.tv/kraken/games/top',
  headers: {
    'Client-ID': CLIENT_ID,
    Accept: 'application/vnd.twitchtv.v5+json',
  },
};

const callback = (error, response, body) => {
  if (error) {
    console.log(error);
    return;
  }

  if (response.statusCode >= 200 && response.statusCode < 300) {
    const info = JSON.parse(body).top;
    for (let i = 0; i < info.length; i += 1) {
      console.log(`${info[i].viewers} ${info[i].game.name}`);
    }
  }
};

request(topGame, callback);
