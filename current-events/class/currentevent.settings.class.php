<?php

class CurrentEventSettings
{

    public $initialView;
    public $locale;
    public $header;
    public $firstDay;
    public $backgroundColor;
    public $textColor;


    public function getInfo($initialView, $locale, $header, $firstDay, $backgroundColor, $textColor)
    {
        $this->initialView = $initialView;
        $this->locale = $locale;
        $this->header = $header;
        $this->firstDay = $firstDay;
        $this->backgroundColor = $backgroundColor;
        $this->textColor = $textColor;
    }


    public function createFile()
    {
        global $SITEURL;
        global $GSADMIN;

        $folderNone = GSDATAOTHERPATH . 'current-events/';
        $folder = GSDATAOTHERPATH . 'current-events/settings/';

        $eventSettings = [];
        $eventSettings['initialView'] = $this->initialView;
        $eventSettings['locale'] = $this->locale;
        $eventSettings['header'] = $this->header;
        $eventSettings['firstDay'] = $this->firstDay;
        $eventSettings['backgroundColor'] = $this->backgroundColor;
        $eventSettings['textColor'] = $this->textColor;


        if (!file_exists($folderNone)) {
            mkdir($folderNone, 0755);
            mkdir($folder, 0755);
            file_put_contents($folder . '.htaccess', 'Allow from all');
            file_put_contents($folderNone . '.htaccess', 'Allow from all');
        }


        file_put_contents($folder . 'settings.json', json_encode($eventSettings));
        echo ("<meta http-equiv='refresh' content='0'>");
    }
};
