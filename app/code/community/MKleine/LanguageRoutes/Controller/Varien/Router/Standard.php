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
class MKleine_LanguageRoutes_Controller_Varien_Router_Standard
    extends Mage_Core_Controller_Varien_Router_Standard
{
    public function collectRoutes($configArea, $useRouterName)
    {
        // Collect all routes from standard router
        parent::collectRoutes($configArea, 'standard');
    }

    /**
     * Match the request
     *
     * @param Zend_Controller_Request_Http $request
     * @return boolean
     */
    public function match(Zend_Controller_Request_Http $request)
    {
        // Just apply the translation to routes without .html
        if (Mage::helper('mk_languageroutes')->isUriTranslatable($request->getPathInfo())) {
            $pathInfo = explode('/', $request->getPathInfo(), 5);

            $originalRoute = $request->getPathInfo();

            /** @var $translationModel MKleine_LanguageRoutes_Model_Translation */
            $translationModel = Mage::getSingleton('mk_languageroutes/translation');

            // Route
            if (isset($pathInfo[1])) {
                $pathInfo[1] = $translationModel->translateRouteToMage($pathInfo[1]);
            }

            // Controller
            if (isset($pathInfo[2])) {
                $pathInfo[2] = $translationModel->translateControllerToMage($pathInfo[2]);
            }

            // Action
            if (isset($pathInfo[3])) {
                $pathInfo[3] = $translationModel->translateActionToMage($pathInfo[3]);
            }

            Mage::dispatchEvent('languageroute_set_path_info_before', array(
                'path_info' => $pathInfo
            ));

            $internalRoute = join('/', $pathInfo);

            Mage::register('languageroute_information', new Varien_Object(array(
                'original' => trim($originalRoute, '/'),
                'internal' => trim($internalRoute, '/')
            )));

            $request->setPathInfo($internalRoute);
        }
        return parent::match($request);
    }

    public function getFrontNames()
    {
        return array_unique(array_keys($this->_modules));
    }
}
