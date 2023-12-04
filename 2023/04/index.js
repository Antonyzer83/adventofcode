const fs = require("node:fs");

// const content = fs.readFileSync("./input-example.txt", "utf8");
const content = fs.readFileSync("./input.txt", "utf8");

let total = 0;

content.split("\n").forEach((line) => {
  const list = line.split(":")[1];
  const lists = list.split("|");

  const winNums = lists[0]
    .split(" ")
    .filter((num) => num.length)
    .map((num) => parseInt(num));
  const nums = lists[1]
    .split(" ")
    .filter((num) => num.length)
    .map((num) => parseInt(num));

  let count = 0;

  winNums.forEach((num) => {
    if (nums.includes(num)) {
      if (count === 0) {
        count = 1;
      } else {
        count = count * 2;
      }
    }
  });

  total += count;
});

console.log("Part One ", total);

const ids = {};

content.split("\n").forEach((line) => {
  const [match, list] = line.split(":");
  const id = parseInt(match.split(" ").filter((num) => num.length)[1]);
  const lists = list.split("|");

  const winNums = lists[0]
    .split(" ")
    .filter((num) => num.length)
    .map((num) => parseInt(num));
  const nums = lists[1]
    .split(" ")
    .filter((num) => num.length)
    .map((num) => parseInt(num));

  let count = 0;

  winNums.forEach((num) => {
    if (nums.includes(num)) {
      count++;
    }
  });

  // Set default value for current match
  if (!ids[id]) {
    ids[id] = 1;
  }

  // Create copy of following matches
  for (let i = id + 1; i < id + 1 + count; i++) {
    if (!ids[i]) {
      ids[i] = 1;
    }

    ids[i] = ids[i] + 1 * ids[id];
  }
});

console.log(
  "Part Two ",
  Object.values(ids)
    .map((id) => id)
    .reduce((a, b) => a + b, 0)
);
