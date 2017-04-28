#!/usr/bin/php7.0
<?php

require_once __DIR__ . '/vendor/autoload.php';


if (!file_exists(__DIR__ . '/config.php'))
{
  echo "Copy config.php.sample to config.php and fill in your info\n";
  exit(1);
}

$config = require __DIR__ . '/config.php';


$message = join(' ', array_slice($_SERVER['argv'], 1));
if (!$message)
{
  echo "Usage: {$_SERVER['argv'][0]} your message here\n";
  exit(1);
}


$response = lyoshenka\Curl::post('https://qpush.me/pusher/push_site/', [
  'name' => $config['name'],
  'code' => $config['code'],
  'msg' => ['text' => $message]
])->getJson();


if ($response['error'] ?? false)
{
  echo "ERROR: " . $response['error'] . "\n";
  exit(1);
}

exit(0);
