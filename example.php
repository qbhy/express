<?php

require 'vendor/autoload.php';

$express = new \Qbhy\Express\Express('secret');

print_r($express->query('courier num'));
