<?php

function readLineFromStdin(string $prompt)
{
    echo $prompt;
    return trim(fgets(STDIN));
}

$first    = readLineFromStdin("Введите первое число: ");
$second   = readLineFromStdin("Введите второе число: ");
$operator = readLineFromStdin("Введите оператор (+, -, *, /): ");

if (!is_numeric($first) || !is_numeric($second)) {
    throw new \Exception("введены некорректные числа");
}

$first  = (float) $first;
$second = (float) $second;

switch ($operator) {
    case '+':
        $result = $first + $second;
        break;
    case '-':
        $result = $first - $second;
        break;
    case '*':
        $result = $first * $second;
        break;
    case '/':
        if ($second == 0) {
            throw new \Exception("Ошибка: деление на ноль");
        }
        $result = $first / $second;
        break;
    default:
        throw new \Exception("недопустимый оператор");
}

echo "Ответ: " . $result;
