<?php

namespace App\Service;
use SoapClient;

class UsuarioService
{
    public function login($username, $password, $idPdaCentro)
    {
        $soapClient = new SoapClient('http://intranet.logicmove.es/WCFHmtest/HMovementsServiceService.svc?WSDL');
        $params = array('userName' => $username, 'Password' => $password, 'idPdaCentro' => $idPdaCentro);
        $reponse = $soapClient->__call('ValidataionUserHM', array($params));

        return $reponse;
    }
}
