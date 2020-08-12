const readline = require('readline');

const lines = [];
const rl = readline.createInterface({
  input: process.stdin,
});

rl.on('line', (line) => {
  lines.push(line);
});

rl.on('close', () => {
/* eslint-disable-next-line */
  solve(lines);
});

function solve(input) {
  // 範圍 n ~ m
  const n = Number(input[0].split(' ')[0]);
  const m = Number(input[0].split(' ')[1]);

  // 從 5 至 200 的範圍內
  for (let i = n; i <= m; i += 1) {
    /* eslint-disable-next-line */
    if (i === narcissisticNumber(i)) {
      console.log(i);
    }
  }

  // 每個數字的 n 次方加總
  function narcissisticNumber(number) {
    const numLength = String(number).length; // 得到幾位數
    const a = String(number).split('');
    let result = 0; // 加總後的結果
    for (let i = 0; i < numLength; i += 1) {
      result += a[i] ** numLength;
    } return result;
  }
}
