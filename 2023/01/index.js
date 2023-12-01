const fs = require("node:fs");

const content = fs.readFileSync("./input-example-2.txt", "utf8");

const calibrations = [];

content.split("\n").forEach((line) => {
  const numbers = Array.from(line.matchAll(/(\d)/g), (m) => m[0]);
  const first = numbers[0];
  const last = numbers[numbers.length - 1];

  calibrations.push(first + last);
});

console.log(
  "Part One ",
  calibrations.reduce((a, b) => a + parseInt(b), 0)
);
