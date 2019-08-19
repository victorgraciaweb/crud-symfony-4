<?php

namespace App\Controller;

use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    private $userService;

    /**
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Create new user
     * @Route("/create", name="user_create", methods="POST")
     * @param Request $request
     * @return JsonResponse
     */
    public function createAction(Request $request)
    {
        $json = $request->get("json", null);
        $params = json_decode($json);

        $name = (isset($params->name)) ? $params->name : null;
        $surname = (isset($params->surname)) ? $params->surname : null;
        $email = (isset($params->email)) ? $params->email : null;
        $password = (isset($params->password)) ? $params->password : null;

        $response = $this->userService->create($name, $surname, $email, $password);

        return $response;
    }

    /**
     * Check login user
     * @Route("/login", name="user_login", methods="GET")
     * @param Request $request
     * @return JsonResponse
     */
    public function loginAction(Request $request)
    {
        $json = $request->get("json", null);
        $params = json_decode($json);

        $email = (isset($params->email)) ? $params->email : null;
        $password = (isset($params->password)) ? $params->password : null;
        $gethash = (isset($params->gethash)) ? $params->gethash : null;

        $response = $this->userService->login($email, $password, $gethash);

        return $response;
    }

    /**
     * Get user by ID
     * @Route("/get", name="user_get_user", methods="GET")
     * @param Request $request
     * @return JsonResponse
     */
    public function getAction(Request $request)
    {
        $hash = $request->get("authorization", null);
        $json = $request->get("json", null);

        $params = json_decode($json);

        $id = (isset($params->id)) ? $params->id : null;

        $response = $this->userService->get($hash, $id);

        return $response;
    }

    /**
     * Get all users
     * @Route("/get-all", name="user_get_all", methods="GET")
     * @param Request $request
     * @return JsonResponse
     */
    public function getAllAction(Request $request)
    {
        $hash = $request->get("authorization", null);

        $response = $this->userService->getAll($hash);

        return $response;
    }

    /**
     * Delete user
     * @Route("/delete", name="user_delete", methods="DELETE")
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteAction(Request $request)
    {
        $hash = $request->get("authorization", null);
        $json = $request->get("json", null);

        $params = json_decode($json);

        $id = (isset($params->id)) ? $params->id : null;

        $response = $this->userService->delete($hash, $id);

        return $response;
    }
}
