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
        $this->addColumn(
            'entity_id',
            array(
                'header' => $this->__('ID'),
                'align' => 'right',
                'width' => '50px',
                'index' => 'entity_id',
            )
        );

        $this->addColumn(
            'store_id',
            array(
                'header' => $this->__('Store'),
                'align' => 'left',
                'index' => 'store_id',
                'type' => 'store',
                'sortable' => true
            )
        );

        $this->addColumn(
            'type_id',
            array(
                'header' => $this->__('Type'),
                'align' => 'left',
                'index' => 'type_id',
                'type' => 'options',
                'sortable' => true,
                'options' => Mage::getSingleton('mk_languageroutes/config_source_routetypes')->toArray()
            )
        );

        $this->addColumn(
            'value',
            array(
                'header' => $this->__('Value'),
                'align' => 'left',
                'index' => 'value',
            )
        );

        $this->addColumn(
            'translation',
            array(
                'header' => $this->__('Translation'),
                'align' => 'left',
                'index' => 'translation',
            )
        );

        $this->addColumn(
            'action',
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
            )
        );

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('languageroute_id');
        $this->getMassactionBlock()->setFormFieldName('languageroute');

        $this->getMassactionBlock()->addItem(
            'delete',
            array(
                'label' => Mage::helper('mk_languageroutes')->__('Delete'),
                'url' => $this->getUrl('*/*/massDelete'),
                'confirm' => Mage::helper('mk_languageroutes')->__('Are you sure?')
            )
        );

        return $this;
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

}
