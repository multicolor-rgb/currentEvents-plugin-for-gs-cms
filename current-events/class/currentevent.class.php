<?php

class CurrentEvent
{

    public $title;
    public $description;
    public $startDate;
    public $endDate;
    public $color;
    public $url;

    public function getInfo($title, $description, $startDate, $endDate, $color, $colortext, $url)
    {
        $this->title = $title;
        $this->description = $description;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->color = $color;
        $this->colortext = $colortext;
        $this->url = $url;
    }


    public function createFile()
    {

        $folder = GSDATAOTHERPATH . 'current-events/';

        $event = [];
        $event['eventname'] = $this->title;
        $event['eventdescription'] = $this->description;
        $event['title'] = "<p style='font-size:14px;color:" . $this->colortext . " !important;margin:3px;padding:0;font-weight:bold;'>" . $this->title . "</p> 
        <p style='font-size:12px;color:" . $this->colortext . " !important;margin:3px;padding:0;'>" . $this->description . "</p>";
        $event['start'] = $this->startDate;
        $event['end'] =  $this->endDate;
        $event['colortext'] =  $this->colortext;

        if ($this->url !== '') {
            $event['url'] =  $this->url;
        };

        $event['color'] =  $this->color;

        if (!file_exists($folder)) {
            mkdir($folder, 0755);
            file_put_contents($folder . '.htaccess', 'Allow from all');
        }


        function generateSalt($length = 32)
        {
            return bin2hex(random_bytes($length));
        }

        // Generowanie soli
        $salt = generateSalt();

        // Łączenie hasła i soli
        $titleWithSalt = $this->title . $salt;

        // Generowanie hasha
        $hashedTitle = hash("sha256", $titleWithSalt);

        if (isset($_GET['edit'])) {
            global $SITEURL;
            global $GSADMIN;

            file_put_contents($folder . $_GET['edit'] . '.json', json_encode($event));
            echo ("<meta http-equiv='refresh' content='0;url=" . $SITEURL . $GSADMIN . "/load.php?id=current-events&addevent&edit=" . $_GET['edit'] . "'>");
        } else {
            global $SITEURL;
            global $GSADMIN;
            file_put_contents($folder . $hashedTitle . '.json', json_encode($event));
            echo ("<meta http-equiv='refresh' content='0;url=" . $SITEURL . $GSADMIN . "/load.php?id=current-events&addevent&edit=" . $hashedTitle . "'>");
        }
    }
};
