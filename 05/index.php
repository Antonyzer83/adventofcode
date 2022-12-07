<?php

// Part One
$inputFile = fopen($argv[1] ?? 'input.txt', 'r');
$cratesGlobal = array();
$cratesLines = array();
$currentLine = null;
$orderCrates = false;

while (!feof($inputFile)) {
  $currentLine = fgets($inputFile);

  if (empty(trim($currentLine))) {
    if (sizeof($cratesGlobal) === 0) {
      // Init global array with x arrays
      $lastLine = str_split(str_replace(' ', '', end($cratesLines)[0]));
      for ($i = 0; $i < sizeof($lastLine); $i++) {
        array_push($cratesGlobal, array());
      }

      foreach ($cratesLines as $cratesLine) {
        $rank = 0;
        foreach ($cratesLine as $crates) {
          if (isset($crates) && end($cratesLines)[0] !== $crates) {
            $cratesArray = explode('[', $crates);
            $rank += intdiv(strlen($cratesArray[0]), 4);
            array_unshift($cratesGlobal[$rank], $cratesArray[1]);
            $rank++;
          }
        }
      }

      $orderCrates = true;
    }
  } else {
    if ($orderCrates) {
      $move = explode(' ', $currentLine);
      $init = 0;
      $count = $move[1];
      $src = $move[3];
      $dest = $move[5];
      // Move x crates from a to b
      if (isset($argv[2])) { // Part Two
        $values = array();
        while ($init < $count) {
          array_unshift($values, array_pop($cratesGlobal[$src - 1]));
          $init++;
        }
        foreach ($values as $value) {
          array_push($cratesGlobal[intval($dest) - 1], $value);
        }
      } else { // Part One
        while ($init < $count) {
          $lastValue = array_pop($cratesGlobal[$src - 1]);
          array_push($cratesGlobal[intval($dest) - 1], $lastValue);
          $init++;
        }
      }
    } else {
      // Remove backline in items
      array_push($cratesLines, array_map(function ($item) {
        return empty(trim($item)) ? null : str_replace(PHP_EOL, '', $item);
      }, explode(']', $currentLine)));
    }
  }
}

$result = '';
foreach ($cratesGlobal as $range) {
  $result .= array_pop($range);
}

echo 'Part One/Two: ' . $result;
