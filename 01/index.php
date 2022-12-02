<?php

// Part One
$inputFile = fopen($argv[1] ?? 'input.txt', 'r');
$allCalories = array();
$currentCalories = 0;
$currentLine = null;

while (!feof($inputFile)) {
  $currentLine = fgets($inputFile);
  if (empty(trim($currentLine))) {
    // Insert each Elve
    array_push($allCalories, $currentCalories);
    $currentCalories = 0;
  } else {
    // Increment each Elve
    $currentCalories += (int) $currentLine;
  }
}
// Insert last Elve
array_push($allCalories, $currentCalories);

echo "Part One: " . max($allCalories) . "\n";

// Part Two
rsort($allCalories);
$countTopThree = 0;
for ($i = 0; $i < 3; $i++) {
  $countTopThree += $allCalories[$i];
}

echo "Part Two: " . $countTopThree . "\n";
