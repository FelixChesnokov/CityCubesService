<?php 

function dd($var, $isDie = true)
{
    if($isDie) {
        die(var_dump($var));
    } else {
        var_dump($var);
    }
}