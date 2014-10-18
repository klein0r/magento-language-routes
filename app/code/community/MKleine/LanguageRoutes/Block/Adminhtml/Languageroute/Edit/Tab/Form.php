<?php

class MKleine_LanguageRoutes_Block_Adminhtml_Languageroute_Edit_Tab_Form
    extends Mage_Adminhtml_Block_Widget_Form
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{

    public function getTabLabel()
    {
        return $this->__('Content');
    }

    public function getTabTitle()
    {
        return $this->__('Content');
    }

    public function canShowTab()
    {
        return true;
    }

    public function isHidden()
    {
        return false;
    }

    /**
     * Check permission for passed action
     *
     * @param string $action
     * @return bool
     */
    protected function _isAllowedAction($action)
    {
        return Mage::getSingleton('admin/session')->isAllowed('cms/page/' . $action);
    }

    protected function _prepareForm()
    {
        /*
         * Checking if user have permissions to save information
         */
        if ($this->_isAllowedAction('save')) {
            $isElementDisabled = false;
        } else {
            $isElementDisabled = true;
        }

        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'languageroute_form',
            array(
                'legend' => Mage::helper('mk_languageroutes')->__('Allgemein')
            )
        );

        /**
         * Check is single store mode
         */
        if (!Mage::app()->isSingleStoreMode()) {
            $field = $fieldset->addField(
                'store_id',
                'select',
                array(
                    'label' => Mage::helper('cms')->__('Store View'),
                    'title' => Mage::helper('cms')->__('Store View'),
                    'required' => true,
                    'values' => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, false),
                    'disabled' => $isElementDisabled,
                    'name' => 'store_id',
                )
            );
            $renderer = $this->getLayout()->createBlock('adminhtml/store_switcher_form_renderer_fieldset_element');
            $field->setRenderer($renderer);
        } else {
            $fieldset->addField(
                'store_id',
                'hidden',
                array(
                    'value' => Mage::app()->getStore(true)->getId()
                )
            );
            //$model->setStoreId(Mage::app()->getStore(true)->getId());
        }

        $fieldset->addField(
            'type_id',
            'select',
            array(
                'label' => $this->__('Route Part'),
                'required' => true,
                'name' => 'type_id',
                'values' => Mage::getSingleton('mk_languageroutes/config_source_routetypes')->toOptionArray(),
            )
        );

        $fieldset->addField(
            'value',
            'text',
            array(
                'label' => $this->__('Original Value'),
                'required' => true,
                'name' => 'value',
                #'disabled' => true
            )
        );

        $fieldset->addField(
            'translation',
            'text',
            array(
                'label' => $this->__('Translation'),
                'required' => true,
                'name' => 'translation',
            )
        );

        if (Mage::getSingleton('adminhtml/session')->getLanguagerouteData()) {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getLanguagerouteData());
            Mage::getSingleton('adminhtml/session')->setLanguagerouteData(null);
        } elseif (Mage::registry('languageroute_data')) {
            $form->setValues(Mage::registry('languageroute_data')->getData());
        }

        return parent::_prepareForm();
    }
}