<?php

$inputFile = fopen($argv[1] ?? 'input.txt', 'r');
$system = array(
  'size' => 0,
);
$keys = array();
$refSystem = null;

while (!feof($inputFile)) {
  $currentLine = fgets($inputFile);
  // Explode line in args
  $args = array_map('trim', explode(' ', $currentLine));
  // Update current directory location
  $refSystem = &$system;
  foreach ($keys as $key) {
    $refSystem = &$refSystem[$key];
  }

  if ($args[0] === '$') {
    if ($args[1] === 'cd') {
      if ($args[2] === '/') {
        // Reset key to root
        $keys = array();
      } elseif ($args[2] === '..') {
        // Remove last directory from keys
        array_pop($keys);
      } else {
        // Init new directory if not exists
        if (!isset($refSystem[$args[2]])) {
          $refSystem[$args[2]] = array(
            'size' => 0,
          );
        }
        array_push($keys, $args[2]);
      }
    }
  } elseif ($args[0] !== 'dir') {
    $refSystem['size'] += $args[0];
  }
}

function getDirectorySize($myArray)
{
  $sizeToSave = 0;
  $folderSize = 0;
  $subfolderSize = 0;
  $subfolderSizeToSave = 0;

  if (sizeof($myArray) > 1) {
    foreach ($myArray as $key => $value) {
      if ($key === 'size') {
        $folderSize += $value;
      } else {
        list($subfolderSize, $subfolderSizeToSave) = getDirectorySize($value);
        $folderSize += $subfolderSize;
        $sizeToSave += $subfolderSizeToSave + ($folderSize < 100000 ? $folderSize : 0);
      }
    }
  } else {
    $folderSize = $myArray['size'];
    $sizeToSave = $myArray['size'] < 100000 ? $myArray['size'] : 0;
  }

  return array($folderSize, $sizeToSave);
}

list($test, $finalSize) = getDirectorySize($system);

print_r($system);
echo "Part One: " . $finalSize . "\n";
