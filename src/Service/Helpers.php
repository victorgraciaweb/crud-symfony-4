<?php

namespace App\Service;

class Helpers{

    public $jwtAuth;

    /**
     * Helpers constructor.
     * @param JwtAuth $jwtAuth
     */
    public function __construct(JwtAuth $jwtAuth){
        $this->jwtAuth = $jwtAuth;
    }

    /**
     * @param string $hash
     * @param bool $getIdentity
     * @return bool|object
     */
    public function authCheck($hash, $getIdentity = false){
        $jwtAuth = $this->jwtAuth;
        $auth = false;

        if($hash != null) {
            if($getIdentity == false) {
                $checkToken = $jwtAuth->checkToken($hash);
                if ($checkToken == true){
                    $auth = true;
                }
            }else{
                $checkToken = $jwtAuth->checkToken($hash, true);
                if(is_object($checkToken)) {
                    $auth = $checkToken;
                }
            }
        }

        return $auth;
    }
}