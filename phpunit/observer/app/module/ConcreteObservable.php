<?php

class ConcreteObservable implements Observable
{
    private $Observers = [];
    private $statuses = [];

    public function addItem($name)
    {
        $this->notifyObserver($name);
    }
    public function addObserver(Observer $Observer)
    {
        $this->Observers[] = $Observer;
    }

    public function notifyObserver($options)
    {
        foreach($this->Observers as $Observer) {
            $Observer->onChanged($this, $options);
        }
    }

    function removeObserver(Observer $Observer)
    {
        foreach($this->Observers as $observerKey => $observerValue) {
            if ($observerValue === $Observer) {
                unset($this->Observers[ $observerKey ]);
            }
        }
    }

    public function setStatus(Observer $Observer, $args)
    {
        $this->statuses[$args] = $Observer;
    }

    public function getStatus($args)
    {
        return $this->statuses[$args]->getStatus();
    }

    public function getStatuses()
    {
        return $this->statuses;
    }
}
