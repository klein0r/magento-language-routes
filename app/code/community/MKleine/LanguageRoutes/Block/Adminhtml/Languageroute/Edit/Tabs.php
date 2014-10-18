<?php

class MKleine_LanguageRoutes_Block_Adminhtml_Languageroute_Edit_Tabs
    extends Mage_Adminhtml_Block_Widget_Tabs{

  public function __construct()
  {
      parent::__construct();
      $this->setId('languageroute_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('mk_languageroutes')->__('Language route'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('mk_languageroutes')->__('Element'),
          'title'     => Mage::helper('mk_languageroutes')->__('Element'),
          'content'   => $this->getLayout()->createBlock('mk_languageroutes/adminhtml_languageroute_edit_tab_form')->toHtml(),
      ));

      return parent::_beforeToHtml();
  }
}
