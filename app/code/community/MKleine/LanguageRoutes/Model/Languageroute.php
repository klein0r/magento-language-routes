<?php

class MKleine_LanguageRoutes_Model_Languageroute
    extends Mage_Core_Model_Abstract
{
    /**
     * Name of the event object
     *
     * @var string
     */
    protected $_eventObject = 'languageroute';

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