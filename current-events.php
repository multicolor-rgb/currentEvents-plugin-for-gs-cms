<?php

# get correct id for plugin
$thisfile = basename(__FILE__, ".php");

# register plugin
register_plugin(
  $thisfile, //Plugin id
  'Current Events',     //Plugin name
  '3.0',         //Plugin version
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
    $createEvent->getInfo($_POST['title-current-event'], $_POST['description-current-event'], $_POST['start-date'], $_POST['end-date'], $_POST['color-current-event'], $_POST['color-current-text'], $_POST['url-current-event'],  $_POST['longevent']);
    $createEvent->createFile();
  }

  if (isset($_POST['create-settings'])) {

    $createEvent = new CurrentEventSettings();
    $createEvent->getInfo($_POST['initialView'], $_POST['locale'], $_POST['header'], $_POST['firstday'], $_POST['backgroundColor'], $_POST['textColor']);
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
  echo '

  <div id="calendar"></div>
 
  <div class="datepicker">
  <input type="date" id="dateInput" min="' . date('Y-m-d') . '">
  <button id="goToDateButton">check the date</button>
  </div>
  
  ';
}

function returnEventCalendar()
{
  return '

  <div id="calendar"></div>

  <div class="datepicker">
  <input type="date" id="dateInput" min="' . date('Y-m-d') . '">
  <button id="goToDateButton">check the date</button>
  </div>';
}


function headCurrentEvent()
{
  global $SITEURL;
  echo "
  <style>
  
  .datepicker{
  display:grid;
  grid-template-columns:1fr 150px;
  gap:5px;
box-sizing:border-box;
  margin-top:10px;}

  .datepicker input{
  padding:10px;
  border-radius: 0.25em;
  border:solid 1px #ddd;
  box-sizing:border-box;
  width:100%;
  }
.datepicker button{
  padding:10px;
  box-sizing:border-box;
  background-color: var(--fc-button-bg-color);
  border-color: var(--fc-button-border-color);
  color: var(--fc-button-text-color);
  border-radius: 0.25em;
  border:none;
  width20%;
  cursor:pointer;
}
  }

.fc .fc-bg-event{
  padding-top:25px !important;
}
  :root{
    --fc-bg-event-opacity:0.7 !important;
  }

  .fc-daygrid-event {
    white-space: normal !important;
    align-items: normal !important;
    padding:10px;
    box-sizing:border-box;
  }

  @media(min-width:996px){
  .fc-scroller.fc-scroller-liquid-absolute{
    overflow:hidden !important
  }

};

  
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
      
      allDay:true,
      eventBackgroundColor:'blue',
        initialView: '" . $fileJS->initialView . "',
      locale:'" . $fileJS->locale . "',
      locale:'" . $fileJS->locale . "',
      firstDay:" . $fileJS->firstDay . ",
      ";

    if ($fileJS->header == 'true') {

      echo "  headerToolbar:{
          start: 'title',
          center: '',
          end: 'today,next'
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
      allDay:true,
          initialView: 'dayGridMonth',
        locale:'pl',
        headerToolbar:{
          start: 'title',
          center: '',
          end: 'next'
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
       
    


     var calendarEl = document.getElementById('calendar');
      var dateInput = document.getElementById('dateInput');
      var goToDateButton = document.getElementById('goToDateButton');

      goToDateButton.addEventListener('click', function() {
        var inputDate = dateInput.value;
        if (inputDate) {
          var targetDate = new Date(inputDate);
          if (targetDate >= new Date()) {
            // Przejdź do wybranej daty
            calendar.gotoDate(targetDate);
          } else {
            alert('The chosen one cannot be older than the current day!');
          }
        } else {
          alert('enter date!');
        }
      });
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
