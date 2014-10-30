<?php

class MKleine_LanguageRoutes_Adminhtml_LanguagerouteController
    extends Mage_Adminhtml_Controller_Action
{

    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('mk_languageroutes/items')
            ->_addBreadcrumb(
                Mage::helper('adminhtml')->__('Items Manager'),
                Mage::helper('adminhtml')->__('Item Manager')
            );

        return $this;
    }

    public function indexAction()
    {
        $this->_initAction()->renderLayout();
    }

    public function editAction()
    {
        $id = $this->getRequest()->getParam('id', 0);
        $model = Mage::getModel('mk_languageroutes/languageroute')->load($id);

        if ($model->getId() || $id == 0) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if (!empty($data)) {
                $model->setData($data);
            }

            Mage::register('languageroute_data', $model);

            $this->loadLayout();
            $this->_setActiveMenu('mk_languageroutes/items');

            $this->_addBreadcrumb(
                Mage::helper('adminhtml')->__('Item Manager'),
                Mage::helper('adminhtml')->__('Item Manager')
            );
            $this->_addBreadcrumb(
                Mage::helper('adminhtml')->__('Item News'),
                Mage::helper('adminhtml')->__('Item News')
            );

            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

            $this->_addContent($this->getLayout()->createBlock('mk_languageroutes/adminhtml_languageroute_edit'))
                ->_addLeft($this->getLayout()->createBlock('mk_languageroutes/adminhtml_languageroute_edit_tabs'));

            $this->renderLayout();

        } else {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('mk_languageroutes')->__('Translation does not exist')
            );
            $this->_redirect('*/*/');
        }

    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {

            try {
                $model = Mage::getModel('mk_languageroutes/languageroute');
                $model->setData($data)->setId($this->getRequest()->getParam('id'));

                $model->save();

                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Item was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);

                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId()));
                    return;
                }

                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }

        }

        Mage::getSingleton('adminhtml/session')->addError($this->__('Unable to find item to save'));
        $this->_redirect('*/*/');
    }

    public function deleteAction()
    {
        if ($this->getRequest()->getParam('id') > 0) {
            try {
                $model = Mage::getModel('mk_languageroutes/languageroute');
                $model->setId($this->getRequest()->getParam('id'))->delete();

                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Item was successfully deleted'));
                $this->_redirect('*/*/');

            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }

        $this->_redirect('*/*/');
    }

    public function massDeleteAction()
    {

        $languagerouteIds = $this->getRequest()->getParam('languageroute');

        if (!is_array($languagerouteIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($languagerouteIds as $languagerouteId) {
                    $languageroute = Mage::getModel('mk_languageroutes/languageroute')->load($languagerouteId);
                    $languageroute->delete();
                }

                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted',
                        count($languagerouteIds)
                    )
                );

            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }

        $this->_redirect('*/*/index');
    }

    public function valuesAction()
    {
        $typeId = $this->getRequest()->getParam(
            'type',
            MKleine_LanguageRoutes_Model_Languageroute::LANGUAGEROUTE_TYPE_ROUTER
        );

        /** @var $helper MKleine_LanguageRoutes_Helper_Data */
        $helper = Mage::helper('mk_languageroutes');

        $result = array();

        switch ($typeId) {

            case MKleine_LanguageRoutes_Model_Languageroute::LANGUAGEROUTE_TYPE_ROUTER:
                $result = $helper->getAvailableRoutes();
                break;

            case MKleine_LanguageRoutes_Model_Languageroute::LANGUAGEROUTE_TYPE_CONTROLLER:
                $result = $helper->getAvailableControllers();
                break;

            case MKleine_LanguageRoutes_Model_Languageroute::LANGUAGEROUTE_TYPE_ACTION:
                $result = $helper->getAvailableActions();
                break;
        }

        $this->getResponse()->setHeader('Content-type', 'application/json');
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    }
}