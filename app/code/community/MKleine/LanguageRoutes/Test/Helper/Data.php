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
class MKleine_LanguageRoutes_Test_Helper_Data
    extends Codex_Xtest_Xtest_Unit_Frontend
{
    /**
     * @return MKleine_LanguageRoutes_Helper_Data
     */
    protected function getHelper()
    {
        return Mage::helper('mk_languageroutes');
    }

    /**
     * @test
     */
    public function testTranslationEnabled()
    {
        // web/url/enable_route_translation

    }

    /**
     * @test
     */
    public function testIsTranslateable()
    {
        $helper = $this->getHelper();

        $this->assertTrue($helper->isUriTranslatable('http://my-test-store.de/customer/account/create/'));
        $this->assertFalse($helper->isUriTranslatable('http://my-test-store.de/translate-no-rewrites.html'));
    }

    public function testGetAvailableRoutes()
    {
        $helper = $this->getHelper();

        $routes = $helper->getAvailableRoutes();

        $this->assertContains('customer', $routes);
        $this->assertContains('catalog', $routes);
        $this->assertContains('checkout', $routes);
    }
}