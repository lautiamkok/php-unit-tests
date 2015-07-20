<?php
// @ref: http://docs.mockery.io/en/latest/getting_started/simple_example.html
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

    public function tearDown()
    {
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
