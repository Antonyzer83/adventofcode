<?php

$inputFile = fopen($argv[1] ?? 'input.txt', 'r');
$currentLine = null;
$tailPositions = array();
$grid = array();
$hx = 49;
$hy = 49;
$tx = 49;
$ty = 49;
$xMax = 100;
$yMax = 100;
// $hx = 4;
// $hy = 0;
// $tx = 4;
// $ty = 0;
// $xMax = 5;
// $yMax = 6;

for ($i = 0; $i < $xMax; $i++) {
  array_push($grid, array());
  for ($j = 0; $j < $yMax; $j++) {
    $grid[$i][$j] = "";
  }
}

function printGrid($xMax, $yMax, $hx, $hy, $tx, $ty)
{
  for ($i = 0; $i < $xMax; $i++) {
    for ($j = 0; $j < $yMax; $j++) {
      if ($i === $hx && $j === $hy) {
        echo 'H';
      } elseif ($i === $tx && $j === $ty) {
        echo 'T';
      } else {
        echo '.';
      }
    }
    echo "\n";
  }
  echo "\n------\n";
}

while (!feof($inputFile)) {
  $currentLine = fgets($inputFile);

  list($direction, $steps) = explode(' ', trim($currentLine));

  for ($i = 0; $i < $steps; $i++) {
    // Update head coordinates
    switch ($direction) {
      case 'U':
        $hx--;
        break;
      case 'D':
        $hx++;
        break;
      case 'L':
        $hy--;
        break;
      case 'R':
        $hy++;
        break;
    }

    // Update tail coordinates
    if ($hx === $tx && abs($hy - $ty) > 1) { // Same row
      if ($hy > $ty) {
        $ty++;
      } else {
        $ty--;
      }
    } elseif ($hy === $ty && abs($hx - $tx) > 1) { // Same column
      if ($hx > $tx) {
        $tx++;
      } else {
        $tx--;
      }
    } elseif (abs($hy - $ty) > 1 || abs($hx - $tx) > 1) { // Different row and column
      if ($hx > $tx && $hy > $ty) { // Head is down right
        $tx++;
        $ty++;
      } elseif ($hx < $tx && $hy > $ty) { // Head is up right
        $tx--;
        $ty++;
      } elseif ($hx > $tx && $hy < $ty) { // Head is down left
        $tx++;
        $ty--;
      } elseif ($hx < $tx && $hy < $ty) { // Head is up left
        $tx--;
        $ty--;
      }
    }

    if (!in_array("$tx/$ty", $tailPositions)) {
      array_push($tailPositions, "$tx/$ty");
    }

    // printGrid($xMax, $yMax, $hx, $hy, $tx, $ty);
  }
}

echo "Part One: " . sizeof($tailPositions) . "\n";
