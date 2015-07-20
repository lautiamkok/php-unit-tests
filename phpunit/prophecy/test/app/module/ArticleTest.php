<?php

namespace Test\Foo\Article;

use Test\SuiteTest;
use Foo\Article;
use Prophecy\Prophet;

class ArticleTest extends SuiteTest
{
    protected static $Article;

    /**
     * Call this template method before each test method is run.
     */
    protected function setUp()
    {
        $this->prophet = new Prophet;
    }

    public function testFetchRow()
    {
        // Create a prophecy for the PdoAdapter class.
        // or:
        // $mock_pdo = $this->prophesize('Foo\Adapter\PdoAdapter');
        $mock_pdo = $this->prophet->prophesize('Foo\Adapter\PdoAdapter');

        $Article = new Article($mock_pdo->reveal());

        $sql = '
            SELECT *
            FROM article as a
            WHERE a.article_id = :article_id
        ';

        $mock_pdo->fetchRow($sql,[':article_id' => 1])
                 ->willReturn(
                        [
                            'title' => 'Hello',
                            'content' => 'World'
                        ]

                    )
                 ->shouldBeCalled(1);

        $result = $Article->fetchRow([':article_id' => 1]);

        $expected = 2;
        $this->assertEquals($expected, count($result));
    }

    public function testCreateRow()
    {
        $mock_pdo = $this->prophet->prophesize('Foo\Adapter\PdoAdapter');

        $Article = new Article($mock_pdo->reveal());

        $sql = '
            INSERT INTO article (
                title,
                description,
                content,
                created_on
           )VALUES(
                :title,
                :description,
                :content,
                NOW()
           )
        ';

        $params = [
                    ':title' => 'Hello World',
                    ':description' => 'Hello World',
                    ':content' => 'Hello World'
                  ];

        $mock_pdo->executeSQL($sql,$params)
                 ->willReturn(true)
                 ->shouldBeCalled(1);

        $result = $Article->createRow(
                                [
                                    ':title' => 'Hello World',
                                    ':description' => 'Hello World',
                                    ':content' => 'Hello World'
                                ]
                            );

        $expected = true;
        $this->assertEquals($expected, $result);
    }
}
