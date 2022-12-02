<?php

$inputFile = fopen($argv[1] ?? 'input.txt', 'r');
$score = 0;
$currentLine = null;
$round = null;

$shapeBonnus = array(
  'X' => 1,
  'Y' => 2,
  'Z' => 3,
);

// Part One
while (!feof($inputFile)) {
  $currentLine = fgets($inputFile);
  $round = array_map('trim', explode(' ', $currentLine));
  if (
    $round[1] === 'X' && $round[0] === 'C'
    || $round[1] === 'Y' && $round[0] === 'A'
    || $round[1] === 'Z' && $round[0] === 'B'
  ) {
    $score += 6;
  } elseif (
    $round[1] === 'X' && $round[0] === 'B'
    || $round[1] === 'Y' && $round[0] === 'C'
    || $round[1] === 'Z' && $round[0] === 'A'
  ) {
    $score += 0;
  } else {
    $score += 3;
  }
  $score += $shapeBonnus[$round[1]];
}

echo "Part One: " . $score . "\n";

// Part Two
$inputFile = fopen($argv[1] ?? 'input.txt', 'r');
$score = 0;

// A Rock
// B Paper
// C Scissor
// X Rock
// Y Paper
// Z Scissor

while (!feof($inputFile)) {
  $currentLine = fgets($inputFile);
  $round = array_map('trim', explode(' ', $currentLine));
  switch ($round[1]) {
    case 'X': // Lose
      $score += 0;
      if ($round[0] === 'A') {
        $score += $shapeBonnus['Z'];
      } elseif ($round[0] === 'B') {
        $score += $shapeBonnus['X'];
      } else {
        $score += $shapeBonnus['Y'];
      }
      break;
    case 'Y': // Draw
      $score += 3;
      if ($round[0] === 'A') {
        $score += $shapeBonnus['X'];
      } elseif ($round[0] === 'B') {
        $score += $shapeBonnus['Y'];
      } else {
        $score += $shapeBonnus['Z'];
      }
      break;
    case 'Z': // Win
      $score += 6;
      if ($round[0] === 'A') {
        $score += $shapeBonnus['Y'];
      } elseif ($round[0] === 'B') {
        $score += $shapeBonnus['Z'];
      } else {
        $score += $shapeBonnus['X'];
      }
      break;
  }
}

echo "Part Two: " . $score . "\n";
