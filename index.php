<?php
include_once __DIR__.'/classes/PrimeNumbers.php';
include_once __DIR__.'/classes/PDOCache.php';

// Constants
// Соединение с базой через PDO
const PDO_DSN = 'mysql:dbname=vashe-pravo;host=127.0.0.1';
const PDO_USER = 'root'; 
const PDO_PWD = 'root';

// Максимальное число в вычисляемом диапазоне
const MAX_RANGE_NUMBER = 1000000;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получаем запрос на вычиление
    // Валидируем вводные значения диапазона
    $start = isset($_POST['range_start'])?(int)$_POST['range_start']:0;
    $end = isset($_POST['range_end'])?(int)$_POST['range_end']:0;
    $errors = array();
    if ($start < 2 || $start > MAX_RANGE_NUMBER) {
        // 
        $errors['range_start'] = 'error';
    }
    if ($end < 2 || $end > MAX_RANGE_NUMBER) {
        //
        $errors['range_end'] = 'error';
    }
    $result = array();
    
    if ($errors !== array()) {

        // Отправляем клиенту ошибки
        $result['error'] = $errors;
        
    } else {
        
        // Устанавливаем правильные значения диапазона
        if ($start > $end) {
            $tmp = $start;
            $start = $end;
            $end = $tmp;
        }
        $result['start'] = $start;
        $result['end'] = $end;
        
        // Инициируем доступ к БД
        $pdo = new PDO(PDO_DSN, PDO_USER, PDO_PWD);
        //
        $st = microtime(true);
        // Создаем обект вычислений простых чисел
        $pr = new PrimeNumbers($start, $end, new PDOCache($end, $pdo));
        // Получаем результат
        $result['numbers'] = $pr->getPrimeNumbers();
        $et = microtime(true) - $st;
        $result['time'] = $et;
        
        // Цепляем темплейт с хидерами для JSON
        include_once __DIR__.'/templates/json.tpl.php';
        //
    }
    echo json_encode($result);
    //
} else {
    // Цепляем темплейт с формой
    include_once __DIR__.'/templates/common.tpl.php';
}