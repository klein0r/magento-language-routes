<?php

class MKleine_LanguageRoutes_Block_Adminhtml_Languageroute_Edit_Form_Renderer_Fieldset_Languageroute
    extends Varien_Data_Form_Element_Text
{
    public function getElementHtml()
    {
        /** @var $helper MKleine_LanguageRoutes_Helper_Data */
        $helper = Mage::helper('mk_languageroutes');

        $html = '<select onchange="$(\''.$this->getHtmlId().'\').value = this.value;" id="'.$this->getHtmlId().'-suggest" name="'.$this->getName().'-suggest" '.$this->serialize($this->getHtmlAttributes()).' style="margin-bottom: 10px;">'."\n";

        // All routes
        $html .= '<optgroup label="'.$helper->__('Route').'">';
        foreach ($helper->getAvailableRoutes() as $route) {
            $html .= '<option value="'.$route.'">'.$route.'</option>';
        }
        $html .= '</optgroup>'."\n";

        // All controllers
        $html .= '<optgroup label="'.$helper->__('Controller').'">';
        foreach ($helper->getAvailableControllers() as $controller) {
            $html .= '<option value="'.$controller.'">'.$controller.'</option>';
        }
        $html .= '</optgroup>'."\n";

        $html.= '</select>'."\n";
        $html .= parent::getElementHtml();

        return $html;
    }
}