<?php

function test() {
try {
    throw new Exception("Ma seconde exception");
} catch (Exception $exception) {
    throw new Exception("Ma troisième exception");
    
    die($exception->getMessage());
    
}


throw new Exception("mon exception depuis une fonction");
}

try {
    test();
    echo "je continue";
} catch (Exception $exception) {
    die($exception->getMessage());
}