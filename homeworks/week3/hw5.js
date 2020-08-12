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
  const nGame = Number(input[0]); // 第一行 = 有幾組比賽
  for (let i = 1; i <= nGame; i += 1) {
    const lineNumber = input[i].split(' ');
    /* eslint-disable-next-line */
    console.log(bigOrSmall(lineNumber[0], lineNumber[1], lineNumber[2]));
  }
}

// 判斷 K 是 1 還是 -1，並輸出贏的
function bigOrSmall(a, b, K) {
  /* eslint-disable-next-line */
  if (K === '1') return bigWin(a, b);
  if (K === '-1') {
    /* eslint-disable-next-line */
    return smallWin(a, b);
  } return false;
}

// K 是 1，比數字大，大的贏（也可能平手）
// 先比較字串長度，字串長的代表數字大
// 如果字串長度一樣，就可直接用字串比大小
function bigWin(a, b) {
  if (a.length > b.length) return 'A';
  if (a.length < b.length) return 'B';
  if (a === b) return 'DRAW';
  if (a.length === b.length) {
    if (a > b) return 'A';
    if (a < b) return 'B';
  } return false;
}

// K 是 -1，比數字小，小的贏（也可能平手）
function smallWin(a, b) {
  if (a.length < b.length) return 'A';
  if (a.length > b.length) return 'B';
  if (a === b) return 'DRAW';
  if (a.length === b.length) {
    if (a < b) return 'A';
    if (a > b) return 'B';
  } return false;
}
