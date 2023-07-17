<?php
 
namespace App\Libraries;
/*
require('D:\xampp\php\car-rental\vendor\autoload.php');

use Aws\SecretsManager\SecretsManagerClient;
use Aws\Exception\AwsException;
use Aws\Sts\StsClient;
use Aws\Credentials\CredentialProvider;
use Aws\Credentials\Credentials;*/

class DatabaseConnector {
    
    private $client;
    private $database;

    function __construct() {

     /*
        $role_arn='arn:aws:iam::056405774272:role/SecretsManagerRole';
        $region="us-west-2";

        $stsClient = new StsClient([

            'version' => 'latest',

            'region' => $region

        ]);
       
        $credentials = new Credentials('AKIAQ2IQLZ7ACILDGB7L','ivhYT/xyWaCfZxk2u6W1zM6al/dxZ5ZbAJgKJkZB');

        $client = new SecretsManagerClient([
            'version' => 'latest',
            'region' => $region,
            'credentials' => $credentials
            
        ]);
        
        $secretName = 'example_secret_2';
        var_dump($secretName);

        try {

            // Retrieve the secret value from Secrets Manager

            $result = $client->getSecretValue([
                'SecretId' => $secretName,

            ]);

            // Access the secret value

            if (isset($result['SecretString'])) {

                $secretValue = $result['SecretString'];

            } else {

                // Handle binary secrets
                $secretValue = base64_decode($result['SecretBinary']);

            }


        } catch (AwsException $e) {

            // Handle any errors that occurred

            echo $e->getMessage();

        }

 
        $cred = json_decode($secretValue);
        $uri = $cred->uri;
        echo $uri;
        echo "Yayy";
        $database = $cred->dbname;
        echo $database;
*/
        $uri = 'mongodb+srv://chan:heythere12@cluster0.qckg31o.mongodb.net/';
        $database = 'test_db';
        if (empty($uri) || empty($database)) {
            show_error('You need to declare ATLAS_URI and DATABASE in your .env file!');
        }

        try {
            $this->client = new \MongoDB\Client($uri);
        } catch(MongoDB\Driver\Exception\MongoConnectionException $ex) {
            show_error('Couldn\'t connect to database: ' . $ex->getMessage(), 500);
        }

        try {
            $this->database = $this->client->selectDatabase($database);
        } catch(MongoDB\Driver\Exception\RuntimeException $ex) {
            show_error('Error while fetching database with name: ' . $database . $ex->getMessage(), 500);
        }
    }

    function getDatabase() {
        return $this->database;
    }
}
