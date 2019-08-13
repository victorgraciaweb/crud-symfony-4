<?php

namespace App\Controller;

use App\Service\MaquinariaService;
use SimpleXMLElement;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/maquinaria")
 */
class MaquinariaController extends AbstractController
{
    /**
     * @Route("/get-maquinarias", name="maquinaria_get_maquinarias")
     */
    public function getMaquinariasAction(Request $request)
    {
        $usernameWs = $request->get("usernameWs", null);
        $passwordWs = $request->get("passwordWs", null);
        $idCentro = $request->get("idCentro", null);

        $maquinariaService = new MaquinariaService();
        $data = $maquinariaService->getMaquinarias($usernameWs, $passwordWs, $idCentro);

        $xml = new SimpleXMLElement('<GetMaquinariasResult/>');

        foreach ($data->GetMaquinariasResult->WsDropDownList as $wsDropDownList){
            $maquinaria = $xml->addChild('WsDropDownList');
            $maquinaria->addChild('idDD', $wsDropDownList->idDD);
            $maquinaria->addChild('valueDD', $wsDropDownList->valueDD);
        }

        return new Response($xml->asXML());
    }
}
