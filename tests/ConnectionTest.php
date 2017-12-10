<?php

namespace Aivis\LaravelElastic\Test;

class ConnectionTest extends TestCase
{

    /**
     * @return void
     */
    public function testGetClusterHealth()
    {
        $client = $this->getClient();

        $data = $client->getClusterHealth();

        $this->assertArrayHasKey('cluster_name', $data);
        $this->assertArrayHasKey('status', $data);
        $this->assertArrayHasKey('number_of_nodes', $data);
        $this->assertArrayHasKey('initializing_shards', $data);
        $this->assertArrayHasKey('unassigned_shards', $data);
    }

    /**
     * @return void
     */
    public function testGetNodeStats()
    {
        $client = $this->getClient();

        $data = $client->getNodeStats();

        $this->assertArrayHasKey(0, $data);
        $this->assertArrayHasKey('stats', $data[0]);
        $this->assertArrayHasKey('jvm', $data[0]['stats']);
        $this->assertArrayHasKey('heap_used_in_bytes', $data[0]['stats']['jvm']);
    }
}