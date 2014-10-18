<?php

class MKleine_LanguageRoutes_Model_Translation extends Mage_Core_Model_Abstract
{
    const LANGUAGEROUTE_CACHE_TAG = 'languageroute';

    public function getStoreId()
    {
        if (!$this->hasData('store_id')) {
            $this->setData('store_id', $storeId = Mage::app()->getStore()->getId());
        }
        return $this->getData('store_id');
    }

    public function translateRouteToMage($route)
    {
        return $this->translateToMage(
            $route,
            MKleine_LanguageRoutes_Model_Languageroute::LANGUAGEROUTE_TYPE_ROUTER
        );
    }

    public function translateRouteToFront($route)
    {
        return $this->translateToFront(
            $route,
            MKleine_LanguageRoutes_Model_Languageroute::LANGUAGEROUTE_TYPE_ROUTER
        );
    }

    public function translateControllerToMage($controller)
    {
        return $this->translateToMage(
            $controller,
            MKleine_LanguageRoutes_Model_Languageroute::LANGUAGEROUTE_TYPE_CONTROLLER
        );
    }

    public function translateControllerToFront($controller)
    {
        return $this->translateToFront(
            $controller,
            MKleine_LanguageRoutes_Model_Languageroute::LANGUAGEROUTE_TYPE_CONTROLLER
        );
    }

    public function translateActionToMage($action)
    {
        return $this->translateToMage(
            $action,
            MKleine_LanguageRoutes_Model_Languageroute::LANGUAGEROUTE_TYPE_ACTION
        );
    }

    public function translateActionToFront($action)
    {
        return $this->translateToFront(
            $action,
            MKleine_LanguageRoutes_Model_Languageroute::LANGUAGEROUTE_TYPE_ACTION
        );
    }

    protected function translateToFront($value, $typeId)
    {
        /** @var $collection MKleine_LanguageRoutes_Model_Resource_Languageroute_Collection */
        $collection = $this->getRouteCollection($typeId)
            ->addFieldToFilter('value', $value);

        $cacheKey = sprintf('language_route_front_%d_%d_%s', $this->getStoreId(), $typeId, $value);
        return $this->getValueOfCollection('translation', $collection, $value, $cacheKey);
    }

    protected function translateToMage($translation, $typeId)
    {
        $collection = $this->getRouteCollection($typeId)
            ->addFieldToFilter('translation', $translation);

        $cacheKey = sprintf('language_route_mage_%d_%d_%s', $this->getStoreId(), $typeId, $translation);
        return $this->getValueOfCollection('value', $collection, $translation, $cacheKey);
    }

    /**
     * @return MKleine_LanguageRoutes_Model_Resource_Languageroute_Collection
     */
    protected function getRouteCollection($typeId)
    {
        return Mage::getModel('mk_languageroutes/languageroute')->getCollection()
            ->addFieldToFilter('store_id', $this->getStoreId())
            ->addFieldToFilter('type_id', $typeId);
    }

    protected function getValueOfCollection($value, $collection, $fallback, $cacheKey)
    {
        /* @var $cache Varien_Cache_Core */
        $cache = Mage::app()->getCache();

        if ($cache && $cache->test($cacheKey)) {
            return $cache->load($cacheKey);
        }

        if ($collection->getSize() > 0) {
            $firstItem = $collection->getFirstItem();
            $return = $firstItem->getData($value);

            if ($cache) {
                $cache->save($return, $cacheKey, array(self::LANGUAGEROUTE_CACHE_TAG));
            }

            return $return;
        }

        return $fallback;
    }

    public function clearCache()
    {
        /* @var $cache Varien_Cache_Core */
        $cache = Mage::app()->getCache();
        if ($cache) {
            $cache->clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG, array(self::LANGUAGEROUTE_CACHE_TAG));
        }
    }
}