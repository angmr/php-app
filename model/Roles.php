<?php 

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json; charset=utf-8');

//include "helper_files/GeneralFunctions.php";

use OpenApi\Annotations as OA;

class Roles {
    
    protected $collection;
    protected $generalFunctions;

    public function __construct($connection) {
        try {
            $this->collection = $connection->connect_to_user();
            error_log("Connection to collection user");
            $this -> generalFunctions = new GeneralFunctions();
        }
        catch (MongoDB\Driver\Exception\ConnectionTimeoutException $e) {
            error_log("Problem in connection with collection user".$e);
        }
    }
    
    public function showRoles($id) {
        if (isset($id)) {
            try {
                $result = $this->collection->findOne(
                    [ '_id'=>new MongoDB\BSON\ObjectId($id) ],
                    [
                        'projection' => [
                            'roles' => 1
                        ],
                    ]);
                if (count($result) > 0):
                    return $this-> generalFunctions -> returnValue($result, 'true');
                else:
                    return $this-> generalFunctions -> returnValue('Problem in Roles: query is empty', 'false');
                endif;
            }
            catch (MongoDB\Exception\UnsupportedException $e){
                error_log("Problem in findOne roles \n".$e);
                return $this-> generalFunctions -> returnValue('Problem in Roles: '.$e, 'false');
            }
            catch (MongoDB\Driver\Exception\InvalidArgumentException $e){
                error_log("Problem in findOne roles \n".$e);
                return $this-> generalFunctions -> returnValue('Problem in Roles: '.$e, 'false');
            }
            catch (MongoDB\Driver\Exception\RuntimeException $e){
                error_log("Problem in findOne roles \n".$e);
                return $this-> generalFunctions -> returnValue('Problem in Roles: '.$e, 'false');
            };
        } else 
            return $this-> generalFunctions -> returnValue('Problem in Roles: no id received', 'false');
    }

    public function createRoles($data) {
        $id = $data->_id;
        $permission = $data->permission;
        $authorizations = $data->authorizations;
        
        if(isset($id) && isset($permission) && isset($authorizations)) {
            try {
                $result = $this->collection->updateOne( 
                    [ '_id' => new MongoDB\BSON\ObjectId($id) ],
                    [ 
                        '$push' => [
                            'roles' => [
                                '_id' => new MongoDB\BSON\ObjectId(),
                                'app' => 'announcement',
                                'permission' => $permission,
                                'authorizations' => $authorizations
                            ]
                        ]
                    ]
                );
                if ($result->getModifiedCount()==1)
                    return $this->generalFunctions->returnValue("",'true');
                else 
                    return $this->generalFunctions->returnValue("",'false');
            }
            catch (MongoDB\Driver\Exception\InvalidArgumentException $e){
                error_log("Problem in insert roles \n".$e);
                return $this->generalFunctions->returnValue("",'false');
            }
            catch (MongoDB\Driver\Exception\BulkWriteException $e){
                error_log("Problem in insert roles \n".$e);
                return $this->generalFunctions->returnValue("",'false');
            }
            catch (MongoDB\Driver\Exception\RuntimeException $e){
                error_log("Problem in insert roles \n".$e);
                return $this->generalFunctions->returnValue("",'false');
            };
        } else 
            return $this->generalFunctions->returnValue("",'false');
    }

    
    public function deleteRoles($id, $roleid) {
        if(isset($id) && isset($roleid)) {
            try {
                $result = $this->collection->updateOne( 
                    [ '_id' => new MongoDB\BSON\ObjectId($id) ],
                    [ 
                        '$pull' => [
                            'roles' => [
                                '_id' => new MongoDB\BSON\ObjectId($roleid)
                            ]
                        ]
                    ]
                );
                if ($result->getModifiedCount()==1)
                    return $this->generalFunctions->returnValue("",'true');
                else 
                    return $this->generalFunctions->returnValue("",'false');
            }
            catch (MongoDB\Exception\UnsupportedException $e){
                error_log("Problem in delete roles \n".$e);
                return $this->generalFunctions->returnValue("",'false');
            }
            catch (MongoDB\Driver\Exception\InvalidArgumentException $e){
                error_log("Problem in delete roles \n".$e);
                return $this->generalFunctions->returnValue("",'false');
            }
            catch (MongoDB\Driver\Exception\BulkWriteException $e){
                error_log("Problem in delete roles \n".$e);
                return $this->generalFunctions->returnValue("",'false');
            }
            catch (MongoDB\Driver\Exception\RuntimeException $e){
                error_log("Problem in delete roles \n".$e);
                return $this->generalFunctions->returnValue("",'false');
            };
        } else 
            return $this->generalFunctions->returnValue("",'false');
    }

    
    public function updateRoles($data) {
        $id = $data->_id;
        $roleid = $data->roleid;
        $permission = $data->permission;
        $authorizations = $data->authorizations;

        if( isset( $id ) && isset($roleid) && isset($permission) && isset($authorizations)) {
            try {
                $result = $this->collection->updateOne( 
                    [ 
                        '_id' => new MongoDB\BSON\ObjectId($id),
                        'roles._id' => new MongoDB\BSON\ObjectId($roleid)
                    ],
                    [ '$set' => [ 
                            'roles.$.permission' => $permission,
                            'roles.$.authorizations' => $authorizations
                        ]
                    ]
                );
                if ($result->getModifiedCount()==1)
                    return $this->generalFunctions->returnValue("",'true');
                else 
                    return $this->generalFunctions->returnValue("",'false');
            }
            catch (MongoDB\Driver\Exception\InvalidArgumentException $e){
                error_log("Problem in update roles \n".$e);
                return $this->generalFunctions->returnValue("",'false');
            }
            catch (MongoDB\Driver\Exception\BulkWriteException $e){
                error_log("Problem in update roles \n".$e);
                return $this->generalFunctions->returnValue("",'false');
            }
            catch (MongoDB\Driver\Exception\RuntimeException $e){
                error_log("Problem in update roles \n".$e);
                return $this->generalFunctions->returnValue("",'false');
            };
        } else 
            return $this->generalFunctions->returnValue("",'false');    
    }
}
?>