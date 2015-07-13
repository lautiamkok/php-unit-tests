<?php

namespace Foo;

use Foo\Adapter\PdoAdapter;
use Foo\ArticleException;

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
        try {

            if(count($params) === 0) {
                throw new ArticleException('Fetch required id is missing.');
            }

            if(count($params) > 0 && !is_numeric($params[':article_id'])) {
                throw new ArticleException('Fetch required id must be numeric.');
            }

            $sql = '
                SELECT *
                FROM article as a
                WHERE a.article_id = :article_id
            ';

            return $this->PDO->fetchRow($sql, $params);
        } catch (ArticleException $e) {

            return $e->getMessage();
        }
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
        try {

            if(count($params) === 0) {
                throw new ArticleException('Create parameters must not be empty: title, description, content.');
            }

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
        } catch (ArticleException $e) {

            return $e->getMessage();
        }
    }

    public function updateRow(array $params = [])
    {
        try {

            if(count($params) === 0) {
                throw new ArticleException('Update parameters must not be empty: title, description, content.');
            }

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
         } catch (ArticleException $e) {

            return $e->getMessage();
        }
    }

    public function deleteRow(array $params = [])
    {
        try {

            if(count($params) === 0) {
                throw new ArticleException('Delete required id is missing.');
            }

            $sql = '
                DELETE FROM article
                WHERE article_id = :article_id
            ';

            return $this->PDO->executeSQL($sql, $params);
        } catch (ArticleException $e) {

            return $e->getMessage();
        }
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
