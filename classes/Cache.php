<?php

interface Cache {
    /**
     * Проверяем есть ли в кеше число как простое
     * @param int $number
     * @return boolean
     */
    public function isPrime(int $number);
    /**
     * Проверяем по кешу, что число точно не простое
     * @param int $number
     * @return boolean
     */
    public function notIsPrime(int $number);
    /**
     * Кладем в кеш простое число
     * @param int $number
     * @return void
     */
    public function putPrime(int $number);
    
    /**
     * Получем кеш-массив
     * @param int $number
     */
    public function getPrimesList();
}

