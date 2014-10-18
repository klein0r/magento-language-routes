<?php

class MKleine_LanguageRoutes_Model_Config_Source_Routetypes
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array(
                'value' => MKleine_LanguageRoutes_Model_Languageroute::LANGUAGEROUTE_TYPE_ROUTER,
                'label' => Mage::helper('mk_languageroutes')->__('Route')
            ),
            array(
                'value' => MKleine_LanguageRoutes_Model_Languageroute::LANGUAGEROUTE_TYPE_CONTROLLER,
                'label' => Mage::helper('mk_languageroutes')->__('Controller')
            ),
            array(
                'value' => MKleine_LanguageRoutes_Model_Languageroute::LANGUAGEROUTE_TYPE_ACTION,
                'label' => Mage::helper('mk_languageroutes')->__('Action')
            ),
        );
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        return array(
            MKleine_LanguageRoutes_Model_Languageroute::LANGUAGEROUTE_TYPE_ROUTER => Mage::helper('mk_languageroutes')->__('Route'),
            MKleine_LanguageRoutes_Model_Languageroute::LANGUAGEROUTE_TYPE_CONTROLLER => Mage::helper('mk_languageroutes')->__('Controller'),
            MKleine_LanguageRoutes_Model_Languageroute::LANGUAGEROUTE_TYPE_ACTION => Mage::helper('mk_languageroutes')->__('Action'),
        );
    }
}