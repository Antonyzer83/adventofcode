<?php

// Part One
$inputFile = fopen($argv[1] ?? 'input.txt', 'r');
$pairs1 = 0;
$pairs2 = 0;
$firstPair = "";
$secondPair = "";
$firstPairStart = "";
$firstPairEnd = "";
$secondPairEnd = "";
$secondPairEnd = "";

while (!feof($inputFile)) {
  $currentLine = fgets($inputFile);
  list($firstPair, $secondPair) = explode(",", $currentLine);
  list($firstPairStart, $firstPairEnd) = explode("-", $firstPair);
  list($secondPairStart, $secondPairEnd) = explode("-", $secondPair);

  if (
    (int) $firstPairStart >= (int) $secondPairStart && (int) $firstPairEnd <= (int) $secondPairEnd
    || (int) $secondPairStart >= (int) $firstPairStart && (int) $secondPairEnd <= (int) $firstPairEnd
  ) {
    $pairs1++;
  }

  if (
    (int) $firstPairStart <= (int) $secondPairEnd && (int) $secondPairStart <= (int) $firstPairEnd
  ) {
    $pairs2++;
  }
}

echo "Part One: " . $pairs1 . "\n";
echo "Part Two: " . $pairs2 . "\n";
