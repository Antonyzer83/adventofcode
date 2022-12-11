<?php

$inputFile = fopen($argv[1] ?? 'input.txt', 'r');
$currentLine = null;
$tailPositions = array();
$tailUniquePositions = array();
// $hx = 49;
// $hy = 49;
// $xMax = 100;
// $yMax = 100;
$hx = 4;
$hy = 0;
$xMax = 5;
$yMax = 6;

for ($i = 0; $i < 10; $i++) {
  array_push($tailPositions, array(
    'number' => $i + 1,
    'x' => $hx,
    'y' => $hy,
  ));
}

function printGrid($xMax, $yMax, $hx, $hy, $tailPositions)
{
  for ($i = 0; $i < $xMax; $i++) {
    for ($j = 0; $j < $yMax; $j++) {
      if ($i === $hx && $j === $hy) {
        echo 'H';
      } else {
        $tailNumber = null;
        foreach ($tailPositions as $tail) {
          if ($tail['x'] === $i && $tail['y'] === $j) {
            $tailNumber = $tail['number'];
            break;
          }
        }
        echo $tailNumber ?? '.';
      }
    }
    echo "\n";
  }
  echo "\n------\n";
}

function updateKnotPosition($hx, $hy, $tx, $ty)
{
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

  return [$tx, $ty];
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
    for ($j = 0; $j < sizeof($tailPositions); $j++) {
      if ($j === 0) {
        [$tailPositions[$j]['x'], $tailPositions[$j]['y']] = updateKnotPosition(
          $hx,
          $hy,
          $tailPositions[$j]['x'],
          $tailPositions[$j]['y']
        );
      } else {
        [$tailPositions[$j]['x'], $tailPositions[$j]['y']] = updateKnotPosition(
          $tailPositions[$j - 1]['x'],
          $tailPositions[$j - 1]['y'],
          $tailPositions[$j]['x'],
          $tailPositions[$j]['y']
        );
      }

      // Only check position 9 -> tail only
      if ($j === 8 && !in_array($tailPositions[$j]['x'] . "/" . $tailPositions[$j]['y'], $tailUniquePositions)) {
        array_push($tailUniquePositions, $tailPositions[$j]['x'] . "/" . $tailPositions[$j]['y']);
      }
    }

    // printGrid($xMax, $yMax, $hx, $hy, $tailPositions);
  }
}

echo "Part One/Two: " . sizeof($tailUniquePositions) . "\n";
