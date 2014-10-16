<?php

class MKleine_LanguageRoutes_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function translateRouteToMage($route)
    {
        return 'customer';
    }

    public function translateRouteToFront($route)
    {
        return 'kunde';
    }

    public function translateControllerToMage($controller)
    {
        return 'account';
    }

    public function translateControllerToFront($controller)
    {
        return 'konto';
    }

    public function translateActionToMage($action)
    {
        return 'create';
    }

    public function translateActionToFront($action)
    {
        return 'erstellen';
    }
}