<?php

require 'vendor/autoload.php';

\Qbhy\Express\Express::$http = new \GuzzleHttp\Client();

print_r(\Qbhy\Express\Express::query(885744925321174309));