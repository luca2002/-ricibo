<pre><?php

$manager = new MongoDB\Driver\Manager('mongodb://127.0.0.1:27017');

print_r($manager->executeCommand('test', new MongoDB\Driver\Command(['ping' => 1])));