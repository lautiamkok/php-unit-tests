# PHPUnit

1. Install composer.

2. Add `C:\php\composer` to the Path in environment variable.

3. Install Global PHPUnit via Composer,

    `composer global require "phpunit/phpunit=4.8.*"`

    Make sure you have ~/.composer/vendor/bin/ in your path. For instance,

    `C:\Users\[username]\AppData\Roaming\Composer\vendor\bin;`

    ref: https://phpunit.de/manual/current/en/installation.html#installation.composer

4. Install PHPUnit via Composer - create a file `composer.json`,

    ```
    {
        "autoload": {
            "psr-4": {
                "Foo\\": [
                    "app/module/"
                ],
                "YourCustomNamespace\\": [
                    "source/local/",
                    "module/local/source/"
                ]
            }
        },
        "require-dev": {
            "phpunit/phpunit": "4.8.*"
        }
    }
    ```

5. Run composer update in your CMD.

6. Create a xml file,

    ```
    <?xml version="1.0" encoding="UTF-8"?>
    <phpunit
        backupGlobals="false"
        backupStaticAttributes="false"
        bootstrap="/vendor/autoload.php"
        colors="true"
        convertErrorsToExceptions="true"
        convertNoticesToExceptions="true"
        convertWarningsToExceptions="true"
        forceCoversAnnotation="false"
        processIsolation="false"
        stopOnFailure="false"
        verbose="false"
        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:noNamespaceSchemaLocation="http://schema.phpunit.de/3.7/phpunit.xsd">
        <testsuites>
          <testsuite name="My Test Suite">
            <directory>test/</directory>
            <file>test/path/to/ArticleTest.php</file>
            <exclude>/path/to/exclude</exclude>
          </testsuite>
        </testsuites>
    </phpunit>
    ```

    ref:

        * https://phpunit.de/manual/current/en/appendixes.configuration.html#appendixes.configuration.testsuites
        * https://phpunit.de/manual/current/en/appendixes.configuration.html#appendixes.configuration.phpunit

7. To run the test, run this line in your CMD,

    `phpunit test/app/module/ArticleTest.`

or just

    `phpunit` (if you have set the file path specifically in your xml file)

## References:

    * https://www.youtube.com/watch?v=-9YVcssCACI
    * https://phpunit.de/manual/current/en/index.html
    * http://php-and-symfony.matthiasnoback.nl/2014/07/test-doubles/
    * https://thephp.cc/news/2015/02/phpunit-4-5-and-prophecy
