<?php

function main() {
    while (true) {
        // Выводим меню
        echo "\nВыберите действие:\n";
        echo "1. Добавить день рождения\n";
        echo "2. Проверить день рождения на сегодня\n";
        echo "3. Удалить день рождения\n";
        echo "4. Выход\n";
        
        // Чтение выбора пользователя
        $choice = readline("Введите номер действия: ");
        
        // Выполняем действие в зависимости от выбора
        switch ($choice) {
            case '1':
                addBirthday();
                break;
            case '2':
                checkBirthdayToday();
                break;
            case '3':
                deleteBirthday();
                break;
            case '4':
                echo "Выход из программы.\n";
                exit;
            default:
                echo "Некорректный выбор, пожалуйста, выберите пункт от 1 до 4.\n";
                break;
        }
    }
}

function addBirthday() {
    // Реализация добавления дня рождения
    $address = __DIR__ . '/birthdays.txt';
    $name = readline("Введите имя: ");
    $date = readline("Введите дату рождения в формате ДД-ММ-ГГГГ: ");
    
    if (validate($date)) {
        $data = $name . ", " . $date . PHP_EOL;
        $fileHandler = fopen($address, 'a');
        
        if (fwrite($fileHandler, $data)) {
            echo "Запись \"$data\" добавлена в файл $address\n";
        } else {
            echo "Произошла ошибка записи. Данные не сохранены\n";
        }
        
        fclose($fileHandler);
    } else {
        echo "Введена некорректная информация\n";
    }
}

function checkBirthdayToday() {
    // Реализация проверки дня рождения на сегодня
    $address = __DIR__ . '/birthdays.txt';
    $today = date('d-m');
    $fileLines = file($address, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $found = false;
    
    foreach ($fileLines as $line) {
        list($name, $date) = explode(", ", $line);
        $birthDate = substr($date, 0, 5);
        
        if ($birthDate === $today) {
            echo "Сегодня день рождения у: $name\n";
            $found = true;
        }
    }
    
    if (!$found) {
        echo "Сегодня нет именинников.\n";
    }
}

function deleteBirthday() {
    // Реализация удаления дня рождения
    $address = __DIR__ . '/birthdays.txt';
    $input = readline("Введите имя или дату для удаления (ДД-ММ-ГГГГ): ");
    $fileLines = file($address, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $found = false;
    
    $fileHandler = fopen($address, 'w');
    
    foreach ($fileLines as $line) {
        list($name, $date) = explode(", ", trim($line));
        
        if ($input === $name || $input === $date) {
            $found = true;
            echo "Строка с \"$input\" найдена и удалена.\n";
            continue;
        }
        
        fwrite($fileHandler, $line . PHP_EOL);
    }
    
    fclose($fileHandler);
    
    if (!$found) {
        echo "Строка с \"$input\" не найдена.\n";
    }
}

function validate(string $date): bool {
    $dateBlocks = explode("-", $date);
    
    if (count($dateBlocks) !== 3) {
        return false;
    }
    
    list($day, $month, $year) = $dateBlocks;
    
    // Проверка дня
    if (!is_numeric($day) || $day < 1 || $day > 31) {
        return false;
    }
    
    // Проверка месяца
    if (!is_numeric($month) || $month < 1 || $month > 12) {
        return false;
    }
    
    // Проверка года
    $currentYear = date('Y');
    if (!is_numeric($year) || $year < 1900 || $year > $currentYear) {
        return false;
    }
    
    return true;
}

// Запуск основного меню
main();