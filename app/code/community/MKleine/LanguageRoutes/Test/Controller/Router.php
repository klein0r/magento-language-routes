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
class MKleine_LanguageRoutes_Test_Controller_Router
    extends Codex_Xtest_Xtest_Unit_Frontend
{
    protected function setUp()
    {
        parent::setUp();

        /** @var $translations MKleine_LanguageRoutes_Model_Resource_Languageroute_Collection */
        $translations = Mage::getModel('mk_languageroutes/languageroute')->getCollection();
        $translations->walk('delete');

        /** @var $translationModel MKleine_LanguageRoutes_Model_Translation */
        $translationModel = Mage::getSingleton('mk_languageroutes/translation');
        $translationModel->clearCache();
    }

    /**
     * @param $type
     * @param $value
     * @param $translation
     * @return MKleine_LanguageRoutes_Model_Languageroute
     */
    protected function createRoute($storeId, $type, $value, $translation)
    {
        /** @var $testRoute MKleine_LanguageRoutes_Model_Languageroute */
        $testRoute = Mage::getModel('mk_languageroutes/languageroute');
        $testRoute->setTypeId($type);
        $testRoute->setValue($value);
        $testRoute->setTranslation($translation);
        $testRoute->setStoreId($storeId);
        $testRoute->setIsActive(1);
        $testRoute->save();

        return $testRoute;
    }

    protected function createExampleRoute($storeId)
    {
        $this->createRoute(
            $storeId,
            MKleine_LanguageRoutes_Model_Languageroute::LANGUAGEROUTE_TYPE_ROUTER,
            'customer',
            'kunde'
        );

        $this->createRoute(
            $storeId,
            MKleine_LanguageRoutes_Model_Languageroute::LANGUAGEROUTE_TYPE_CONTROLLER,
            'account',
            'konto'
        );

        $this->createRoute(
            $storeId,
            MKleine_LanguageRoutes_Model_Languageroute::LANGUAGEROUTE_TYPE_ACTION,
            'create',
            'erstellen'
        );

        /** @var $translations MKleine_LanguageRoutes_Model_Resource_Languageroute_Collection */
        $translations = Mage::getModel('mk_languageroutes/languageroute')
            ->getCollection()
            ->addFieldToFilter('store_id', $storeId);
        $this->assertEquals(3, $translations->count());
    }

    /**
     * @test
     */
    public function testStoreTranslations()
    {
        $storeId = Mage::app()->getStore()->getId();
        $this->createExampleRoute($storeId);

        $this->dispatch('/kunde/konto/erstellen/');
        $this->assertContains('customer-account-create', $this->getResponseBody());
    }

    /**
     * @test
     */
    public function testGlobalTranslations()
    {
        $this->createExampleRoute(0);

        $this->dispatch('/kunde/konto/erstellen/');
        $this->assertContains('customer-account-create', $this->getResponseBody());
    }

    /**
     * @test
     */
    public function testOtherStoreTranslation()
    {
        /** @var $currentStore Mage_Core_Model_Store */
        $currentStore = Mage::app()->getStore();

        /** @var $store Mage_Core_Model_Store */
        $store = Mage::getModel('core/store');
        $store->setCode('test')
            ->setWebsiteId($currentStore->getWebsiteId())
            ->setGroupId($currentStore->getGroupId())
            ->setName('Test Store')
            ->setIsActive(1)
            ->save();

        $this->createExampleRoute($store->getId());

        $this->setExpectedException('Mage_Core_Exception', '404');
        $this->dispatch('/kunde/konto/erstellen/');
    }
}