<?php

namespace Aivis\LaravelElastic;

use Elasticsearch\Client as ElasticsearchClient;

interface ClientInterface
{

    /**
     * @return ElasticsearchClient
     */
    public function getElasticsearchClient();

    /**
     * @return array
     */
    public function getClusterHealth();

    /**
     * @return array
     */
    public function getNodeStats();
}