<?php

namespace Test\Foo\Book;

use Test\SuiteTest;
use Foo\Book;

class BookTest extends SuiteTest
{
    public function testFetchRow()
    {
        $mock_request = $this->getMockBuilder('Foo\Request')
                         ->setMethods(['requireParam'])
                         ->getMock();

        $mock_request->expects($this->once())
                 ->method('requireParam')
                 ->will($this->returnValue('book_id'));

        $Book = new Book();

        $result = $Book->fetchRow($mock_request);

        $expected = 'book_id';
        $this->assertEquals($expected, $result);
    }

    public function testFetchRowDoubleMocks()
    {
        $mock_request = $this->getMockBuilder('Foo\Request')
                         ->setMethods(['requireParam'])
                         ->getMock();

        $mock_request->expects($this->once())
                 ->method('requireParam')
                 ->will($this->returnValue('book_id'));

        $mock_request->requireParam('book_id');

        $mock_book = $this->getMockBuilder('Foo\Book')
                         ->setMethods(['fetchRow'])
                         ->getMock();

        $mock_book->expects($this->once())
                 ->method('fetchRow')
                 ->will($this->returnValue('book_id'));

        $result = $mock_book->fetchRow($mock_request);

        $expected = 'book_id';
        $this->assertEquals($expected, $result);
    }
}
