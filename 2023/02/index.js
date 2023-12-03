const fs = require("node:fs");

// const content = fs.readFileSync("./input-example.txt", "utf8");
const content = fs.readFileSync("./input.txt", "utf8");

const maxs = {
  red: 12,
  green: 13,
  blue: 14,
};

const ids = [];

content.split("\n").forEach((line) => {
  const [game, strSets] = line.split(":");
  const id = game.split(" ")[1];
  const sets = strSets.split(";");

  let isGameValid = true;

  sets.every((set) => {
    // Check each set of one of multiple colors
    const colors = {
      red: 0,
      green: 0,
      blue: 0,
    };

    // Split each color and add to object
    set.split(",").forEach((color) => {
      const [value, name] = color.trim().split(" ");
      colors[name] = parseInt(value);
    });

    if (
      colors.red <= maxs.red &&
      colors.green <= maxs.green &&
      colors.blue <= maxs.blue
    ) {
      return true;
    } else {
      // Do not continue loop if one set is invalid
      isGameValid = false;
      return false;
    }
  });

  if (isGameValid) {
    ids.push(id);
  }
});

console.log(
  "Part One ",
  ids.reduce((a, b) => a + parseInt(b), 0)
);

let power = 0;

content.split("\n").forEach((line) => {
  const sets = line.split(":")[1].split(";");

  const colors = {
    red: 0,
    green: 0,
    blue: 0,
  };

  sets.forEach((set) => {
    set.split(",").forEach((color) => {
      const [value, name] = color.trim().split(" ");
      if (colors[name] < parseInt(value)) {
        colors[name] = parseInt(value);
      }
    });
  });

  power += colors.red * colors.green * colors.blue;
});

console.log("Part Two ", power);
