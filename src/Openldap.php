<?php

namespace MaximilianoRaul\OpenLdap;

use MaximilianoRaul\OpenLDAP\exception\OpenLdapExcepcion;
use yii\base\Component;


class Openldap extends Component
{

    /**
     * OpenLDAP resource
     */
    private $conn = false;

    /**
     * Server protocol. Ej: ldap://
     */
    public $protocol;

    /**
     * Server Host
     */
    public $host;

    /**
     * Server Port
     */
    public $port;

    protected function connect()
    {
        // Establecer la conexión con el servidor LDAP
        $this->conn = ldap_connect("$this->protocol://{$this->host}:{$this->port}");

        if ($this->conn === false) {
            throw new OpenLdapExcepcion('No se pudo establecer la conexión con el Servidor LDAP');
        }
    }
}
