<?php

interface Observer
{
    function onChanged( Observable $Observable, $args );
}
