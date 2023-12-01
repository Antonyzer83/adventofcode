const fs = require("node:fs");

const content = fs.readFileSync("./input.txt", "utf8");

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

calibrations.length = 0;

content.split("\n").forEach((line) => {
  line = line
    .replace(/one/g, "o1e")
    .replace(/two/g, "t2o")
    .replace(/three/g, "t3ree")
    .replace(/four/g, "f4ur")
    .replace(/five/g, "f5ve")
    .replace(/six/g, "s6x")
    .replace(/seven/g, "s7ven")
    .replace(/eight/g, "e8ght")
    .replace(/nine/g, "n9ne");

  const numbers = Array.from(line.matchAll(/(\d)/g), (m) => m[0]);

  const first = numbers[0];
  const last = numbers[numbers.length - 1];

  calibrations.push(first + last);
});

console.log(
  "Part Two ",
  calibrations.reduce((a, b) => a + parseInt(b), 0)
);
