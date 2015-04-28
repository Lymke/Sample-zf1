<?php
/**
 * @desc        Change la langue de Zend_Translate quand il est passé en paramètre
 *              Vérifie la langue à chaque fois
 */
class My_Controller_Plugin_LangSelector extends Zend_Controller_Plugin_Abstract
{
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {   
        $translate = Zend_Registry::get('Zend_Translate');
        $currLocale = $translate->getLocale();
        $session = new Zend_Session_Namespace('session');
        $lang = $request->getParam('lang','');
        // Register all your "approved" locales below.
        switch($lang) {
            case "sv": $langLocale = 'sv_SE'; break;  
            case "fr": $langLocale = 'fr_FR'; break;
            case "en": $langLocale = 'en_US'; break;
            default  : $langLocale = isset($session->lang) ? $session->lang : $currLocale;
        }
        $newLocale = new Zend_Locale();
        $newLocale->setLocale($langLocale);
        Zend_Registry::set('Zend_Locale', $newLocale);
        $translate->setLocale($langLocale);
        $session->lang = $langLocale;
        // Save the modified translate back to registry
        Zend_Registry::set('Zend_Translate', $translate);
    }
    
    public static function changerLangue(){
    }
}