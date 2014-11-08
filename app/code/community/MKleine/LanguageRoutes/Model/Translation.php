<?php
/**
 * Copyright (c) 2014 Matthias Kleine
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@mkleine.de so we can send you a copy immediately.
 *
 * @category    MKleine
 * @package     MKleine_LanguageRoutes
 * @copyright   Copyright (c) 2014 Matthias Kleine (http://mkleine.de)
 * @license     http://opensource.org/licenses/MIT MIT
 */

/**
 * Class MKleine_LanguageRoutes_Model_Translation
 *
 * @method setRequest
 * @method getRequest
 */
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

    public function getTranslatedPath()
    {
        /** @var $request Zend_Controller_Request_Http */
        if ($request = $this->getRequest()) {
            $pathInfo = explode('/', $request->getPathInfo(), 5);

            // Route
            if (isset($pathInfo[1])) {
                $pathInfo[1] = $this->translateRouteToMage($pathInfo[1]);
            }

            // Controller
            if (isset($pathInfo[2])) {
                $pathInfo[2] = $this->translateControllerToMage($pathInfo[2]);
            }

            // Action
            if (isset($pathInfo[3])) {
                $pathInfo[3] = $this->translateActionToMage($pathInfo[3]);
            }

            return join('/', $pathInfo);
        }

        return false;
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
            ->addFieldToFilter('type_id', $typeId)
            ->addFieldToFilter('is_active', 1);
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