<?php

// Including global autoloader
require_once __DIR__ . '/vendor/autoload.php';

$PdoAdapter = new Foo\Adapter\PdoAdapter();
$PdoAdapter->connect();

$Article = new Foo\Article($PdoAdapter);

// Echo string.
echo $Article->renderHelloWorld();

// Get one.
$result = $Article->fetchRow(array(
    ':article_id' => 11
));

print('fetch one: ');
var_dump($result);

// Get all.
$result = $Article->fetchRows(array());

print('fetch all: ');
var_dump(count($result));
var_dump($result);

// Create one.
$result = $Article->createRow(
    [
        ':title' => 'Hello World',
        ':description' => 'Hello World',
        ':content' => 'Hello World'
    ]
);

print('create: ');
var_dump($result);

$article_id = $PdoAdapter->fetchLastInsertId();

// Update one.
$result = $Article->updateRow(
    [
        ':title' => 'Hello World - updated',
        ':description' => 'Hello World - updated',
        ':content' => 'Hello World - updated',
        ':article_id' => $article_id
    ]
);

print('update: ');
var_dump($result);

// Delete one.
$result = $Article->deleteRow(
    [
        ':article_id' => $article_id
    ]
);

print('delete: ');
var_dump($result);
