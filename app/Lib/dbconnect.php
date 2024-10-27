<?php 
namespace App\Lib;
use Dotenv\Dotenv;
use MongoDB\Client;


class dbconnect{
    public function connect(){
        $uri = getenv('MONGODB_URI');
        $client = new Client($uri);
        $db = $client->selectDatabase('sample_mflix');
        return $db;
    }
}