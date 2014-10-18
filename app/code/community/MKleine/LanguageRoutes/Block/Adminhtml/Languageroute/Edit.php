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

        $this->_updateButton('save', 'label', $this->__('Save Item'));
        $this->_updateButton('delete', 'label', $this->__('Delete Item'));

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
        if( Mage::registry('placeholder_data') && Mage::registry('placeholder_data')->getId() ) {
            return $this->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('placeholder_data')->getVariable()));
        } else {
            return $this->__('Add Item');
        }
    }
}