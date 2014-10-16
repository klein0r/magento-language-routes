<?php

class MKleine_LanguageRoutes_Model_Core_Url extends Mage_Core_Model_Url
{
    /**
     * @return MKleine_LanguageRoutes_Helper_Data
     */
    protected function getHelper()
    {
        return Mage::helper('mk_languageroutes');
    }

    public function getRouteFrontName()
    {
        return $this->getHelper()->translateRouteToFront(parent::getRouteFrontName());
    }

    public function getControllerName()
    {
        return $this->getHelper()->translateControllerToFront(parent::getControllerName());
    }

    public function getActionName()
    {
        return $this->getHelper()->translateActionToFront(parent::getActionName());
    }
}