<?php

use Eaglewatch\Search\Instagram;

require_once __DIR__ . '/../vendor/autoload.php';


$instagram = new Instagram();

$id = '71573758753';
$ids = [71573758753];
$shortCode = 'Ckv3mrWq7W';
$hashtag = 'catsofinstagram';
$query = 'lofi';
$location = 'seoul';
$user = 'corneliusbisi';

$response = $instagram->getUserByUsername($user);

// test id 
// 71573758753

// test username
// stanley_nwogu_


print_r($response);