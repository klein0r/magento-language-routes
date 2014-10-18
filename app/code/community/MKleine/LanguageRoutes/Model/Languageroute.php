<?php

class MKleine_LanguageRoutes_Model_Languageroute
    extends Mage_Core_Model_Abstract
{
    const LANGUAGEROUTE_TYPE_ROUTER = 1;
    const LANGUAGEROUTE_TYPE_CONTROLLER = 2;
    const LANGUAGEROUTE_TYPE_ACTION = 3;

    protected $_eventPrefix = 'languageroute';

    public function _construct()
    {
        parent::_construct();
        $this->_init('mk_languageroutes/languageroute');
    }

    /**
     * Get languageroute created at date timestamp
     *
     * @return int|null
     */
    public function getCreatedAtTimestamp()
    {
        $date = $this->getCreatedAt();
        if ($date) {
            return Varien_Date::toTimestamp($date);
        }
        return null;
    }
}