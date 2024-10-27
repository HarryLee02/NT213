<?php namespace App\Lib;

use MongoDB\Client;

class dao  {
   private $db;
   
   public function __construct() { 
      $uri = getenv('MONGODB_URI');
      $client = new Client($uri);
      $this->db = $client->selectDatabase('sample_mflix');
   }

   public function searchUser($email , $password ){
      $collection = $this->db->selectCollection('users');
      $userInfo = [
         "email" => $email,
         "password" => hash('sha256',$password)
      ];
      $findOneResult = $collection->findOne($userInfo);
      return $findOneResult;
      
   }

   public function insertUser( $email, $username , $password ){
      $collection = $this->db->selectCollection('users');
      $userInfo = [
         "email" => $email,
         "username" => $username,
         "password" => hash('sha256',$password)
      ];
      $insertOneResult = $collection->insertOne($userInfo);
      return $insertOneResult->getInsertedId();
   }

   public function searchPost($keyword){
      $collection = $this->db->selectCollection('posts');
      $query = [
         'title' => ['$regex' => ".*$keyword.*", '$options' => 'i']
      ];
      $result = $collection->find($query,[
         'limit' => 5
      ]);
      $resultArray = [];
      foreach ($result as $document) {
         $resultArray[] = $document;
      }
      return $resultArray;
   }
}
?>