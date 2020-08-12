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
  for (let i = 1; i <= n; i += 1) {
    const p = Number(input[i]);
    /* eslint-disable-next-line */
    if (isPrime(p)) {
      console.log('Prime');
    } else {
      console.log('Composite');
    }
  }
}

function isPrime(number) {
  if (number === 1) return false;
  for (let j = 2; j <= number - 1; j += 1) {
    if (number % j === 0) return false;
  }
  return true;
}
