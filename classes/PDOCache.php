<?php

include_once __DIR__.'/Cache.php';

/** 
 * @author admin
 * 
 */
class PDOCache implements \Cache {

    private $cahce = array(); 
    
    private $pdo = null;
    
    public function __construct(int $range_end, PDO $pdo) {
        $this->pdo = $pdo;
        $sql = 'SELECT p.prime_number FROM primes p WHERE p.prime_number <= '.$range_end. ' ORDER BY p.prime_number';
        foreach ($pdo->query($sql) as $row) {
            $this->cahce[$row['prime_number']] = true;
        }
    }
    
    public function __destruct() {
        $sql = 'INSERT INTO primes (prime_number) VALUES ';
        $cnt = 0;
        $vals = '';
        foreach ($this->cahce as $k => $v) {
            if (!$v) {
                $vals .= ($cnt?',':'').'('.$k.')';
                $cnt++;
                if ($cnt == 100) {
                    $this->pdo->exec($sql.$vals);
                    $cnt = 0;
                    $vals = '';
                }
            }
        }
        if ($cnt > 0) {
            $this->pdo->exec($sql.$vals);
        }
    }
    /**
     * (non-PHPdoc)
     *
     * @see Cache::putPrime()
     *
     */
    public function putPrime(int $number) {
        if (!$this->isPrime($number)) {
            $this->cahce[$number] = false;
        }
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
    public function getPrimesList(int $number = null) {
        return array_keys($this->cahce);
    }
}

