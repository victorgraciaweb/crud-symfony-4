<?php

namespace App\Controller;

use App\Service\ChecklistService;
use App\Service\MaquinariaService;
use SimpleXMLElement;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/checklist")
 */
class ChecklistController extends AbstractController
{
    /**
     * @Route("/get-last-checklist-maquinaria", name="checklist_get_last_checklist_maquinaria")
     */
    public function getLastCheckListMaquinariaAction(Request $request)
    {
        $usernameWs = $request->get("usernameWs", null);
        $passwordWs = $request->get("passwordWs", null);
        $idMaquinaria = $request->get("idMaquinaria", null);
        $tipoChecklist = $request->get("tipoChecklist", null);
        $username = $request->get("username", null);

        $checklistService = new ChecklistService();
        $data = $checklistService->getLastCheckListMaquinaria($usernameWs, $passwordWs, $idMaquinaria, $tipoChecklist, $username);

        $xml = new SimpleXMLElement('<GetLastCheckListMaquinariaResponse/>');

        $xml->addChild('AuxError', $data->GetLastCheckListMaquinariaResult->AuxError);
        $xml->addChild('MessageError', $data->GetLastCheckListMaquinariaResult->MessageError);
        $xml->addChild('result', $data->GetLastCheckListMaquinariaResult->result);
        $xml->addChild('resultId', $data->GetLastCheckListMaquinariaResult->resultId);

        return new Response($xml->asXML());
    }

    /**
     * @Route("/get-checklist-open", name="checklist_get_checklist_open")
     */
    public function getChecklistOpenAction(Request $request)
    {
        $usernameWs = $request->get("usernameWs", null);
        $passwordWs = $request->get("passwordWs", null);
        $idMaquinaria = $request->get("idMaquinaria", null);
        $tipoChecklist = $request->get("tipoChecklist", null);
        $idOr = $request->get("idOr", null);

        $checklistService = new ChecklistService();
        $data = $checklistService->getLastCheckListMaquinariaunfinished($usernameWs, $passwordWs, $idMaquinaria, $tipoChecklist, $idOr);

        $xml = new SimpleXMLElement('<GetLastCheckListMaquinariaunfinishedResult/>');

        //Comprobamos si existe un Checklist sin finalizar y creamos uno o devolvemos el abierto
        if($data->GetLastCheckListMaquinariaResult->MessageError == ""){

            $xml->addChild('AuxError', $data->GetLastCheckListMaquinariaResult->AuxError);
            //
            //
            //
            //

        }else{

            //Creamos un checklist vacío al no existir ninguno abierto
            $xml->addChild('MessageError', "");
            //
            //
            //
        }

        return new Response($xml->asXML());
    }
}





