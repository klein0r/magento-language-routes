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
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('languageroute_form', array('legend' => Mage::helper('mk_mailpreview')->__('Allgemein')));

        $fieldset->addField('variable', 'text', array(
            'label' => $this->__('Variable'),
            'required' => true,
            'name' => 'variable',
        ));

        $fieldset->addField('replacement', 'text', array(
            'label' => $this->__('Replacement'),
            'required' => true,
            'name' => 'replacement',
        ));

        if (Mage::getSingleton('adminhtml/session')->getPlaceholderData()) {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getPlaceholderData());
            Mage::getSingleton('adminhtml/session')->setPlaceholderData(null);
        } elseif (Mage::registry('placeholder_data')) {
            $form->setValues(Mage::registry('placeholder_data')->getData());
        }

        return parent::_prepareForm();
    }
}