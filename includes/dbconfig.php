<?php

require __DIR__.'/vendor/autoload.php';


use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;


// This assumes that you have placed the Firebase credentials in the same directory
// as this PHP file.
$serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/firetripdetails-firebase-adminsdk-8edre-0ea80d09fa.json');
$firebase = (new Factory)
   ->withServiceAccount($serviceAccount)
   ->withDatabaseUri('https://firetripdetails-default-rtdb.firebaseio.com/')
   ->create();
$database = $firebase->getDatabase();


?>