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
/**
 * Class MKleine_LanguageRoutes_Model_Languageroute
 *
 * @method getTypeId
 * @method setTypeId
 * @method getValue
 * @method setValue
 * @method getTranslation
 * @method setTranslation
 * @method getStoreId
 * @method setStoreId
 * @method getCreatedAt
 * @method getUpdatedAt
 * @method getIsActive
 */
class MKleine_LanguageRoutes_Model_Languageroute
    extends Mage_Core_Model_Abstract
{
    const LANGUAGEROUTE_TYPE_ROUTER = 1;
    const LANGUAGEROUTE_TYPE_CONTROLLER = 2;
    const LANGUAGEROUTE_TYPE_ACTION = 3;

    protected $_eventPrefix = 'languageroute';

    public function _construct()
    {
        parent::_construct();
        $this->_init('mk_languageroutes/languageroute');
    }

    protected function _beforeSave()
    {
        $timestamp = Mage::getModel('core/date')->timestamp();
        $this->setUpdatedAt($timestamp);

        if (!$this->getId()) {
            $this->setCreatedAt($timestamp);
        }

        return parent::_beforeSave();
    }

    /**
     * Get languageroute created at date timestamp
     *
     * @return int|null
     */
    public function getCreatedAtTimestamp()
    {
        $date = $this->getCreatedAt();
        if ($date) {
            return Varien_Date::toTimestamp($date);
        }
        return null;
    }

    /**
     * Get the timestamp of the latest update
     *
     * @return int|null
     */
    public function getUpdatedAtTimestamp()
    {
        $date = $this->getUpdatedAt();
        if ($date) {
            return Varien_Date::toTimestamp($date);
        }
        return null;
    }
}