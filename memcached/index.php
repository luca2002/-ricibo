<?php

error_reporting(E_ALL|E_STRICT);

ini_set('display_errors', true);

$mem = new memcache();

$mem->addServer("127.0.0.1", 11211);

$result = $mem->get("Test");

if ($result) {

echo $result;

} else {

echo "Test key not found, adding key";

$mem->set("Test", "I found a match, memcache is working") or die("Nothing Saved...");

}

?>