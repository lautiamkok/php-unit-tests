<?php

namespace Test\Observer;

use Test\SuiteTest;
use ConcreteObservable;
use ConcreteObserver;

class ObserverTest extends SuiteTest
{
    private $subject = null;
    private $observer = null;

    /**
     * Call this template method before each test method is run.
     */
    protected function setUp()
    {
        $this->subject = new ConcreteObservable();
        $this->observer = new ConcreteObserver();
    }

    protected function tearDown()
    {
        $this->subject = null;
        $this->observer = null;
    }

    public function testMockObserver()
    {
        // Create a Mock Object for the Observer class
        // mocking only the update() method.
        $observer = $this->getMockBuilder('ConcreteObserver')
                         ->setMethods(['onChanged'])
                         ->getMock();

        // Create a Subject object.
        $subject = new ConcreteObservable;

        // Set up the expectation for the onChanged() method
        // to be called only once and with the string 'something'
        // as its parameter.
        $observer->expects($this->exactly(2))
                 ->method('onChanged')
                 ->with($subject, 'Jane')
                 //->will($this->returnValue('Jane'));
                 ->will($this->returnSelf()); // the observer usually returns itself. @ref: http://magento.stackexchange.com/questions/11458/unit-testing-observers-in-magento

        // Attach the mocked observer object to the Subject object.
        $subject->addObserver($observer);

        // $this->assertEquals('Jane', $observer->onChanged($subject, 'Jane'));
        $this->assertEquals($observer, $observer->onChanged($subject, 'Jane'));

        // Call the addItem() method on the $subject object
        // which we expect to call the mocked Observer object's
        // onChanged() method with the string 'something'.
        $subject->addItem('Jane');
    }

    public function testActualSingleObserver()
    {
        // Attach the mocked observer object to the Subject object.
        $this->subject->addObserver($this->observer);

        // Call the addItem() method on the $subject object
        // which we expect to call the mocked Observer object's
        // onChanged() method with the string 'something'.
        $this->subject->addItem('Jane');

        // Check the status of the observer.
        $this->assertEquals('OK', $this->observer->getStatus());
        $this->assertEquals('OK', $this->subject->getStatus('Jane'));
    }

    public function testActualMultipleObservers()
    {
        // Attach the mocked observer object to the Subject object.
        $this->subject->addObserver($this->observer);

        // Call the addItem() method on the $subject object
        // which we expect to call the mocked Observer object's
        // onChanged() method with the string 'something'.
        $this->subject->addItem('Jane');
        $this->subject->addItem('Jack');

        // Check the status of the observer.
        $this->assertEquals('OK', $this->subject->getStatus('Jane'));
        $this->assertEquals('OK', $this->subject->getStatus('Jack'));

        $this->assertEquals(2, count($this->subject->getStatuses()));
    }
}
