<?php

$filename = 'students.txt';

$lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
if ($lines === false) {
    throw new \Exception();
}

$bestStudent = ['', 0];

foreach ($lines as $line) {
    $pieces = explode(';', $line);

    $points = array_map(fn($x) => (int)$x, explode(',', $pieces[1]));
    $average = array_sum($points) / count($points);

    if ($average > $bestStudent[1]) {
        $bestStudent = [$pieces[0], $average];
    }

    echo $pieces[0] . ': ' . (string)$average . "\n";
}

echo 'Лучший студент: ' . $bestStudent[0] . ': ' . (string)$bestStudent[1];
