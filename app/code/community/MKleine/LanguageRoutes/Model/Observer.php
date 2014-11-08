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
class MKleine_LanguageRoutes_Model_Observer
{
    /**
     * Cleans the cache when a translation changes
     *
     * @param $observer Varien_Event_Observer
     */
    public function languagerouteSaveAfter($observer)
    {
        Mage::helper('mk_languageroutes')->clearTranslationCache();
    }

    /**
     * Will add a canonical link to the non translated version of the url
     *
     * @param $observer Varien_Event_Observer
     */
    public function controllerActionLayoutRenderBefore($observer)
    {
        if ($routeInfo = Mage::registry('languageroute_information')) {
            if ($routeInfo->getOriginal() != $routeInfo->getInternal()) {
                /** @var $headBlock Mage_Page_Block_Html_Head */
                $headBlock = Mage::app()->getLayout()->getBlock('head');
                $headBlock->addLinkRel('canonical', Mage::getUrl($routeInfo->getInternal(), array('_notranslate' => true)));
            }
        }
    }

    /**
     * Adds translation block for current url when inline translation is enabled
     * and module has been activated
     *
     * @param $observer Varien_Event_Observer
     */
    public function controllerActionLayoutGenerateBlocksAfter($observer)
    {
        if (Mage::helper('mk_languageroutes')->isInlineTranslationEnabled()) {
            /** @var $layout Mage_Core_Model_Layout */
            $layout = $observer->getLayout();

            if ($contentBlock = $layout->getBlock('content')) {
                $translateBlock = $layout->createBlock(
                    'mk_languageroutes/translate_uri',
                    'languageroutes_inline_translate_uri'
                );

                $contentBlock->append($translateBlock);
            }
        }
    }

    /**
     * Forward the client to the translated url if configured
     *
     * @param $observer Varien_Event_Observer
     */
    public function controllerActionPredispatch($observer)
    {
        if ($redirectCode = (int)Mage::getStoreConfig('web/url/forward_to_translated')) {
            if ($redirectCode != 301) {
                $redirectCode = 302;
            }

            /** @var $controllerAction Mage_Core_Controller_Front_Action */
            $controllerAction = $observer->getControllerAction();
            $pathInfo = trim($controllerAction->getRequest()->getOriginalPathInfo(), '/');
            $translatedPathInfo = trim(str_replace(Mage::getBaseUrl(), '', Mage::getUrl($pathInfo)), '/');

            // Check if a translated version of the path exists
            if ($pathInfo != $translatedPathInfo) {
                $controllerAction->getResponse()
                    ->setRedirect(Mage::getUrl($pathInfo), $redirectCode)
                    ->sendResponse();
                exit;
            }
        }
    }
}