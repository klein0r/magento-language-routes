<?php

class MKleine_LanguageRoutes_Block_Adminhtml_Languageroute_Grid
    extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('languagerouteGrid');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('mk_languageroutes/languageroute')->getCollection();
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('languageroute_id', array(
            'header' => $this->__('ID'),
            'align' => 'right',
            'width' => '50px',
            'index' => 'languageroute_id',
        ));

        $this->addColumn('variable', array(
            'header' => $this->__('Variable'),
            'align' => 'left',
            'index' => 'variable',
        ));

        $this->addColumn('replacement', array(
            'header' => $this->__('Replacement'),
            'align' => 'left',
            'index' => 'replacement',
        ));

        $this->addColumn('action',
            array(
                'header' => $this->__('Action'),
                'width' => '100',
                'type' => 'action',
                'getter' => 'getId',
                'actions' => array(
                    array(
                        'caption' => $this->__('Edit'),
                        'url' => array('base' => '*/*/edit'),
                        'field' => 'id'
                    )
                ),
                'filter' => false,
                'sortable' => false,
                'index' => 'stores',
                'is_system' => true,
            ));

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('languageroute_id');
        $this->getMassactionBlock()->setFormFieldName('languageroute');

        $this->getMassactionBlock()->addItem('delete', array(
            'label' => Mage::helper('mk_languageroutes')->__('Delete'),
            'url' => $this->getUrl('*/*/massDelete'),
            'confirm' => Mage::helper('mk_languageroutes')->__('Are you sure?')
        ));

        return $this;
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

}
