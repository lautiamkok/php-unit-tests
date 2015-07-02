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
            array(
                'article'
            )
        );

        self::$Article = new Article(self::$PDO);
    }

    public function testFetchRow()
    {
        self::$Article->createRow(
            array(
                ':title' => 'Hello World',
                ':description' => 'Hello World',
                ':content' => 'Hello World'
            )
        );

        $result = self::$Article->fetchRow(
            array(
                ':article_id' => self::$PDO->fetchLastInsertId()
            )
        );

        $this->assertArrayHasKey('article_id', $result);

        $expected = 12; // 12 keys associate with values in the array
        $this->assertEquals($expected, count($result));
    }

    public function testFetchRows()
    {
        self::$Article->createRow(
            array(
                ':title' => 'Hello World',
                ':description' => 'Hello World',
                ':content' => 'Hello World'
            )
        );

        $result = self::$Article->fetchRows();

        $expected = 1;
        $this->assertEquals($expected, count($result));
    }

    public function testCreateRow()
    {
        $result = self::$Article->createRow(
            array(
                ':title' => 'Hello World',
                ':description' => 'Hello World',
                ':content' => 'Hello World'
            )
        );

        $this->assertTrue($result);
    }

    public function testUpdateRow()
    {
        self::$Article->createRow(
            array(
                ':title' => 'Hello World',
                ':description' => 'Hello World',
                ':content' => 'Hello World'
            )
        );

        // The params that you send in for update must be different from the existing data in the row
        // otherwise nothing is updated and you get false in the result in phpunit.
        $result = self::$Article->updateRow(
            array(
                ':title' => 'Hello World - updated',
                ':description' => 'Hello World - updated',
                ':content' => 'Hello World - updated',
                ':article_id' => self::$PDO->fetchLastInsertId()
            )
        );

        $this->assertTrue($result);
    }

    public function testDeleteRow()
    {
        self::$Article->createRow(
            array(
                ':title' => 'Hello World',
                ':description' => 'Hello World',
                ':content' => 'Hello World'
            )
        );

        $result = self::$Article->deleteRow(
            array(
                ':article_id' => self::$PDO->fetchLastInsertId()
            )
        );

        $this->assertTrue($result);
    }

    public function testRenderHelloWorld()
    {
        $expected = 'Hello World';

        $this->assertEquals($expected, self::$Article->renderHelloWorld());
    }

    public function testRenderArrayIsValidArray()
    {
        $this->assertTrue(is_array(self::$Article->returnArray()));
    }

    public function testRenderArrayHasValue()
    {
        $this->assertTrue(count(self::$Article->returnArray()) > 0);
    }

    public function testFailure()
    {
        $this->assertContains(3, array(1, 2, 3));
        $this->assertContainsOnly('string', array('1', '2', '3'));
        $this->assertGreaterThan(2, 3);
        $this->assertClassHasAttribute('foo', '\Foo\Article');
        $this->assertClassHasStaticAttribute('boo', '\Foo\Article');
        $this->assertObjectHasAttribute('foo', self::$Article);
        $this->assertInstanceOf('\Foo\Article', self::$Article);
    }
}
