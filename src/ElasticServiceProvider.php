<?php

namespace Aivis\LaravelElastic;

use Illuminate\Support\ServiceProvider;
use Elasticsearch\ClientBuilder;

class ElasticServiceProvider extends ServiceProvider
{

    /**
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ClientInterface::class, function ()
        {
            $logPath = storage_path('/logs/elasticsearch-' . date('Y-m-d') . '.log');
            $hosts = $this->app['config']->get('elastic.hosts', []);

            $logger = ClientBuilder::defaultLogger($logPath);
            $client = ClientBuilder::create()->setHosts($hosts)->setLogger($logger)->build();

            return new Client($client);
        });
    }
}