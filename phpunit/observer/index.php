<?php

// Including global autoloader
require_once __DIR__ . '/vendor/autoload.php';

$ConcreteObservable = new ConcreteObservable();
$ConcreteObserver = new ConcreteObserver();

$ConcreteObservable->addObserver($ConcreteObserver);
$ConcreteObservable->addItem("Jack");
$ConcreteObservable->addItem("Jane");

var_dump($ConcreteObservable->getStatuses());
var_dump($ConcreteObservable->getStatus("Jack"));
