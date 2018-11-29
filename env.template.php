<?php

$Config = [
    'ConnectionString' => 'mysql:host=127.0.0.1;dbname=sm;charset=utf8mb4',
    'User' => 'root',
    'Password' => ''
];

$Columns = [
    'Functions' => 'pawnfunctions',
    'Constants' => 'pawnconstants',
    'Files' => 'pawnfiles'
];

$BaseURL = '/pawn-docgen/web/';
$Project = 'SourceMod';

// May as well just let this throw an exception if the user puts in the wrong credentials.
$Database = new PDO(
    $Config['ConnectionString'],
    $Config['User'],
    $Config['Password'],
    [
        PDO::ATTR_TIMEOUT => 1,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]
);

unset($Config);
