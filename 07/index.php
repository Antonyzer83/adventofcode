<?php

$inputFile = fopen($argv[1] ?? 'input.txt', 'r');
$folders = array();
$path = array();
$totalSize = 0;
$newDir = "";
$newIndex = 0;

while (!feof($inputFile)) {
  $currentLine = fgets($inputFile);
  // Explode line in args
  $args = array_map('trim', explode(' ', $currentLine));

  if ($args[0] === '$') {
    if ($args[1] === 'cd') {
      if ($args[2] === '..') {
        array_pop($path);
      } else {
        // Increment folder name to prevent duplication
        $newIndex = 0;
        do {
          $newDir = $args[2] . ($newIndex > 0 ? $newIndex : '');
          $newIndex++;
        } while (isset($folders[$newDir]));

        array_push($path, $newDir);
        $folders[end($path)] = 0;
      }
    }
  } elseif ($args[0] !== 'dir') {
    // Update parent and current folder sizes with new discovered file
    foreach ($path as $folder) {
      $folders[$folder] += $args[0];
    }
  }
}

$totalSize = array_sum(array_filter($folders, function ($folder) {
  return $folder < 100000 ? $folder : 0;
}));

echo "Part One: " . $totalSize . "\n";
