<?php

class MKleine_LanguageRoutes_Model_Resource_Languageroute_Collection
    extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('mk_languageroutes/languageroute');
    }
}