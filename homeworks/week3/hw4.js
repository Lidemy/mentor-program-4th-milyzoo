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
  const str1 = input[0];
  const str2 = input[0].split('');
  /* eslint-disable-next-line */
  if (str1 === palindrome(str2)) {
    console.log('True');
  } else {
    console.log('False');
  }
}

// 印出迴文
function palindrome(str) {
  let result = '';
  for (let i = lines[0].length - 1; i >= 0; i -= 1) {
    result += str[i];
  } return result;
}
