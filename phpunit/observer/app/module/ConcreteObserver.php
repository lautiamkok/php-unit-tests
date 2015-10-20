<?php

class ConcreteObserver implements Observer
{
    private $status = null;

    public function onChanged(Observable $Observable, $args)
    {
        $this->setStatus();
        $Observable->setStatus($this, $args);
    }

    public function setStatus()
    {
        return $this->status = 'OK';
    }

    public function getStatus()
    {
        return $this->status;
    }
}
