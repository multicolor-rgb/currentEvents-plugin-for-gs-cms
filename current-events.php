<?php
/*
Plugin Name: Hello World
Description: Echos "Hello World" in footer of theme
Version: 1.0
Author: Chris Cagle
Author URI: http://www.cagintranet.com/
*/

# get correct id for plugin
$thisfile = basename(__FILE__, ".php");

# register plugin
register_plugin(
  $thisfile, //Plugin id
  'Current Events',     //Plugin name
  '1.0',         //Plugin version
  'Multicolor',  //Plugin author
  'https://bit.ly/donate-multicolor-plugins', //author website
  'Easy to use plugin calendar', //Plugin description
  'pages', //page type - on which admin tab to display
  'currentEvent'  //main function (administration)
);

# activate filter 

# add a link in the admin tab 'theme'
add_action('pages-sidebar', 'createSideMenu', array($thisfile, 'CurrentEvent 📅'));

add_action('theme-header', 'headCurrentEvent');

add_action('theme-header', 'shortcodeEventCalendar');


include(GSPLUGINPATH . 'current-events/class/currentevent.class.php');
include(GSPLUGINPATH . 'current-events/class/currentevent.settings.class.php');


# functions
function currentEvent()
{
  if (isset($_GET['addevent'])) {
    include(GSPLUGINPATH . 'current-events/view/newevent.view.php');
  } elseif (isset($_GET['settings'])) {
    include(GSPLUGINPATH . 'current-events/view/settings.view.php');
  } elseif (isset($_GET['howto'])) {
    include(GSPLUGINPATH . 'current-events/view/howuse.view.php');
  } else {
    include(GSPLUGINPATH . 'current-events/view/list.view.php');
  }

  if (isset($_POST['create-event'])) {

    $createEvent = new CurrentEvent();
    $createEvent->getInfo($_POST['title-current-event'], $_POST['description-current-event'], $_POST['start-date'], $_POST['end-date'], $_POST['color-current-event'], $_POST['color-current-text'], $_POST['url-current-event']);
    $createEvent->createFile();
  }

  if (isset($_POST['create-settings'])) {

    $createEvent = new CurrentEventSettings();
    $createEvent->getInfo($_POST['initialView'], $_POST['locale'], $_POST['header'], $_POST['firstday']);
    $createEvent->createFile();
  }

  if (isset($_GET['delete'])) {
    unlink(GSDATAOTHERPATH . 'current-events/' . $_GET['delete'] . '.json');
    echo ("<meta http-equiv='refresh' content='0;url=" . $SITEURL . $GSADMIN . "/load.php?id=current-events'>");
  };

  echo '
  <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank" style="box-sizing:border-box; display:grid; align-items:center;width:100%;grid-template-columns:1fr auto; padding:10px !important;background:#fafafa;border:solid 1px #ddd;margin-top:20px;">
      <p style="margin:0;padding:0;">If you want to support my work via PayPal :) Thanks! </p>
      <input type="hidden" name="cmd" value="_s-xclick" />
      <input type="hidden" name="hosted_button_id" value="KFZ9MCBUKB7GL" />
      <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button" />
      <img alt="" border="0" src="https://www.paypal.com/en_PL/i/scr/pixel.gif" width="1" height="1" />
  </form>';
}

function showEventCalendar()
{
  echo '<div id="calendar"></div>';
}

function returnEventCalendar()
{
  return '<div id="calendar"></div>';
}


function headCurrentEvent()
{
  global $SITEURL;
  echo "
  <style>
  .fc-daygrid-event {
    white-space: normal !important;
    align-items: normal !important;
  }
  </style>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js'></script>
    
   <script>

     document.addEventListener('DOMContentLoaded', function() {
       var calendarEl = document.getElementById('calendar');
       var calendar = new FullCalendar.Calendar(calendarEl, 

       ";


  $file = GSDATAOTHERPATH . 'current-events/settings/settings.json';

  $fileJS = json_decode(@file_get_contents($file));




  if (file_exists($file) && $fileJS->header == true) {

    echo "{
      eventBackgroundColor:'blue',
        initialView: '" . $fileJS->initialView . "',
      locale:'" . $fileJS->locale . "',
      locale:'" . $fileJS->locale . "',
      firstDay:" . $fileJS->firstDay . ",
      displayEventEnd:true, ";

    if ($fileJS->header == 'true') {

      echo "  headerToolbar:{
          start: 'title',
          center: '',
          end: 'prev,next'
        }";
    } else {
      echo "  headerToolbar:{
        start: 'title',
        center: '',
        end: ''
      }";
    };
  } else {
    echo "{

          initialView: 'dayGridMonth',
        locale:'pl',
        headerToolbar:{
          start: 'title',
          center: '',
          end: 'prev,next'
        }";
  };


  echo ", events: [
          
          ";

  if (!empty(glob(GSDATAOTHERPATH . 'current-events\*.json'))) {


    foreach (glob(GSDATAOTHERPATH . 'current-events\*.json') as $key => $file) {

      $data = file_get_contents($file);
      echo $data;

      if ($key !== count(glob(GSDATAOTHERPATH . 'current-events\*.json'))) {
        echo ',';
      };
    };
  };


  echo "
          
          ],
         
    
          eventContent: function( info ) {
            return {html: info.event.title};
        }
      
       });
       calendar.render();
     });

   </script>";
}





function shortcodeEventCalendar()
{

  global $content;
  $newcontent = preg_replace_callback(
    '/\\[% ce %\\]/i',
    "returnEventCalendar",
    $content
  );
  $content = $newcontent;
};
