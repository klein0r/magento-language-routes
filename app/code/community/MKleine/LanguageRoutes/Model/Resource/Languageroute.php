<?php

class MKleine_LanguageRoutes_Model_Resource_Languageroute
    extends Mage_Core_Model_Resource_Db_Abstract
{
    public function _construct()
    {
        $this->_init('mk_languageroutes/languageroute', 'languageroute_id');
    }
}