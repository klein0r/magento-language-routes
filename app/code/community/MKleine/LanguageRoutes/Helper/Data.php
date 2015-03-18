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
class MKleine_LanguageRoutes_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * @param $url string
     */
    public function isUriTranslatable($url)
    {
        return ($this->isTranslationEnabled() && strpos($url, '.html') === false);
    }

    /**
     * @return bool Check if extension is enabled
     */
    public function isTranslationEnabled()
    {
        return (bool)Mage::getStoreConfig('web/url/enable_route_translation');
    }

    /**
     * @return bool
     */
    public function isInlineTranslationEnabled()
    {
        /** @var $translate Mage_Core_Model_Translate_Inline */
        $translate = Mage::getSingleton('core/translate_inline');
        return $translate->isAllowed() && $this->isTranslationEnabled();
    }

    /**
     * Clears the cache of all translated routes
     */
    public function clearTranslationCache()
    {
        /** @var $translationModel MKleine_LanguageRoutes_Model_Translation */
        $translationModel = Mage::getSingleton('mk_languageroutes/translation');
        $translationModel->clearCache();
    }

    /**
     * @param $model MKleine_LanguageRoutes_Model_Languageroute
     */
    public function insertOrUpdateTranslation($model)
    {
        /** @var $collection MKleine_LanguageRoutes_Model_Resource_Languageroute_Collection */
        $collection = Mage::getModel('mk_languageroutes/languageroute')
            ->getCollection()
            ->addFieldToFilter('store_id', $model->getStoreId())
            ->addFieldToFilter('type_id', $model->getTypeId())
            ->addFieldToFilter('value', $model->getValue());

        /** @var $existingItem MKleine_LanguageRoutes_Model_Languageroute */
        if ($existingItem = $collection->getFirstItem()) {
            $existingItem->addData($model->getData());

            if ($existingItem->getTranslation()) {
                $existingItem->save();
            }
            else {
                $existingItem->delete();
            }
        }
        else if ($model->getTranslation()) {
            $model->save();
        }
    }

    /**
     * Will create a new router to collect all standard routes
     *
     * @return array
     */
    public function getAvailableRoutes()
    {
        $router = new MKleine_LanguageRoutes_Controller_Varien_Router_Standard();
        $router->collectRoutes(Mage_Core_Model_App_Area::AREA_FRONTEND, 'standard');
        return $router->getFrontNames();
    }

    /**
     * Collects all controllers which can be used for frontend
     *
     * @return array
     */
    public function getAvailableControllers()
    {
        $allModules = Mage::getConfig()->getNode('modules')->children();

        $controllers = array();
        foreach ($allModules as $moduleName => $moduleSettings) {
            if (Mage::helper('core')->isModuleEnabled($moduleName)) {
                $controllerDir = Mage::getModuleDir('controllers', $moduleName);
                if (is_dir($controllerDir)) {
                    foreach (new DirectoryIterator($controllerDir) as $file) {
                        if ($file->isFile() && strpos($file->getPath() . DS . $file->getFilename(), 'Adminhtml') === false) {
                            $controllers[] = strtolower(str_replace('Controller.php', '', $file->getFilename()));
                        }
                    }
                }
            }
        }

        return array_unique($controllers);
    }

    public function getAvailableActions()
    {
        // TODO: Try to get a list of available options
        return array();
    }
}