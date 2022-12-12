<?php

$inputFile = fopen($argv[1] ?? 'input.txt', 'r');
$totalSignalStrength = 0;
$cycles = 0;
$x = 1;

function checkCycles($cycles, $x)
{
  $mainCycle = false;
  $mainCycles = array(0, 20, 60, 100, 140, 180, 220);
  if ($mainCycle = array_search($cycles, $mainCycles)) {
    return $mainCycles[$mainCycle] * $x;
  } else {
    return 0;
  }
}

function checkSpritePosition($cycles, $x)
{
  $spritePosition = $cycles % 40;
  if ($spritePosition >= $x && $spritePosition <= ($x + 2)) {
    echo "#";
  } else {
    echo ".";
  }
  if ($spritePosition === 0) {
    echo "\n";
  }
}

echo "Part Two: \n";

while (!feof($inputFile)) {
  $currentLine = fgets($inputFile);

  $args = explode(' ', trim($currentLine));

  if ($args[0] === "noop") {
    $cycles++;
    checkSpritePosition($cycles, $x);
    $totalSignalStrength += checkCycles($cycles, $x);
  } else {
    for ($i = 0; $i < 2; $i++) {
      $cycles++;
      checkSpritePosition($cycles, $x);
      $totalSignalStrength += checkCycles($cycles, $x);
      if ($i === 1) {
        $x += $args[1];
      }
    }
  }
}

echo "\nPart One: " . $totalSignalStrength . "\n";
