<?php

namespace Aivis\LaravelElastic;

use Elasticsearch\Client as ElasticsearchClient;

class Client implements ClientInterface
{

    /**
     * @var ElasticsearchClient
     */
    protected $elasticsearchClient;

    /**
     * @param ElasticsearchClient $elasticsearchClient
     */
    public function __construct(ElasticsearchClient $elasticsearchClient)
    {
        $this->elasticsearchClient = $elasticsearchClient;
    }

    /**
     * @return ElasticsearchClient
     */
    public function getElasticsearchClient()
    {
        return $this->elasticsearchClient;
    }

    /**
     * @return array
     */
    public function getClusterHealth()
    {
        $stats = $this->getElasticsearchClient()->cluster()->health();

        return [
            'cluster_name' => array_get($stats, 'cluster_name'),
            'status' => array_get($stats, 'status'),
            'number_of_nodes' => array_get($stats, 'number_of_nodes'),
            'initializing_shards' => array_get($stats, 'initializing_shards'),
            'unassigned_shards' => array_get($stats, 'unassigned_shards'),
        ];
    }

    /**
     * @return array
     */
    public function getNodeStats()
    {
        $stats = $this->getElasticsearchClient()->nodes()->stats();
        $nodes = array_get($stats, 'nodes', []);
        $data = [];

        foreach ($nodes as $nodeId => $node)
        {
            $data[] = [
                'id' => $nodeId,
                'name' => array_get($node, 'name'),
                'stats' => [
                    'indices' => [
                        'docs' => [
                            'count' => array_get($node, 'indices.docs.count'),
                        ],
                        'store' => [
                            'size_in_bytes' => array_get($node, 'indices.store.size_in_bytes'),
                            'throttle_time_in_millis' => array_get($node, 'indices.store.throttle_time_in_millis'),
                        ],
                        'indexing' => [
                            'index_total' => array_get($node, 'indices.indexing.index_total'),
                            'index_time_in_millis' => array_get($node, 'indices.indexing.index_time_in_millis'),
                            'index_current' => array_get($node, 'indices.indexing.index_current'),
                            'delete_current' => array_get($node, 'indices.indexing.delete_current'),
                        ],
                        'search' => [
                            'open_contexts' => array_get($node, 'indices.search.open_contexts'),
                            'query_total' => array_get($node, 'indices.search.query_total'),
                            'query_time_in_millis' => array_get($node, 'indices.search.query_time_in_millis'),
                            'fetch_total' => array_get($node, 'indices.search.fetch_total'),
                            'fetch_time_in_millis' => array_get($node, 'indices.search.fetch_time_in_millis'),
                        ],
                        'merges' => [
                            'current' => array_get($node, 'indices.merges.current'),
                            'current_docs' => array_get($node, 'indices.merges.current_docs'),
                            'current_size_in_bytes' => array_get($node, 'indices.merges.current_size_in_bytes'),
                        ],
                        'query_cache' => [
                            'memory_size_in_bytes' => array_get($node, 'indices.query_cache.memory_size_in_bytes'),
                        ],
                        'fielddata' => [
                            'memory_size_in_bytes' => array_get($node, 'indices.fielddata.memory_size_in_bytes'),
                        ],
                        'segments' => [
                            'count' => array_get($node, 'indices.segments.count'),
                            'memory_in_bytes' => array_get($node, 'indices.segments.memory_in_bytes'),
                            'terms_memory_in_bytes' => array_get($node, 'indices.segments.terms_memory_in_bytes'),
                            'stored_fields_memory_in_bytes' => array_get($node, 'indices.segments.stored_fields_memory_in_bytes'),
                            'term_vectors_memory_in_bytes' => array_get($node, 'indices.segments.term_vectors_memory_in_bytes'),
                            'norms_memory_in_bytes' => array_get($node, 'indices.segments.norms_memory_in_bytes'),
                            'points_memory_in_bytes' => array_get($node, 'indices.segments.points_memory_in_bytes'),
                            'doc_values_memory_in_bytes' => array_get($node, 'indices.segments.doc_values_memory_in_bytes'),
                            'index_writer_memory_in_bytes' => array_get($node, 'indices.segments.index_writer_memory_in_bytes'),
                            'version_map_memory_in_bytes' => array_get($node, 'indices.segments.version_map_memory_in_bytes'),
                            'fixed_bit_set_memory_in_bytes' => array_get($node, 'indices.segments.fixed_bit_set_memory_in_bytes'),
                        ],
                    ],
                    'request_cache' => [
                        'memory_size_in_bytes' => array_get($node, 'indices.request_cache.memory_size_in_bytes'),
                    ],
                    'os' => [
                        'cpu_percent' => array_get($node, 'os.cpu.percent'),
                        'mem_total' => array_get($node, 'os.mem.total_in_bytes'),
                        'mem_free_in_bytes' => array_get($node, 'os.mem.free_in_bytes'),
                        'mem_used_in_bytes' => array_get($node, 'os.mem.used_in_bytes'),
                        'swap_total' => array_get($node, 'os.swap.total_in_bytes'),
                        'swap_free_in_bytes' => array_get($node, 'os.swap.free_in_bytes'),
                        'swap_used_in_bytes' => array_get($node, 'os.swap.used_in_bytes'),
                    ],
                    'jvm' => [
                        'heap_used_in_bytes' => array_get($node, 'jvm.mem.heap_used_in_bytes'),
                        'heap_used_percent' => array_get($node, 'jvm.mem.heap_used_percent'),
                        'heap_committed_in_bytes' => array_get($node, 'jvm.mem.heap_committed_in_bytes'),
                        'heap_max_in_bytes' => array_get($node, 'jvm.mem.heap_max_in_bytes'),
                        'non_heap_used_in_bytes' => array_get($node, 'jvm.mem.non_heap_used_in_bytes'),
                        'non_heap_committed_in_bytes' => array_get($node, 'jvm.mem.non_heap_committed_in_bytes'),
                    ],
                    'fs' => [
                        'total_in_bytes' => array_get($node, 'fs.total.total_in_bytes'),
                        'free_in_bytes' => array_get($node, 'fs.total.free_in_bytes'),
                    ]
                ]
            ];

            return $data;
        }
    }
}