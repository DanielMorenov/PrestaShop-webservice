<?php

/**
 * @author Daniel Moreno <dev@orbitadigital.com>
 */

require_once __DIR__ . '/../../config/config.inc.php';
require_once __DIR__ . '/../../init.php';
require_once __DIR__ . '/../base.php';

class Service
{
    /**
     * Create api access
     *
     * @param int $key number of the limit to consult
     * @param int $description number of the limit to consult
     * @return int $id
     */

    public static function createApiAccess($description = null, $key = null)
    {
        Configuration::updateValue('PS_WEBSERVICE', 1);

        if ($key == null) {
            $permitedCharacteres = '123456789ABCDEFGHJKLMNPQRSTUVWXYZ123456789';
            $key = substr(str_shuffle($permitedCharacteres), 0, 32);
        }

        $apiAccess = new WebserviceKey();
        $apiAccess->key = $key;
        $apiAccess->description = $description;
        $apiAccess->save();

        return $apiAccess->id;
    }

    /**
     * Get api key with id
     *
     * @param int $id_account id api access
     * @return string $key
     */

    public static function getApiKey(int $id_account)
    {
        $apiAccess = new WebserviceKey($id_api);
        return $apiAccess->key;
    }

    /**
     * set o update permission
     *
     * @param int $id_account id api access
     * @return string $key
     */

    public static function setPermissionForAccount(int $id_account, array $permissions)
    {
        WebserviceKey::setPermissionForAccount($id_account, $permissions);
    }

    /**
     * Get data with key and options
     *
     * @param int $id_account id api access
     * @param array $options searchs options https://devdocs.prestashop.com/1.7/development/webservice/tutorials/advanced-use/additional-list-parameters/
     * @return string $key
     */

    public static function getData(string $key, array $options)
    {
        try {
            $webService = new PrestaShopWebservice('http://localhost/mitienda', $key, false);
            $xml = $webService->get($options);
        } catch (PrestaShopWebserviceException $ex) {
            return 'Error: <br />' . $ex->getMessage();
        }
        if($xml){
            $var = $options['resource'];
            $resources = $xml->$var->children();
        }
        return json_encode($resources);
    }
}
