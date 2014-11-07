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
class MKleine_LanguageRoutes_Block_Adminhtml_Languageroute_Edit_Tab_Form
    extends Mage_Adminhtml_Block_Widget_Form
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{

    public function getTabLabel()
    {
        return $this->__('Translation');
    }

    public function getTabTitle()
    {
        return $this->__('Translation');
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
                'legend' => Mage::helper('mk_languageroutes')->__('Settings')
            )
        );

        $fieldset->addType('languageroute', 'MKleine_LanguageRoutes_Block_Adminhtml_Languageroute_Edit_Form_Renderer_Fieldset_Languageroute');

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
        }

        $fieldset->addField(
            'type_id',
            'select',
            array(
                'label' => $this->__('Route Part'),
                'required' => true,
                'name' => 'type_id',
                'values' => Mage::getSingleton('mk_languageroutes/config_source_routetypes')->toOptionArray()
            )
        );

        $fieldset->addField(
            'value',
            'languageroute',
            array(
                'label' => $this->__('Original Value'),
                'required' => true,
                'name' => 'value'
            )
        );

        $fieldset->addField(
            'translation',
            'text',
            array(
                'label' => $this->__('Translation'),
                'required' => true,
                'name' => 'translation'
            )
        );

        $fieldset->addField(
            'is_active',
            'select',
            array(
                'label' => $this->__('Is Active'),
                'required' => true,
                'name' => 'is_active',
                'values' => Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray()
            )
        );

        Mage::dispatchEvent('languageroute_adminhtml_form_edit', array(
            'form' => $this
        ));

        if (Mage::getSingleton('adminhtml/session')->getLanguagerouteData()) {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getLanguagerouteData());
            Mage::getSingleton('adminhtml/session')->setLanguagerouteData(null);
        } elseif (Mage::registry('languageroute_data')) {
            $form->setValues(Mage::registry('languageroute_data')->getData());
        }

        return parent::_prepareForm();
    }
}