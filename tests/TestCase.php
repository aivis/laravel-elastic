<?php

namespace Aivis\LaravelElastic\Test;

use Aivis\LaravelElastic\ElasticServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Aivis\LaravelElastic\ClientInterface;

class TestCase extends OrchestraTestCase
{

    /**
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            ElasticServiceProvider::class,
        ];
    }

    /**
     * @return ClientInterface
     */
    protected function getClient()
    {
        config(['elastic.hosts' => ['localhost']]);

        return $this->app[ClientInterface::class];
    }
}