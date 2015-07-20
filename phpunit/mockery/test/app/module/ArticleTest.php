<?php

namespace Test\Foo\Article;

use Test\SuiteTest;
use Foo\Article;
use Mockery as m;

class ArticleTest extends SuiteTest
{
    protected static $Article;

    /**
     * Call this template method before each test method is run.
     */
    protected function setUp()
    {
    }

    /**
     * Between each test, you need to clean up Mockery
     * so that any expectations from the previous test do not interfere with the current test.
     * To do that, we can simply create a tearDown() method:
    */
    public function tearDown()
    {
        // The static method close() cleans up the Mockery container used by the current test,
        // and runs any verification tasks needed for your expectations.
        m::close();
    }

    public function testFetchRow()
    {
        $mock_pdo = m::mock('Foo\Adapter\PdoAdapter');

        $sql = '
            SELECT *
            FROM article as a
            WHERE a.article_id = :article_id
        ';

        $mock_pdo->shouldReceive('fetchRow')
                 ->times(1)
                 ->with($sql,[':article_id' => 1])
                 ->andReturn([
                    'title' => 'Hello',
                    'content' => 'World'
                  ]);

        $Article = new Article($mock_pdo);

        $result = $Article->fetchRow([':article_id' => 1]);

        $expected = 2;
        $this->assertEquals($expected, count($result));
    }

    public function testFetchRows()
    {
        $mock_pdo = m::mock('Foo\Adapter\PdoAdapter');

        $mock_rows = [
            ['title' => 'First headline'],
            ['title' => 'Second headline']
        ];

        $mock_pdo->shouldReceive('fetchRows')
                 ->andReturnUsing(function () use ($mock_rows) {
                        return $mock_rows;
                  });

        $Article = new Article($mock_pdo);
        $result = $Article->fetchRows();

        $expected = 2;
        $this->assertEquals($expected, count($result));
    }

    public function testFetchTitles()
    {
        $mock_pdo = m::mock('Foo\Adapter\PdoAdapter');

        $sql = '
            SELECT *
            FROM article
        ';

        $mock_rows = [
            ['title' => 'First headline'],
            ['title' => 'Second headline']
        ];

        $mock_pdo->shouldReceive('fetchRows')
                 ->with($sql, array())
                 ->andReturn($mock_rows);

        $Article = new Article($mock_pdo);
        $result = $Article->fetchTitles(array());

        $expected = ['FIRST HEADLINE', 'SECOND HEADLINE'];
        $this->assertEquals($expected, $result);
    }

    public function testCreateRow()
    {
        $mock_pdo = m::mock('Foo\Adapter\PdoAdapter');

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

        $mock_pdo->shouldReceive('executeSQL')
                 ->times(1)
                 ->with($sql,
                        [
                            ':title' => 'Hello World',
                            ':description' => 'Hello World',
                            ':content' => 'Hello World'
                        ]
                    )
                 ->andReturn(true);

        $Article = new Article($mock_pdo);

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

    public function testUpdateRow()
    {
        $mock_pdo = m::mock('Foo\Adapter\PdoAdapter');

        $sql = '
            UPDATE article
            SET
                title = :title,
                description = :description,
                content = :content,
                updated_on = NOW()
            WHERE article_id = :article_id
        ';

        $mock_pdo->shouldReceive('executeSQL')
                 ->times(1)
                 ->with($sql,
                        [
                            ':title' => 'Hello World - updated',
                            ':description' => 'Hello World - updated',
                            ':content' => 'Hello World - updated',
                            ':article_id' => 1
                        ]
                    )
                 ->andReturn(true);

        $Article = new Article($mock_pdo);

        $result = $Article->updateRow(
                                [
                                    ':title' => 'Hello World - updated',
                                    ':description' => 'Hello World - updated',
                                    ':content' => 'Hello World - updated',
                                    ':article_id' => 1
                                ]
                            );

        $expected = true;
        $this->assertEquals($expected, $result);
    }

    public function testDeleteRow()
    {
        $mock_pdo = m::mock('Foo\Adapter\PdoAdapter');

        $sql = '
            DELETE FROM article
            WHERE article_id = :article_id
        ';

        $mock_pdo->shouldReceive('executeSQL')
                 ->times(1)
                 ->with($sql,
                        [
                            ':article_id' => 1
                        ]
                    )
                 ->andReturn(true);

        $Article = new Article($mock_pdo);

        $result = $Article->deleteRow(
                                [
                                    ':article_id' => 1
                                ]
                            );

        $expected = true;
        $this->assertEquals($expected, $result);
    }
}
