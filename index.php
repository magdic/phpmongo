<?php
try
{
    $connection = new Mongo('mongodb://luisc:leidgam17@ds061258.mongolab.com:61258/peoplelbees');
    $database   = $connection->selectDB('peoplelbees');
    $collection = $database->selectCollection('people');
}
catch(MongoConnectionException $e)
{
    die("Failed to connect to database ".$e->getMessage());
}
 
$cursor = $collection->find();

$collection->update(array("nombre" => "Pedro"));

echo "<h2>Show result as JSON:</h2>";
foreach($cursor as $document) {  
 //var_dump($document[name]);  
echo "<div>";
$name = json_encode($document[nombre]);
$lastname = json_encode($document[apellido]);
echo str_replace('"', '', $name).' '.str_replace('"', '', $lastname);
// echo ;
echo "</div>"; 
} 
 
?>