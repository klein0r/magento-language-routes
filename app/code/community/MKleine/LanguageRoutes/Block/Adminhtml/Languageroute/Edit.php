<?php

class MKleine_LanguageRoutes_Block_Adminhtml_Languageroute_Edit
    extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'mk_languageroutes';
        $this->_controller = 'adminhtml_languageroute';

        $this->_updateButton('save', 'label', $this->__('Save Translation'));
        $this->_updateButton('delete', 'label', $this->__('Delete Translation'));

        $this->_addButton('saveandcontinue', array(
            'label'     => $this->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('languageroute_data') && Mage::registry('languageroute_data')->getId() ) {
            /** @var $route MKleine_LanguageRoutes_Model_Languageroute */
            $route = Mage::registry('languageroute_data');

            return $this->__("%s -> %s", $this->escapeHtml($route->getValue()), $this->escapeHtml($route->getTranslation()));
        } else {
            return $this->__('Add Item');
        }
    }
}