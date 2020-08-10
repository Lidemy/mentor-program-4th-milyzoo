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
  const n = Number(input[0]);
  let result = '';
  for (let i = 0; i < n; i += 1) {
    result += '*';
    console.log(result);
  }
}
