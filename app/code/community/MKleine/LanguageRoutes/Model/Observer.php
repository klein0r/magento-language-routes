<?php

class MKleine_LanguageRoutes_Model_Observer
{
    /**
     * Cleans the cache when a translation changes
     *
     * @param $observer
     */
    public function languagerouteSaveAfter($observer)
    {
        /** @var $translationModel MKleine_LanguageRoutes_Model_Translation */
        $translationModel = Mage::getSingleton('mk_languageroutes/translation');
        $translationModel->clearCache();
    }
}