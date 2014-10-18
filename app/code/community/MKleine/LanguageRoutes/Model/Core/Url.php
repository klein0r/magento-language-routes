<?php

class MKleine_LanguageRoutes_Model_Core_Url extends Mage_Core_Model_Url
{
    /**
     * @return MKleine_LanguageRoutes_Model_Translation
     */
    protected function getTranslationModel()
    {
        return Mage::getSingleton('mk_languageroutes/translation');
    }

    public function getRouteFrontName()
    {
        return $this->getTranslationModel()->translateRouteToFront(parent::getRouteFrontName());
    }

    public function getControllerName()
    {
        return $this->getTranslationModel()->translateControllerToFront(parent::getControllerName());
    }

    public function getActionName()
    {
        return $this->getTranslationModel()->translateActionToFront(parent::getActionName());
    }
}