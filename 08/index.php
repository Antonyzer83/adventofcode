<?php

$inputFile = fopen($argv[1] ?? 'input.txt', 'r');
$currentLine = null;
$trees = array();
$finalTrees = array();
$maxTrees = array();
$finalTreesCount = 0;

while (!feof($inputFile)) {
  $currentLine = fgets($inputFile);
  array_push($trees, str_split(trim($currentLine)));
}

function isVisible($line, $height)
{
  // Check no equal or superior height in same direction
  return sizeof(array_filter($line, function ($item) use ($height) {
    return $item >= $height;
  })) === 0;
}

for ($i = 0; $i < sizeof($trees); $i++) {
  $finalTrees[$i] = array();

  for ($j = 0; $j < sizeof($trees[$i]); $j++) {
    if (
      $i === 0 ||
      $j === 0 ||
      $i === (sizeof($trees) - 1) ||
      $j === (sizeof($trees[$i]) - 1)
    ) {
      // Trees around the edge are always visible
      $finalTrees[$i][$j] = "O";
      $finalTreesCount++;
    } else {
      $top = array_slice(array_column($trees, $j), 0, $i);
      $bottom = array_slice(array_column($trees, $j), $i + 1);
      $left = array_slice($trees[$i], 0, $j);
      $right = array_slice($trees[$i], $j + 1);

      if (
        isVisible($top, $trees[$i][$j]) ||
        isVisible($bottom, $trees[$i][$j]) ||
        isVisible($left, $trees[$i][$j]) ||
        isVisible($right, $trees[$i][$j])
      ) {
        $finalTrees[$i][$j] = "O";
        $finalTreesCount++;
      } else {
        $finalTrees[$i][$j] = "X";
      }
    }

    // Visualize forest
    echo $finalTrees[$i][$j] === "O" ? (chr(27) . "[42m" . $trees[$i][$j] . chr(27) . "[0m") : $trees[$i][$j];
  }
  echo "\n";
}

//       I-1 J
// I J-1  I J  I J+1
//       I+1 J

echo "Part One: " . $finalTreesCount . "\n";
