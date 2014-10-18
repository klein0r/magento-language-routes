<?php

class MKleine_LanguageRoutes_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * @param $url string
     */
    public function isUriTranslatable($url)
    {
        return (strpos($url, '.html') === false);
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
            if (Mage::helper('core')->isModuleEnabled($moduleName))
            {
                foreach (glob(Mage::getModuleDir('controllers', $moduleName). DS . '*') as $controller) {
                    if (is_file($controller) && strpos($controller, 'Adminhtml') === false) {
                        $controllers[] = strtolower(str_replace('Controller.php', '', basename($controller)));
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