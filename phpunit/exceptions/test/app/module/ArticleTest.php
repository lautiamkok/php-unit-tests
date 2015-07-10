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

    // @expectedException annotation to test whether an exception is thrown inside the tested code.
    /**
     * @expectedException InvalidArgumentException
     */
    public function testException()
    {
        throw new \InvalidArgumentException();
    }

    // you can use
    // @expectedExceptionMessage, @expectedExceptionMessageRegExp and @expectedExceptionCode
    // in combination with @expectedException to test the exception message and exception code
    /**
     * @expectedException        InvalidArgumentException
     * @expectedExceptionMessage Right Message
     */
    public function testExceptionHasRightMessage()
    {
        throw new \InvalidArgumentException('Right Message', 10);
    }

    public function testException2()
    {
        $this->setExpectedException('InvalidArgumentException');
        throw new \InvalidArgumentException();
    }

    public function testExceptionHasRightMessage2()
    {
        $this->setExpectedException(
          'InvalidArgumentException', 'Right Message'
        );
        throw new \InvalidArgumentException('Right Message', 10);
    }

    public function testExceptionHasRightCode()
    {
        $this->setExpectedException(
          'InvalidArgumentException', 'Right Message', 20
        );
        throw new \InvalidArgumentException('The Right Message', 20);
    }
}
