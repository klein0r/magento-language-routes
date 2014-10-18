<?php

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

            Mage::register('languageroute_original', $request->getPathInfo());

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

            $request->setPathInfo(join('/', $pathInfo));
        }
        return parent::match($request);
    }

    public function getFrontNames()
    {
        return array_unique(array_keys($this->_modules));
    }
}
