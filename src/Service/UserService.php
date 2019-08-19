<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

class UserService
{
    private $entityManager;
    private $serializer;
    private $jwtAuth;
    private $helpers;

    /**
     * @param EntityManagerInterface $entityManager
     * @param SerializerInterface $serializer
     * @param JwtAuth $jwtAuth
     * @param Helpers $helpers
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer,
        JwtAuth $jwtAuth,
        Helpers $helpers
    )
    {
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
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

        $this->entityManager->persist($user);
        $this->entityManager->flush();

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
        $repository = $this->entityManager->getRepository(User::class);

        $pwd = hash("sha256", $password);

        $user = $repository->findOneBy(
            array(
                'email' => $email,
                'password' => $pwd
            )
        );

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
            $repository = $this->entityManager->getRepository(User::class);
            $user = $repository->find($id);

            if($user){

                $data = json_decode($this->serializer->serialize($user, 'json'));

                $response = array(
                    "code" => 200,
                    "message" => "Correct",
                    "data" => $data,
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

        if($authCheck == true) {
            $repository = $this->entityManager->getRepository(User::class);
            $users = $repository->findAll();

            $data = json_decode($this->serializer->serialize($users, 'json'));

            $response = array(
                "code" => 200,
                "message" => "Correct",
                "data" => $data,
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
            $repository = $this->entityManager->getRepository(User::class);
            $user = $repository->find($id);

            if($user){
                $this->entityManager->remove($user);
                $this->entityManager->flush();

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
