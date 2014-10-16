<?php

class MKleine_LanguageRoutes_Controller_Varien_Router_Standard extends Mage_Core_Controller_Varien_Router_Standard
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
        $pathInfo = explode('/', $request->getPathInfo(), 5);

        /** @var $helper MKleine_LanguageRoutes_Helper_Data */
        $helper = Mage::helper('mk_languageroutes');

        // Route
        if (isset($pathInfo[1])) {
            $pathInfo[1] = $helper->translateRouteToMage($pathInfo[1]);
        }

        // Controller
        if (isset($pathInfo[2])) {
            $pathInfo[2] = $helper->translateControllerToMage($pathInfo[2]);
        }

        // Action
        if (isset($pathInfo[3])) {
            $pathInfo[3] = $helper->translateActionToMage($pathInfo[3]);
        }

        $request->setPathInfo(join('/', $pathInfo));
        return parent::match($request);
    }

}
