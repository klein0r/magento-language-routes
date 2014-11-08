<?php

class MKleine_LanguageRoutes_Block_Translate_Uri extends Mage_Core_Block_Template
{
    public function __construct(array $args = array())
    {
        parent::__construct($args);
        $this->setTemplate('mkleine/languageroutes/translate/uri.phtml');
    }

    /**
     * Returns the action to the admin form controller
     *
     * @return string
     */
    public function getFormAction()
    {
        return Mage::getUrl('languageroute/translation/saveinline');
    }

    public function getFormKey()
    {
        $appEmulation = Mage::getSingleton('core/app_emulation');
        $initialEnvironmentInfo = $appEmulation->startEnvironmentEmulation(Mage_Core_Model_App::ADMIN_STORE_ID);

        $formKey = Mage::getSingleton('core/session')->getFormKey();

        $appEmulation->stopEnvironmentEmulation($initialEnvironmentInfo);

        return $formKey;
    }

    /**
     * Checks, if the current user is allowed to translate the current url
     *
     * @return bool
     */
    public function isAllowed()
    {
        /** @var $translate Mage_Core_Model_Translate_Inline */
        $translate = Mage::getSingleton('core/translate_inline');
        return $translate->isAllowed();
    }

    /**
     * @param bool $translate
     * @return MKleine_LanguageRoutes_Model_Core_Url
     */
    protected function getUrlModel($translate = true)
    {
        return Mage::getModel('core/url')
            ->setRoutePath('*/*/*')
            ->setNoTranslate(!$translate);
    }

    /**
     * Returns the translation of the current route
     * @return string
     */
    public function getValueRoute()
    {
        $value = $this->getUrlModel()->getRouteFrontName();
        return ($value != $this->getUntranslatedRoute()) ? $value : '';
    }

    public function getUntranslatedRoute()
    {
        return $this->getUrlModel(false)->getRouteFrontName();
    }

    /**
     * Returns the translation of the current controller
     * @return string
     */
    public function getValueController()
    {
        $value = $this->getUrlModel()->getControllerName();
        return ($value != $this->getUntranslatedController()) ? $value : '';
    }

    public function getUntranslatedController()
    {
        return $this->getUrlModel(false)->getControllerName();
    }

    /**
     * Returns the translation of the current action
     * @return string
     */
    public function getValueAction()
    {
        $value = $this->getUrlModel()->getActionName();
        return ($value != $this->getUntranslatedAction()) ? $value : '';
    }

    public function getUntranslatedAction()
    {
        return $this->getUrlModel(false)->getActionName();
    }
}