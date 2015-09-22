<?php

namespace Test\Foo\Curl;

use Test\SuiteTest;

class CurlTest extends SuiteTest
{
    /**
     * Call this template method before each test method is run.
     */
    protected function setUp()
    {
        //
    }

    public function testFetch()
    {
        // Create a stub for the SomeClass class.
        $stub = $this->getMockBuilder('Foo\Curl')
                     ->setMethods(['fetch'])
                     ->disableOriginalConstructor()
                     ->getMock();

        // Configure the stub.
        $stub->expects($this->once())
             ->method('fetch')
             ->will($this->returnValue('text/html; charset=utf-8'));

        $this->assertEquals('text/html; charset=utf-8', $stub->fetch());
    }
}
