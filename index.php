<?php

require_once __DIR__ . '/vendor/autoload.php';

use Task\User;

// Creating a class instance
$user = new User(1,'Александр','Пушкин','1799-06-06',0,'Минск');

// Date formatting in age (Full years)
$user->formatting('age');

// Converting sex from binary to textual system

$a = $user->formatting('gender');

// Formatting age and gender
// $user->formatting('');

// Delete user for id
// $user->delete();

// Array for convenient output of class properties
$array = [
    'id'        =>'Индификатор',
    'firstName' => 'Имя',
    'lastName'  => 'Фамилия',
    'birthdate' => 'Дата рождения',
    'fullAge'   => 'Полных лет',
    'gender'    => 'Пол',
    'city'      => 'Город',
];

// Data output for performance check
foreach($array as $k => $v){
    echo "[{$v}: {$user->$k}] ";
}
