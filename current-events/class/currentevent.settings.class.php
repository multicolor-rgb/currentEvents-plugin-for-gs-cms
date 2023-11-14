<?php

class CurrentEventSettings
{

    public $initialView;
    public $locale;
    public $header;


    public function getInfo($initialView, $locale, $header)
    {
        $this->initialView = $initialView;
        $this->locale = $locale;
        $this->header = $header;
    }


    public function createFile()
    {
        global $SITEURL;
        global $GSADMIN;

        $folder = GSDATAOTHERPATH . 'current-events/settings/';

        $eventSettings = [];
        $eventSettings['initialView'] = $this->initialView;
        $eventSettings['locale'] = $this->locale;
        $eventSettings['header'] = $this->header;


        if (!file_exists($folder)) {
            mkdir($folder, 0755);
            file_put_contents($folder . '.htaccess', 'Allow from all');
        }


        file_put_contents($folder . 'settings.json', json_encode($eventSettings));
        echo ("<meta http-equiv='refresh' content='0'>");
    }
};
