const fs = require("node:fs");

// const content = fs.readFileSync("./input-example.txt", "utf8");
const content = fs.readFileSync("./input.txt", "utf8");

let row = 0;
let sum = 0;
const pattern = /[^0-9\.]/;

const table = content.split("\n").map((line) => {
  return line.split("");
});

content.split("\n").forEach((line) => {
  const numbers = line.matchAll(/[0-9][0-9]*/g);

  // loop over regex object
  for (const number of numbers) {
    let index = number.index;
    let isPartNumber = false;

    number[0].split("").every((digit) => {
      if (
        // same row
        (index > 0 && pattern.test(table[row][index - 1])) ||
        (index < table[row].length - 1 &&
          pattern.test(table[row][index + 1])) ||
        // up and down
        (row > 0 && pattern.test(table[row - 1][index])) ||
        (row < table.length - 1 && pattern.test(table[row + 1][index])) ||
        // diagonal
        (row > 0 && index > 0 && pattern.test(table[row - 1][index - 1])) ||
        (row > 0 &&
          index < table[row].length - 1 &&
          pattern.test(table[row - 1][index + 1])) ||
        (row < table.length - 1 &&
          index > 0 &&
          pattern.test(table[row + 1][index - 1])) ||
        (row < table.length - 1 &&
          index < table[row].length - 1 &&
          pattern.test(table[row + 1][index + 1]))
      ) {
        isPartNumber = true;
        return false;
      }

      index++;
      return true;
    });

    if (isPartNumber) {
      sum += parseInt(number[0]);
    }
  }

  row++;
});

console.log("Part One ", sum);
