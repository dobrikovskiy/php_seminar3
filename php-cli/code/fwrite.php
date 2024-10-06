<?php

$address = __DIR__ . '/birthdays.txt';
$today = date('d-m'); // Получаем текущую дату в формате ДД-ММ

// Открываем файл для чтения
$fileHandler = fopen($address, 'r');

if ($fileHandler) {
    $hasBirthdays = false; // Флаг для отслеживания найденных совпадений

    while (($line = fgets($fileHandler)) !== false) {
        // Убираем возможные пробелы и символы новой строки
        $line = trim($line);

        // Разделяем строку на имя и дату
        list($name, $date) = explode(", ", $line);

        // Извлекаем день и месяц из даты
        $birthDate = substr($date, 0, 5); // Первые пять символов ДД-ММ

        // Сравниваем дату дня рождения с текущей датой
        if ($birthDate === $today) {
            echo "Сегодня день рождения у: $name\n";
            $hasBirthdays = true;
        }
    }

    // Если совпадений не найдено, выводим соответствующее сообщение
    if (!$hasBirthdays) {
        echo "Сегодня нет именинников.\n";
    }

    fclose($fileHandler);
} else {
    echo "Не удалось открыть файл $address для чтения.\n";
}