<?php

namespace Test;

use PHPUnit_Framework_TestCase;
use Foo\Adapter\PdoAdapter;

class SuiteTest extends PHPUnit_Framework_TestCase
{
    protected static $PDO;

    /**
     * Share the db fixture between tests, instead of
     * overwriting the PHPUnit_Framework_TestCase constructor.
     */
    public static function setUpBeforeClass()
    {
        self::$PDO = new PdoAdapter();
        self::$PDO->connect();
    }

    /**
     * Disconnect from the database after the last test of the test case.
     */
    public static function tearDownAfterClass()
    {
        self::$PDO = NULL;
    }

    /**
     * Truncate db tables before each test case.
     */
    protected function truncateTables($tables)
    {
        foreach ($tables as $table) {
            self::$PDO->truncateTable($table);
        }
    }

    /**
     * DO NOT DELETE, REQUIRED TO AVOID FAILURE OF NO TESTS IN FILE
     * PHPUnit is ignoring the exclude in the phpunit.xml config file
     */
    public function testDummyTest()
    {
    }
}
