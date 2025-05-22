<?php

$minimumPhpVersion = '8.1';

// First, check if the system's linked "php" is 8+; if so, return that. This
// is the most likely, most ideal, and fastest possible case
$linkedPhpVersion = shell_exec('php -r "echo phpversion();"');

$binPath = '';
if (array_key_exists('HOME', $_SERVER)) {
    $binPath = $_SERVER['HOME'] . '\.config\herd\bin\php';
} else if (array_key_exists('HOMEPATH', $_SERVER) && array_key_exists('HOMEDRIVE', $_SERVER)) {
    $binPath = $_SERVER['HOMEDRIVE'] . $_SERVER['HOMEPATH'] . '\.config\herd\bin\php';
}

if ($binPath === '') {
    return;
}

if (version_compare($linkedPhpVersion, $minimumPhpVersion) >= 0) {
    if (file_exists($binPath . '84' . DIRECTORY_SEPARATOR . 'php.exe')) {
        echo $binPath . '84' . DIRECTORY_SEPARATOR . 'php.exe';
    } elseif (file_exists($binPath . '83' . DIRECTORY_SEPARATOR . 'php.exe')) {
        echo $binPath . '83' . DIRECTORY_SEPARATOR . 'php.exe';
    } elseif (file_exists($binPath . '82' . DIRECTORY_SEPARATOR . 'php.exe')) {
        echo $binPath . '82' . DIRECTORY_SEPARATOR . 'php.exe';
    } elseif (file_exists($binPath . '81' . DIRECTORY_SEPARATOR . 'php.exe')) {
        echo $binPath . '81' . DIRECTORY_SEPARATOR . 'php.exe';
    }

    return;
}


if (file_exists($binPath . '83' . DIRECTORY_SEPARATOR . 'php.exe')) {
    echo $binPath . '83' . DIRECTORY_SEPARATOR . 'php.exe';
    return;
}

echo $binPath . '82' . DIRECTORY_SEPARATOR . 'php.exe';
