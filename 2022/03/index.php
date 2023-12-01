<?php

// Part One
$inputFile = fopen($argv[1] ?? 'input.txt', 'r');
$charPriorities = array_merge(range('a', 'z'), range('A', 'Z'));
$allPriorities = 0;
$firstPart = "";
$secondPart = "";
$commonChar = "";

while (!feof($inputFile)) {
  $currentLine = fgets($inputFile);
  $firstPart = substr($currentLine, 0, strlen($currentLine) / 2 - 1);
  $secondPart = substr($currentLine, strlen($currentLine) / 2 - 1);

  // Compare char between both parts
  for ($i = 0; $i < strlen($firstPart); $i++) {
    for ($j = 0; $j < strlen($secondPart); $j++) {
      if ($firstPart[$i] === $secondPart[$j]) {
        $commonChar = $firstPart[$i];
        break;
      }
    }
  }

  $allPriorities += array_search($commonChar, $charPriorities) + 1;
}

echo "Part One: " . $allPriorities . "\n";

// Part Two
$inputFile = fopen($argv[1] ?? 'input.txt', 'r');
$countLines = count(file($argv[1] ?? 'input.txt'));
$allPriorities = 0;
$currentIndex = 0;
$firstItem = "";
$secondItem = "";
$thirdItem = "";
$checkGroup = false;
$commonChar = "";

while (!feof($inputFile) || $currentIndex <= $countLines) {
  $currentLine = fgets($inputFile);

  if ($checkGroup) {
    $commonChar = "";

    // Check char between three items of group
    for ($i = 0; $i < strlen($firstItem); $i++) {
      for ($j = 0; $j < strlen($secondItem); $j++) {
        for ($k = 0; $k < strlen($thirdItem); $k++) {
          if ($firstItem[$i] === $secondItem[$j] && $firstItem[$i] === $thirdItem[$k] && $secondItem[$j] === $thirdItem[$k]) {
            $commonChar = $firstItem[$i];
            break;
          }
        }

        if ($commonChar !== "") {
          break;
        }
      }

      if ($commonChar !== "") {
        break;
      }
    }
    $allPriorities += array_search($commonChar, $charPriorities) + 1;
    $checkGroup = false;
  }

  switch ($currentIndex % 3) {
    case 0:
      $firstItem = $currentLine;
      break;
    case 1:
      $secondItem = $currentLine;
      break;
    case 2:
      $thirdItem = $currentLine;
      $checkGroup = true;
      break;
  }

  $currentIndex++;
}

echo "Part Two: " . $allPriorities . "\n";
