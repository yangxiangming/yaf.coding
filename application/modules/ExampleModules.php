<?php
/**
 * Description: Solr引擎事例
 * User: yangxiangming@live.com
 * Date: 16/5/9
 * Time: 上午10:20
 */

include "SolrModules.php";

$options = array
(
    'hostname' => SOLR_SERVER_HOSTNAME,
    'login'    => SOLR_SERVER_USERNAME,
    'password' => SOLR_SERVER_PASSWORD,
    'port'     => SOLR_SERVER_PORT,
);

$client = new SolrClient($options);

$doc = new SolrInputDocument();

$doc->addField('id', 334455);
$doc->addField('cat', 'Software');
$doc->addField('cat', 'Lucene');

$updateResponse = $client->addDocument($doc);

print_r($updateResponse->getResponse());
