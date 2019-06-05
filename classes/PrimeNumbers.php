<?php

include_once __DIR__.'/Cache.php';
include_once __DIR__.'/SimpleCache.php';

class PrimeNumbers {
    
    private $start = 0;
    private $end = 0;
    private $cache = null;
    
    /**
     * @param int $rangeStart Стартовое значение диапазона
     * @param int $rangeEnd Конечное значение диапазона
     * @param Cache $cache Кеш объект
     */
    public function __construct(int $rangeStart, int $rangeEnd, Cache $cache = null) {
        $this->start = $rangeStart;
        $this->end = $rangeEnd;
        if ($cache != null) {
            $this->cache = $cache;
        } else {
            $this->cache = new SimpleCache();
        }
    }
    
    /**
     * Поучаем и возвращаем список простых чисел в диапазоне
     * @return number[]
     */
    public function getPrimeNumbers() {
        $result = array();
        $this->cache->putPrime(2);
        if ($this->start === 2) {
            $result[] = 2;
        }
        $i = 3;
        while ($i <= $this->end) {
            //echo $i,"\n";
            if ($this->isPrime($i) && $i >= $this->start) {
                $result[] = $i;
            }
            $i += 2;
        }
        //print_r($this->cache->getPrimesList());
        
        return $result;
    }
    
    /**
     * Проверяем число на простое
     * @param int $number
     * @return boolean
     */
    private function isPrime(int $number) {
        $result = true;
        if (!$this->cache->isPrime($number)) {
            if (!$this->cache->notIsPrime($number)) { 
                //echo $number, "\n";
                $root = sqrt($number) + 1;
                $list = $this->cache->getPrimesList();
                //print_r($list);
                set_time_limit(60);
                foreach ($list as $prime) {
                    if ($prime > $root) {
                        break;
                    }
                    if ($number % $prime === 0) {
                        $result = false;
                        break;
                    }
                }
                if ($result) {
                    $this->cache->putPrime($number);
                }
            } else {
                $result = false;
            }
        }
        return $result;
    }
}


