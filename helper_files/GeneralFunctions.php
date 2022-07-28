<?php

class GeneralFunctions {

    public function returnValue($result, $value){
        if ($value)
            return json_encode(array(
                'data' => json_encode($result),
                'success' => true
                )
            );
        else 
            return json_encode(array(
                'data' => json_encode($result),
                'success' => false
            ));
    }
}

?>