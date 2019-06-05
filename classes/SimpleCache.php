<?php

include_once __DIR__.'/Cache.php';

/** 
 * @author admin
 * 
 */
class SimpleCache implements \Cache {

    private $cahce = array(); 

    /**
     * (non-PHPdoc)
     *
     * @see Cache::putPrime()
     *
     */
    public function putPrime(int $number) {
        $this->cahce[$number] = true;
    }

    /**
     * (non-PHPdoc)
     *
     * @see Cache::isPrime()
     *
     */
    public function isPrime(int $number) {
        return isset($this->cahce[$number]);
    }
    
    /**
     * {@inheritDoc}
     * @see Cache::notIsPrime()
     */
    public function notIsPrime(int $number) {
        end($this->cahce);
        $num = key($this->cahce);
        return $number < $num;
    }
    
    /**
     * {@inheritDoc}
     * @see Cache::getPrimesList()
     */
    public function getPrimesList() {
        return array_keys($this->cahce);
    }
}

