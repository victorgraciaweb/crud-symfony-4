<?php

namespace App\Controller;

use App\Service\UsuarioService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/usuario")
 */
class UsuarioController extends AbstractController
{
    /**
     * @Route("/login", name="usuario_login")
     */
    public function loginAction(Request $request)
    {
        $json = $request->get("json", null);

        if($json != null) {
            $params = json_decode($json);

            $username = (isset($params->username)) ? $params->username : null;
            $password = (isset($params->password)) ? $params->password : null;
            $idPdaCentro = (isset($params->idPdaCentro)) ? $params->idPdaCentro : null;

            if($username != null && $password != null && $idPdaCentro != null) {

                $usuarioService = new UsuarioService();
                $data = $usuarioService->login($username, $password, $idPdaCentro);

            }else{
                $data = array(
                    "status" => "error",
                    "code" => 400,
                    "msg" => "Es necesario enviar todos los datos solicitados en el formulario"
                );
            }

        }else{
            $data = array(
                "status" => "error",
                "code" => 400,
                "msg" => "Es necesario el envio de datos"
            );
        }

        return new JsonResponse($data);
    }
}
