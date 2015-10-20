<?php

namespace Foo;

use Foo\Adapter\PdoAdapter;

class Article
{
    public $foo;
    public static $boo;

    public function __construct(PdoAdapter $PDO)
    {
        $this->PDO = $PDO;
    }

    public function fetchRow (array $params = [])
    {
        $sql = '
            SELECT *
            FROM article as a
            WHERE a.article_id = :article_id
        ';

        return $this->PDO->fetchRow($sql, $params);
    }

    public function fetchRows(array $params = [])
    {
        $sql = '
            SELECT *
            FROM article
        ';

        return $this->PDO->fetchRows($sql, $params);
    }

    public function createRow(array $params = [])
    {
        /**
         * The difference between named an unamed parameters is that
         * with unnamed parameters you'll have to take care about the order
         * in which they will be bound to the query.
         */
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

        return $this->PDO->executeSQL($sql, $params);
    }

    public function updateRow(array $params = [])
    {
        /**
         * The difference between named an unamed parameters is that
         * with unnamed parameters you'll have to take care about the order
         * in which they will be bound to the query.
         */
        $sql = '
            UPDATE article
            SET
                title = :title,
                description = :description,
                content = :content,
                updated_on = NOW()
            WHERE article_id = :article_id
        ';

        return $this->PDO->executeSQL($sql, $params);
    }

    public function deleteRow(array $params = [])
    {
        $sql = '
            DELETE FROM article
            WHERE article_id = :article_id
        ';

        return $this->PDO->executeSQL($sql, $params);
    }

    public function renderHelloWorld()
    {
        return 'Hello World';
    }

    public function returnTrue()
    {
        return true;
    }

    public function returnArray()
    {
        return ['Hello', 'World', 'PHP'];
    }
}
