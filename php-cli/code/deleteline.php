<?php

$address = __DIR__ . '/birthdays.txt';

// Запрашиваем  в консоли имя или дату для удаления
$input = readline("Введите имя или дату для удаления (ДД-ММ-ГГГГ): ");

// Читаем содержимое файла в массив
$fileLines = file($address, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$found = false; // Флаг для отслеживания, найдена ли строка

// Открываем файл для записи (перезаписи)
$fileHandler = fopen($address, 'w');

foreach ($fileLines as $line) {
    // Убираем лишние пробелы и символы новой строки
    $trimmedLine = trim($line);

    // Разделяем строку на имя и дату
    list($name, $date) = explode(", ", $trimmedLine);

    // Проверяем, соответствует ли введённое имя или дата текущей строке
    if ($input === $name || $input === $date) {
        $found = true;
        echo "Строка с \"$input\" найдена и удалена.\n";
        continue; // Пропускаем добавление этой строки в файл
    }

    // Перезаписываем файл, добавляя все строки, кроме удаляемой
    fwrite($fileHandler, $trimmedLine . PHP_EOL);
}

// Закрываем файл
fclose($fileHandler);

// Если строка не найдена, выводим сообщение
if (!$found) {
    echo "Строка с \"$input\" не найдена.\n";
}