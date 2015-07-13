<?php

namespace Test\Foo\Article;

use Test\SuiteTest;
use Foo\Article;
use Foo\ArticleException;

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

    public function testCreateRowFailsWithEmptyParameters()
    {
        // Some code that is supposed to throw ExceptionOne
        $result = self::$Article->createRow();

        $error = 'Create parameters must not be empty: title, description, content.';
        $this->setExpectedException('Foo\ArticleException', $error);

        throw new ArticleException($result);
    }

    public function testFetchRowFailsWithInvalidParameter()
    {
        // Some code that is supposed to throw ExceptionOne
        $result = self::$Article->fetchRow(
            [
                ':article_id' => 'H'
            ]
        );

        $error = 'Fetch required id must be numeric.';
        $this->setExpectedException('Foo\ArticleException', $error);

        throw new ArticleException($result);
    }
}
