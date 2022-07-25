<?php 

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json; charset=utf-8');

/**
 * @OA\Info(
 *  version="1.0",
 *  title="API for App Announcements",
 *  description="Announcements API",
 * )
 */

use OpenApi\Annotations as OA;

class Department {

    protected $collection;

    public function __construct($connection) {
        try {
            $this->collection = $connection->connect_to_department();
            error_log("Connection to collection Department");
        }
        catch (MongoDB\Driver\Exception\ConnectionTimeoutException $e) {
            error_log("Problem in connection with collection Department".$e);
        }
    }
   
    /**
     * Api specifications
     */
    public function showDepartments() {
        try {
            $result = $this->collection->find()->toArray();
            if (count($result)>0):
                return json_encode($result);
            else:
                return $this->returnValue('false');
            endif;
        }
        catch (MongoDB\Exception\UnsupportedException $e){
            error_log("Problem in find departments \n".$e);
            return $this->returnValue('false');
        }
        catch (MongoDB\Driver\Exception\InvalidArgumentException $e){
            error_log("Problem in find departments \n".$e);
            return $this->returnValue('false');
        }
        catch (MongoDB\Driver\Exception\RuntimeException $e){
            error_log("Problem in find departments \n".$e);
            return $this->returnValue('false');
        };
    }

     public function showDepartment($id) {
        if( isset( $id )) {
            try {
                $result = $this->collection->findOne([
                    '_id'=>new MongoDB\BSON\ObjectId($id)
                ]);
                if ($result):
                    $x = [
                        'success'=>true,
                        'data'=>json_encode($result)
                    ];
                    return json_encode($x);
                else:
                    return $this->returnValue('false');
                endif;
            }
            catch (MongoDB\Exception\UnsupportedException $e){
                error_log("Problem in find departments \n".$e);
                return $this->returnValue('false');
            }
            catch (MongoDB\Driver\Exception\InvalidArgumentException $e){
                error_log("Problem in find departments \n".$e);
                return $this->returnValue('false');
            }
            catch (MongoDB\Driver\Exception\RuntimeException $e){
                error_log("Problem in find departments \n".$e);
                return $this->returnValue('false');
            };
        } else 
            return $this->returnValue('false'); 
    }

    public function createDepartment($data) {
        $identifier = $data -> identifier;
        $name = $data -> name;

        if(isset($identifier) && isset($name)){
            try {
                $result = $this -> collection -> insertOne([
                    'identifier' => $identifier,
                    'name' => $name,
                    'subdepartment' => [],
                    'categories' => []
                ]);
                if ($result -> getInsertCount() == 1)
                    return $this -> returnValue("", 'true');
                else
                    return $this -> returnValue("", 'false');
            }
            catch (MongoDB\Driver\Exception\InvalidArgumentException $e){
                error_log("Problem in insert department \n".$e);
                return $this -> returnValue("", 'false');
            }
            catch (MongoDB\Driver\Exception\BulkWriteException $e){
                error_log("Problem in insert department \n".$e);
                return $this -> returnValue("", 'false');
            }
            catch (MongoDB\Driver\Exception\RuntimeException $e){
                error_log("Problem in insert department \n".$e);
                return $this -> returnValue("", 'false');
            };
        } else
            return $this -> returnValue("", 'false');
    }

    public function updateDepartment($data) {
        $id = $data -> _id;
        $indetifier = $data -> identifier;
        $name = $data ->name;
        if (isset($id) && isset($identifier) && isset($name)) {
            try {
                $result = $this -> collection -> updateOne(
                    ['_id' => new MongoDB\BSON\ObjectId($id)],
                    [ '$set' => [
                            'identifier' => $identifier,
                            'name' => $name
                        ]
                    ]
                );
                if ($result -> getModifiedCount() == 1)
                    return $this -> returnValue("", 'true');
                else
                    return $this -> returnValue("",'false');
            }
            catch (MongoDB\Driver\Exception\InvalidArgumentException $e){
                error_log("Problem in update department \n".$e);
                return $this -> returnValue("", 'false');
            }
            catch (MongoDB\Driver\Exception\BulkWriteException $e){
                error_log("Problem in update department \n".$e);
                return $this -> returnValue("", 'false');
            }
            catch (MongoDB\Driver\Exception\RuntimeException $e){
                error_log("Problem in update department \n".$e);
                return $this -> returnValue("", 'false');
            }
        }
    }

    public function deleteDepartment($id){
        if (isset ($id)) {
            try {
                $result = $this -> collection -> deleteOne([
                    '_id' => new MongoDB\BSON\ObjectId($id)
                ]);
                if ($result -> getDeletedCount() == 1)
                    return $this -> returnValue("", 'true');
                else
                    return $this -> returnValue("", 'false');
            }
            catch (MongoDB\Exception\UnsupportedException $e){
                error_log("Problem in delete department \n".$e);
                return $this -> returnValue("", 'false');
            }
            catch (MongoDB\Exception\InvalidArgumentException $e){
                error_log("Problem in delete department \n".$e);
                return $this -> returnValue("", 'false');
            }
            catch (MongoDB\Exception\BulkWriteException $e){
                error_log("Problem in delete department \n".$e);
                return $this -> returnValue("", 'false');
            }
            catch (MongoDB\Exception\RuntimeException $e){
                error_log("Problem in delete department \n".$e);
                return $this -> returnValue("", 'false');
            }
                
        }
    }

    private function returnValue($value){
        if ($value==='true')
            return json_encode(array('success' => true));
        else 
            return json_encode(array('success' => false));
    }
}
?>