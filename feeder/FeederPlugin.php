<?php
namespace Craft;

class FeederPlugin extends BasePlugin
{
    public function getName()
    {
        return Craft::t('Feeder');
    }
    
    public function getVersion()
    {
        return '1.0';
    }
    
    public function getDeveloper()
    {
        return 'Matt Stein';
    }
    
    public function getDeveloperUrl()
    {
        return 'http://workingconcept.com';
    }    

}