<?php

class MKleine_LanguageRoutes_TranslationController extends Mage_Core_Controller_Front_Action
{
    /**
     * Controller to save information
     */
    public function saveinlineAction()
    {
        /** @var $translate Mage_Core_Model_Translate_Inline */
        $translate = Mage::getSingleton('core/translate_inline');
        if ($translate->isAllowed()) {
            $returlUrl = $this->getRequest()->getParam('current_url', false);
            $storeId = $this->getRequest()->getParam('store_id', false);

            $origRoute = $this->getRequest()->getParam('route_untranslated', false);
            $origController = $this->getRequest()->getParam('controller_untranslated', false);
            $origAction = $this->getRequest()->getParam('action_untranslated', false);

            $newRoute = $this->getRequest()->getParam('route', false);
            $newController = $this->getRequest()->getParam('controller', false);
            $newAction = $this->getRequest()->getParam('action', false);

            $languageRoutes = array(
                array(
                    'type_id' => MKleine_LanguageRoutes_Model_Languageroute::LANGUAGEROUTE_TYPE_ROUTER,
                    'store_id' => $storeId,
                    'is_active' => 1,
                    'value' => $origRoute,
                    'translation' => $newRoute
                ),
                array(
                    'type_id' => MKleine_LanguageRoutes_Model_Languageroute::LANGUAGEROUTE_TYPE_CONTROLLER,
                    'store_id' => $storeId,
                    'is_active' => 1,
                    'value' => $origController,
                    'translation' => $newController
                ),
                array(
                    'type_id' => MKleine_LanguageRoutes_Model_Languageroute::LANGUAGEROUTE_TYPE_ACTION,
                    'store_id' => $storeId,
                    'is_active' => 1,
                    'value' => $origAction,
                    'translation' => $newAction
                )
            );

            foreach ($languageRoutes as $languageRoute)
            {
                /** @var $model MKleine_LanguageRoutes_Model_Languageroute */
                $model = Mage::getModel('mk_languageroutes/languageroute');
                $model->setData($languageRoute);

                $collection = Mage::getModel('mk_languageroutes/languageroute')
                    ->getCollection()
                    ->addFieldToFilter('store_id', $model->getStoreId())
                    ->addFieldToFilter('type_id', $model->getTypeId())
                    ->addFieldToFilter('value', $model->getValue());

                    /** @var $existingItem MKleine_LanguageRoutes_Model_Languageroute */
                    if ($existingItem = $collection->getFirstItem()) {
                        $existingItem->addData($languageRoute);

                        if ($existingItem->getTranslation()) {
                            $existingItem->save();
                        }
                        else {
                            $existingItem->delete();
                        }
                    }
                    else if ($model->getTranslation()) { {
                        $model->save();
                    }
                }
            }

            // Clear route translation cache
            Mage::helper('mk_languageroutes')->clearTranslationCache();

            if ($returlUrl) {
                $this->_redirect(sprintf('%s/%s/%s',
                    $newRoute ?: $origRoute,
                    $newController ?: $origController,
                    $newAction ?: $origAction
                ));
            }
            else {
                $this->_redirect('*/*/index');
            }
        }
    }
}