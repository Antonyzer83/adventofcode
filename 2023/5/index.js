const fs = require("node:fs");

// const content = fs.readFileSync("./input-example.txt", "utf8");
const content = fs.readFileSync("./input.txt", "utf8");

const maps = {};
let currentStep = "seed";
let previousStep = "";
let indexes = [];

content.split("\n").forEach((line, index) => {
  if (index === 0) {
    maps["seed"] = line.split(":")[1].trim().split(" ").map(Number);
  } else {
    if (line.length) {
      // Init step data
      if (line.includes("map")) {
        currentStep = line.split(" ")[0].split("-")[2];
        maps[currentStep] = maps[previousStep];
      } else {
        const [dst, src, range] = line.split(" ").map(Number);

        maps[currentStep].forEach((value, index) => {
          if (
            value >= src &&
            value <= src + range &&
            indexes.indexOf(index) === -1
          ) {
            maps[currentStep][index] = dst + (value - src);
            indexes.push(index);
          }
        });
      }
    } else {
      // Reset step
      previousStep = currentStep;
      currentStep = "";
      indexes = [];
    }
  }
});

console.log("Part One ", Math.min.apply(Math, Object.values(maps).pop()));

// maps["seed"] = [];
// const seeds = line.split(":")[1].trim().split(" ").map(Number);
// for (let i = 0; i < seeds.length; i += 2) {
//   for (let j = seeds[i]; j < seeds[i] + seeds[i + 1]; j++) {
//     maps["seed"].push(j);
//   }
// }
