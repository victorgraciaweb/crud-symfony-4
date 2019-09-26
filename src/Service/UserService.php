<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserService
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var JwtAuth
     */
    private $jwtAuth;

    /**
     * @var Helpers
     */
    private $helpers;

    /**
     * @param UserRepository $userRepository
     * @param JwtAuth $jwtAuth
     * @param Helpers $helpers
     */
    public function __construct(
        UserRepository $userRepository,
        JwtAuth $jwtAuth,
        Helpers $helpers
    )
    {
        $this->userRepository = $userRepository;
        $this->jwtAuth = $jwtAuth;
        $this->helpers = $helpers;
    }

    /**
     * Create new user
     * @param string $name
     * @param string $surname
     * @param string $email
     * @param string $password
     * @return JsonResponse
     */
    public function create($name, $surname , $email, $password)
    {
        $pwd = hash("sha256", $password);

        $user = new User();
        $user->setName($name);
        $user->setSurname($surname);
        $user->setEmail($email);
        $user->setPassword($pwd);

        $this->userRepository->save($user);

        $response = array(
            "code" => 200,
            "message" => "User create"
        );

        return new JsonResponse($response);
    }

    /**
     * Login service
     * @param string $email
     * @param string $password
     * @param string $gethash
     * @return JsonResponse
     */
    public function login($email, $password, $gethash)
    {
        $pwd = hash("sha256", $password);

        $user = new User();
        $user->setEmail($email);
        $user->setPassword($pwd);

        $user = $this->userRepository->findOneBy($user);

        if($user){
            if($gethash == null) {
                $response = $this->jwtAuth->signup($user);
            }else{
                $response = $this->jwtAuth->signup($user, true);
            }

        }else{
            $response = array(
                "code" => 404,
                "message" => "User or password incorrect"
            );
        }

        return new JsonResponse($response);
    }

    /**
     * Get User
     * @param string $hash
     * @param int $id
     * @return JsonResponse
     */
    public function get($hash, $id)
    {
        $authCheck = $this->helpers->authCheck($hash);

        if($authCheck == true) {
            $user = $this->userRepository->find($id);

            if($user){

                $response = array(
                    "code" => 200,
                    "message" => "Correct",
                    "data" => $user,
                );

            }else{
                $response = array(
                    "code" => 404,
                    "message" => "User not found"
                );
            }

        }else{
            $response = array(
                "code" => 403,
                "message" => "Token not valid"
            );
        }

        return new JsonResponse($response);
    }

    /**
     * Get all users
     * @param string $hash
     * @return JsonResponse
     */
    public function getAll($hash)
    {
        $authCheck = $this->helpers->authCheck($hash);

        if($authCheck != true) {
            $users = $this->userRepository->findAll();

            $response = array(
                "code" => 200,
                "message" => "Correct",
                "data" => $users,
            );

        }else{
            $response = array(
                "code" => 403,
                "message" => "Token not valid"
            );
        }

        return new JsonResponse($response);
    }

    /**
     * Delete user
     * @param string $hash
     * @param int $id
     * @return JsonResponse
     */
    public function delete($hash, $id)
    {
        $authCheck = $this->helpers->authCheck($hash);

        if($authCheck == true) {
            $user = $this->userRepository->find($id);

            if($user){
                $this->userRepository->delete($user);

                $response = array(
                    "code" => 200,
                    "message" => "Deleted Successfully"
                );

            }else{
                $response = array(
                    "code" => 404,
                    "message" => "User not found"
                );
            }

        }else{
            $response = array(
                "code" => 403,
                "message" => "Token not valid"
            );
        }

        return new JsonResponse($response);
    }
}
