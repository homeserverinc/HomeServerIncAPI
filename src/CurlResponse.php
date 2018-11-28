<?php

namespace HomeServerInc\API;

/**
 * Class to handle cUrl responses
 * 
 * @author Márcio Elias <marcioelias@gmail.com>
 * @version 1.0.0
 */
class CurlResponse {
    /**
     * Hold an array with response data from cUrl calls
     *
     * @var array
     */
    public $data = [];

    /**
     * Hold the error message of the cUrl call
     *
     * @var string
     */
    public $errorMsg = '';

    /**
     * Indicate if a cUrl call return a error state
     *
     * @var boolean
     */
    public $hasError = false;

    /**
     * Method constructor
     *
     * @param Array $data
     * @param String $errorMsg
     */
    public function __construct($data, $errorMsg) {
        $this->data = $data;
        $this->errorMsg = $errorMsg;
        $this->hasError = ($errorMsg != '');
    }

    /**
     * Return the JSON representation of him self
     *
     * @return string
     */
    public function __toString() {
        return json_encode($this);
    }
}
