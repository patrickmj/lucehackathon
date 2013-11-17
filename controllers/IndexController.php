<?php

class OnSite_IndexController extends Omeka_Controller_AbstractActionController
{
    public function onSiteAction()
    {
        $siteName = $this->getParam('siteName');
        $here = $this->getParam('here');
        set_on_site($siteName, $here);
        $referer = $this->getRequest()->getHeader('Referer');
        $this->redirect($referer);
    }
    
    
}