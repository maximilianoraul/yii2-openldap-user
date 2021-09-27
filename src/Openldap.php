<?php

namespace MaximilianoRaul\OpenLdap;

use MaximilianoRaul\OpenLdap\exception\OpenLdapExcepcion;
use yii\base\Component;


class Openldap extends Component
{
    const SEARCH_ATTR = ['dn', 'cn', 'sn', 'givenName'];
    const NAME_ATTR = ['cn'];

    /**
     * OpenLDAP resource
     */
    private $conn = false;

    /**
     * Server protocol. Ej: ldap
     */
    public $protocol;

    /**
     * Server Host. Ej: ldap.example.com
     */
    public $host;

    /**
     * Server Port. Ej: 389
     */
    public $port;

    /**
     * Ldap Version. Ej: 3
     */
    public $ldapVersion;

    /**
     * Base DN for search. Ej: dc=example,dc=com
     */
    public $baseDn;

    /**
     * Establece una conexión con el servidor OpenLDAP
     * @return void Recurso de la conexión
     */
    protected function getConnection()
    {
        // Establecer la conexión con el servidor LDAP
        if ($this->conn === false) {
            $this->conn = ldap_connect("$this->protocol://{$this->host}:{$this->port}");
        }

        if ($this->conn === false) {
            throw new OpenLdapExcepcion('No se pudo establecer la conexión con el Servidor LDAP');
        } else {
            // Establecer la version del Servidor LDAP
            ldap_set_option($this->conn, LDAP_OPT_PROTOCOL_VERSION, $this->ldapVersion);
        }
    }

    /**
     * Busca el nombre de un usuario
     * @return string
     */
    public function searchUser(string $user): string
    {
        $conn = $this->getConnection();

        $result = ldap_search($conn, $this->baseDn, "(uid={$user})", self::SEARCH_ATTR);
        $entries = ldap_get_entries($conn, $result);

        if ($entries["count"] > 0) {
            // Si hay resultados en la búsqueda
            if (isset($entries[0]['cn'])) {
                // Nombre del Usuario
                return $entries[0]['cn'][0];
            } else {
                // El atributo no está definido para el usuario
                return "Atributo no disponible ({'cn'})";
            }
        } else {
            // Si no hay resultados en la búsqueda, retornar error
            throw new OpenLdapExcepcion('Usuario desconocido');
        }
    }

    /**
     * Valida la contraseña de un usuario
     * @return bool
     */
    public function validatePassword($user, $pass): bool
    {
        $conn = $this->getConnection();
        return ldap_bind($conn, "uid={$user},{$this->baseDn}", $pass);
    }
}
