<?php

namespace App\Controller;

use App\Service\OperativaService;
use SimpleXMLElement;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/operativa")
 */
class OperativaController extends AbstractController
{
    /**
     * @Route("/get-operativas", name="operativa_get_operativas")
     */
    public function getOperativasAction(Request $request)
    {
        $usernameWs = $request->get("usernameWs", null);
        $passwordWs = $request->get("passwordWs", null);
        $dtFecha = date('Y-m-d');
        $username = $request->get("username", null);
        $idMaquinaria = $request->get("idMaquinaria", null);

        $operativaService = new OperativaService();
        $data = $operativaService->getOperativasByDate($usernameWs, $passwordWs, $dtFecha, $username, $idMaquinaria);

        $xml = new SimpleXMLElement('<GetListAllOperativasByDateResult/>');

        foreach ($data->GetListAllOperativasByDateResult->wsOperativas as $wsOperativas){
            $operativa = $xml->addChild('wsOperativas');
            $operativa->addChild('IdOperativa', $wsOperativas->IdOperativa);
            $operativa->addChild('Descripcion', $wsOperativas->Descripcion);
        }

        return new Response($xml->asXML());
    }

    /**
     * @Route("/get-operativas-operario", name="operativa_get_operativas_operario")
     */
    public function getOperativasOperarioAction(Request $request)
    {
        $usernameWs = $request->get("usernameWs", null);
        $passwordWs = $request->get("passwordWs", null);
        $idOperativa = $request->get("idOperativa", null);
        $username = $request->get("username", null);
        $idMaquinaria = $request->get("idMaquinaria", null);

        $operativaService = new OperativaService();
        $data = $operativaService->checkServicioOperativaVsOperario($usernameWs, $passwordWs, $idOperativa, $username, $idMaquinaria);

        $xml = new SimpleXMLElement('<CheckServicioOperativaVsOperarioResult/>');

        $xml->addChild('AuxError', $data->CheckServicioOperativaVsOperarioResult->AuxError);
        $xml->addChild('MessageError', $data->CheckServicioOperativaVsOperarioResult->MessageError);
        $xml->addChild('result', $data->CheckServicioOperativaVsOperarioResult->result);
        $xml->addChild('resultId', $data->CheckServicioOperativaVsOperarioResult->resultId);

        return new Response($xml->asXML());
    }
}
