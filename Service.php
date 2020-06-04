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

}
