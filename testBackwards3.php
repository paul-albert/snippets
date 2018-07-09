<?php

// O(n) and use O(1) data structure (i.e. character) only

function funcVersion3 ($s) {
    $i = 0;
    while (isset($s[$i]) && $s[$i] !== '') {
        if ($s[$i] === ' ') {
            $i++;
        } else {
            $j = $i;
            while (isset($s[$j]) && $s[$j] !== '' && $s[$j] !== ' ') { 
                $j++;
            }
            $k = $j;
            while ($i < $j) {
                $j--;
                // swap in next 3 lines:
                $c     = $s[$i];
                $s[$i] = $s[$j];
                $s[$j] = $c;
                $i++;
            }
            $i = $k;
        }
    }
    return $s;
}

print_r(funcVersion3('Hello World') . PHP_EOL);
print_r(funcVersion3('Cat and Dog') . PHP_EOL);
print_r(funcVersion3('Cat and Dog ') . PHP_EOL);
print_r(funcVersion3(' Cat and Dog') . PHP_EOL);
print_r(funcVersion3(' Cat and Dog ') . PHP_EOL);
print_r(funcVersion3('Cat  and Dog') . PHP_EOL);
print_r(funcVersion3('CatAndDog') . PHP_EOL);
