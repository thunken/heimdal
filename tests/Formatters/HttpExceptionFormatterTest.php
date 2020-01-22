<?php

use Thunken\Heimdal\Formatters\ExceptionFormatter;
use Thunken\Heimdal\Formatters\HttpExceptionFormatter;
use Thunken\Heimdal\ResponseFactory;
use Orchestra\Testbench\TestCase;
use Symfony\Component\HttpKernel\Exception\HttpException;

class HttpExceptionFormatterTest extends TestCase
{

    public function testHttpCodeIsset()
    {
        $config = getConfigStub();
        $exception = new HttpException('401', 'Error');
        $response = ResponseFactory::make($exception);

        $formatter = new HttpExceptionFormatter($config, true);
        $formatter->format($response, $exception, []);

        $this->assertTrue($formatter instanceof ExceptionFormatter);
        $this->assertEquals(401, $response->getStatusCode());
    }
}
