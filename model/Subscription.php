<?php 

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json; charset=utf-8');

use OpenApi\Annotations as OA;

class Subscription {

    protected $collection;
    protected $generalFunctions;

    public function __construct($connection) {
        try {
            $this->collection = $connection->connect_to_user();
            error_log("Connection to collection User");
        }
        catch (MongoDB\Driver\Exception\ConnectionTimeoutException $e) {
            error_log("Problem in connection with collection User".$e);
        }
    }
    
    
    public function showSubscription($id) {
        if (isset($id)) {
            try {
                $result = $this->collection->findOne(
                    [ '_id'=>new MongoDB\BSON\ObjectId($id) ],
                    [
                        'projection' => [
                            'subscription' => 1
                        ],
                    ]);
                return $result;
            }
            catch (MongoDB\Exception\UnsupportedException $e){
                error_log("Problem in findOne subscription \n".$e);
            }
            catch (MongoDB\Driver\Exception\InvalidArgumentException $e){
                error_log("Problem in findOne subscription \n".$e);
            }
            catch (MongoDB\Driver\Exception\RuntimeException $e){
                error_log("Problem in findOne subscription \n".$e);
            };
        } else 
            return $this->generalFunctions->returnValue('false'); 
    }

    
    public function createSubscription($data) {
        $id = $data->_id;
        $subscription = $data->subscription_list;
        
        if( isset( $id ) && isset($subscription) ) {
            try {
                $result = $this->collection->updateOne( 
                    [ '_id' => new MongoDB\BSON\ObjectId($id) ],
                    [ '$set' => [   
                        'subscription_list' => $subscription 
                        ]
                    ]
                );
                if ($result->getModifiedCount()==1)
                    return $this->generalFunctions->returnValue("",'true');
                else 
                    return $this->generalFunctions->returnValue("",'false');
            }
            catch (MongoDB\Driver\Exception\InvalidArgumentException $e){
                error_log("Problem in insert subscription \n".$e);
                return $this->generalFunctions->returnValue("",'false');
            }
            catch (MongoDB\Driver\Exception\BulkWriteException $e){
                error_log("Problem in insert subscription \n".$e);
                return $this->generalFunctions->returnValue("",'false');
            }
            catch (MongoDB\Driver\Exception\RuntimeException $e){
                error_log("Problem in insert subscription \n".$e);
                return $this->generalFunctions->returnValue("",'false');
            };
        } else 
            return $this->generalFunctions->returnValue("",'false');
    }
}
?>