<?php

class MKleine_LanguageRoutes_Block_Adminhtml_Languageroute
    extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $helper = Mage::helper('mk_languageroutes');

        $this->_controller = 'adminhtml_languageroute';
        $this->_blockGroup = 'mk_languageroutes';
        $this->_headerText = $helper->__('Language Route');
        $this->_addButtonLabel = $helper->__('Add');

        parent::__construct();
    }
}
