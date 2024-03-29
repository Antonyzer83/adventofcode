<?php

$inputFile = fopen($argv[1] ?? 'input.txt', 'r');
$part = $argv[2] ?? 1;
$currentMonkey = 0;
$monkeys = array();
$rounds = 10000;

while (!feof($inputFile)) {
  $currentLine = fgets($inputFile);
  $args = explode(':', trim($currentLine));

  if (sizeof($args) > 1) { // Skip empty line
    switch ($args[0]) {
      case 'Starting items':
        $monkeys[$currentMonkey]['items'] = array_map('trim', explode(',', $args[1]));
        break;
      case 'Operation':
        $monkeys[$currentMonkey]['operation'] = array_map('trim', explode(' ', $args[1]));
        break;
      case 'Test':
        $monkeys[$currentMonkey]['divisible'] = array_map('trim', explode(' ', $args[1]))[3];
        break;
      case 'If true':
        $monkeys[$currentMonkey]['isTrue'] = array_map('trim', explode(' ', $args[1]))[4];
        break;
      case 'If false':
        $monkeys[$currentMonkey]['isFalse'] = array_map('trim', explode(' ', $args[1]))[4];
        break;
      default:
        $currentMonkey = explode(' ', $args[0])[1];
        $monkeys[$currentMonkey] = array(
          'items' => array(),
          'operation' => array(),
          'divisible' => 0,
          'isTrue' => 0,
          'isFalse' => 0,
          'inspectedItems' => 0,
        );
    }
  }
}

for ($r = 0; $r < $rounds; $r++) {
  for ($i = 0; $i < sizeof($monkeys); $i++) {
    foreach ($monkeys[$i]['items'] as $item) {
      // Operate
      $result = eval('return ' .
        ($monkeys[$i]['operation'][3] === 'old' ? $item : $monkeys[$i]['operation'][3]) .
        $monkeys[$i]['operation'][4] .
        ($monkeys[$i]['operation'][5] === 'old' ? $item : $monkeys[$i]['operation'][5]) .
        ';');

      // Divide by 3 (only for part one)
      if ($part == 1) {
        $result = floor($result / 3);
      } else {
        $result = $result % 9699690;
      }

      // Check divisible by X to throw to specific monkey
      array_push(
        $monkeys[$monkeys[$i][($result % $monkeys[$i]['divisible']) === 0 ? 'isTrue' : 'isFalse']]['items'],
        $result,
      );

      // Increase inspected items count
      $monkeys[$i]['inspectedItems']++;
    }

    // Reset monkey items
    $monkeys[$i]['items'] = array();
  }

  // Echo items only for part one
  if ($part == 1) {
    echo "\nRound " . ($r + 1) . "\n";
    foreach ($monkeys as $key => $monkey) {
      echo "Monkey " . ($key + 1) . " (" . $monkey['inspectedItems'] . ") " . ": " . implode(", ", $monkey['items']) . "\n";
    }
  } else {
    if (in_array($r + 1, array(1, 20, 1000, 2000, 3000, 4000, 5000, 6000, 7000, 8000, 9000, 10000))) {
      echo "\n== After round " . ($r + 1) . " ==\n";
      foreach ($monkeys as $key => $monkey) {
        echo "Monkey " . ($key + 1) . " inspected items " . $monkey['inspectedItems'] . " times.\n";
      }
    }
  }
}

$inspectedItems = array_column($monkeys, 'inspectedItems');
rsort($inspectedItems);

echo "\nPart " . ($part == 1 ? "One" : "Two") . ": " . ($inspectedItems[0] * $inspectedItems[1]) . "\n";
