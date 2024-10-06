<?php

$address = __DIR__ . '/birthdays.txt';

$name = readline("Введите имя: ");
$date = readline("Введите дату рождения в формате ДД-ММ-ГГГГ: ");

if (validate($date) && validateName($name)) {
    $data = $name . ", " . $date . "\r\n";

    // Открываем файл и проверяем успешность
    $fileHandler = fopen($address, 'a');
    
    if ($fileHandler === false) {
        echo "Не удалось открыть файл для записи: $address\n";
    } else {
        if (fwrite($fileHandler, $data)) {
            echo "Запись \"$data\" добавлена в файл \"$address\"\n";
        } else {
            echo "Произошла ошибка записи. Данные не сохранены.\n";
        }
        fclose($fileHandler);
    }
} else {
    echo "Введена некорректная информация\n";
}

// Функция для валидации даты
function validate(string $date): bool {
    $dateBlocks = explode("-", $date);

    if (count($dateBlocks) !== 3) {
        return false; // Проверка на формат ДД-ММ-ГГГГ
    }

    // Преобразуем элементы к числовым значениям
    $day = (int)$dateBlocks[0];
    $month = (int)$dateBlocks[1];
    $year = (int)$dateBlocks[2];

    // Проверяем корректность даты
    if (!checkdate($month, $day, $year)) {
        return false; // Если дата некорректна
    }

    // Проверяем, что год не больше текущего
    if ($year > date('Y')) {
        return false; // Если год больше текущего
    }

    return true;
}

// Функция для валидации имени
function validateName(string $name): bool {
    // Проверка на пустое имя или слишком длинное
    if (empty(trim($name)) || strlen($name) > 100) {
        return false;
    }

    // Проверяем, что имя состоит только из букв и пробелов
    if (!preg_match("/^[a-zA-Zа-яА-ЯёЁ\s]+$/u", $name)) {
        return false;
    }

    return true;
}
