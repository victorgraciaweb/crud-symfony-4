<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Firebase\JWT\JWT;

class JwtAuth
{
    private $entityManager;
    private $key;

    /**
     * JwtAuth constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->key = getenv("JWT_SECRET");
    }

    /**
     * Create new Token with user details
     * @param $user
     * @param null $getHash
     * @return array
     */
    public function signup($user, $getHash = NULL)
    {
        $token = array(
            "sub"=>$user->getId(),
            "email"=>$user->getEmail(),
            "iat"=> time(),
            "exp"=>time() + (7 * 24 * 60 * 60),
        );

        $jwt = JWT::encode($token, $this->key, 'HS256');
        $decoded = JWT::decode($jwt, $this->key, array('HS256'));

        if($getHash != null) {
            $data = array(
                "token"=>$jwt,
            );
        }else{
            $data = array(
                "token"=>$decoded,
            );
        }

        return $data;
    }

    /**
     * @param $jwt
     * @param bool $getIdentity
     * @return bool|object
     */
    public function checkToken($jwt, $getIdentity = false)
    {
        $auth = false;

        try{
            $decoded = JWT::decode($jwt, $this->key, array('HS256'));
        }catch (\UnexpectedValueException $e){
            $auth = false;
        }catch (\DomainException $e){
            $auth = false;
        }

        if(isset($decoded->sub)) {
            $auth = true;
        }else{
            $auth = false;
        }

        if($getIdentity == true){
            return $decoded;
        }else{
            return $auth;
        }
    }
}