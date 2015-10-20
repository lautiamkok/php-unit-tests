<?php

interface Observable
{
    function addObserver( Observer $Observer );
    function removeObserver( Observer $Observer );
    function notifyObserver( $args );
}
