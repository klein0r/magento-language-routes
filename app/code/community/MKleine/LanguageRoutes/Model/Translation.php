<?php

class MKleine_LanguageRoutes_Model_Translation extends Mage_Core_Model_Abstract
{
    public function getStoreId()
    {
        if (!$this->hasData('store_id')) {
            $this->setData('store_id', $storeId = Mage::app()->getStore()->getId());
        }
        return $this->getData('store_id');
    }

    public function translateRouteToMage($route)
    {
        return $this->translateToMage($route, MKleine_LanguageRoutes_Model_Languageroute::LANGUAGEROUTE_TYPE_ROUTER);
    }

    public function translateRouteToFront($route)
    {
        return $this->translateToFront($route, MKleine_LanguageRoutes_Model_Languageroute::LANGUAGEROUTE_TYPE_ROUTER);
    }

    public function translateControllerToMage($controller)
    {
        return $this->translateToMage($controller, MKleine_LanguageRoutes_Model_Languageroute::LANGUAGEROUTE_TYPE_CONTROLLER);
    }

    public function translateControllerToFront($controller)
    {
        return $this->translateToFront($controller, MKleine_LanguageRoutes_Model_Languageroute::LANGUAGEROUTE_TYPE_CONTROLLER);
    }

    public function translateActionToMage($action)
    {
        return $this->translateToMage($action, MKleine_LanguageRoutes_Model_Languageroute::LANGUAGEROUTE_TYPE_ACTION);
    }

    public function translateActionToFront($action)
    {
        return $this->translateToFront($action, MKleine_LanguageRoutes_Model_Languageroute::LANGUAGEROUTE_TYPE_ACTION);
    }

    protected function translateToFront($value, $typeId)
    {
        /** @var $collection MKleine_LanguageRoutes_Model_Resource_Languageroute_Collection */
        $collection = Mage::getModel('mk_languageroutes/languageroute')->getCollection()
            ->addFieldToFilter('store_id', $this->getStoreId())
            ->addFieldToFilter('type_id', $typeId)
            ->addFieldToFilter('value', $value);

        if ($collection->getSize() > 0) {
            $firstItem = $collection->getFirstItem();
            return $firstItem->getTranslation();
        }

        return $value;
    }

    protected function translateToMage($translation, $typeId)
    {
        /** @var $collection MKleine_LanguageRoutes_Model_Resource_Languageroute_Collection */
        $collection = Mage::getModel('mk_languageroutes/languageroute')->getCollection()
            ->addFieldToFilter('store_id', $this->getStoreId())
            ->addFieldToFilter('type_id', $typeId)
            ->addFieldToFilter('translation', $translation);

        if ($collection->getSize() > 0) {
            $firstItem = $collection->getFirstItem();
            return $firstItem->getValue();
        }

        // this is a problem...
        // nothing for mage found = 404
        return $translation;
    }
}