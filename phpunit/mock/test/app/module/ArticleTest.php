<?php

namespace Test\Foo\Article;

use Test\SuiteTest;
use Foo\Article;

class ArticleTest extends SuiteTest
{
    protected static $Article;

    /**
     * Call this template method before each test method is run.
     */
    protected function setUp()
    {
        $this->truncateTables(
            [
                'article'
            ]
        );

        self::$Article = new Article(self::$PDO);
    }

    public function testStub()
    {
        // Create a stub for the SomeClass class.
        $stub = $this->getMockBuilder('Foo\Article')
                     //->setConstructorArgs(array(self::$PDO))
                     // or:
                     // You can mock the class that you are testing and specify the method that you want to mock.
                     ->setMethods(array('doOneThing'))
                     ->disableOriginalConstructor()
                     ->getMock();

        // Configure the stub.
        $stub->expects($this->once())
             ->method('doOneThing')
             //->willReturn('foo'); // or ->will($this->returnValue($value));
             ->will($this->returnValue('foo'));

        // Calling $stub->doSomething() will now return
        // 'foo'.
        $this->assertEquals('foo', $stub->doOneThing());
    }

    public function testFetchRow()
    {
        $mock_pdo = $this->getMockBuilder('Foo\Adapter\PdoAdapter')
                         ->setMethods(array('executeSQL', 'fetchRow', 'fetchLastInsertId'))
                         ->getMock();

        $sql = '
            SELECT *
            FROM article as a
            WHERE a.article_id = :article_id
        ';

        $mock_pdo->expects($this->once())
                 ->method('fetchRow')
                 ->with($sql,array(':article_id' => 1))
                 ->will($this->returnValue(
                        array(
                            'title' => 'Hello',
                            'content' => 'World'
                        )
                    ));

        $Article = new Article($mock_pdo);

        $result = $Article->fetchRow(array(':article_id' => 1));

        $expected = 2;
        $this->assertEquals($expected, count($result));
    }
}
