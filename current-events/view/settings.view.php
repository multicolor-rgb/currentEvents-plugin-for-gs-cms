<style>
    .btn {
        display: inline-flex;
        padding: 5px 10px;
        border: solid 1px #000;
        background: #000;
        color: #fff !important;
        text-decoration: none !important;
    }

    .btn-sm {
        display: inline-flex;
        padding: 5px 10px;
        border: solid 1px #000;
        background: #000;
        color: #fff !important;
        text-decoration: none !important;
        margin: 0 3px;
        text-align: center;
    }

    .btn-sm-red {
        background: red;
        border: red;
    }

    .form-settings {
        background: #fafafa;
        border: solid 1px #ddd;
        padding: 10px;
        margin-top: 10px;
    }

    .form-settings :is(select, input) {
        width: 100%;
        padding: 5px;
        border-radius: 0;
        border: solid 1px #ddd;
        background: #fff;
        margin: 10px 0;
    }

    .form-settings .create-settings {
        display: inline-flex;
        padding: 5px 10px;
        border: solid 1px #000;
        background: #000;
        color: #fff !important;
        text-decoration: none !important;
        width: 200px;
        margin-top: 10px;
    }
</style>

<h3>CurrentEvent Plugin-Settings</h3>
<?php
global $SITEURL;
global $GSADMIN;

$file = GSDATAOTHERPATH . 'current-events/settings/settings.json';

if (file_exists($file)) {
    $fileJson = json_decode(file_get_contents($file));
};

?>

<a href="<?php echo $SITEURL . $GSADMIN; ?>/load.php?id=current-events" class="btn">Back to list</a>


<form class="form-settings" method="POST">

    <label for="">Lang. shortcode</label>
    <input type="text" name="locale" placeholder="en" <?php
                                                        if (file_exists($file)) {
                                                            echo 'value="' . $fileJson->locale . '"';
                                                        }; ?>>


    <label for="">Grid Display</label>
    <select name="initialView" class="initialView" id="">
        <option value="dayGridMonth">dayGridMonth</option>
        <option value="dayGridWeek">dayGridWeek</option>
        <option value="dayGridDay">dayGridDay</option>
        <option value="listDay">listDay</option>
        <option value="listWeek">listWeek</option>
        <option value="listMonth">listMonth</option>
        <option value="listYear">listYear</option>

    </select>

    <label for="">First day</label>
    <select name="firstday" class="firstday">
        <option value="1">Monday</option>
        <option value="2">Tuesday</option>
        <option value="3">Wednesday</option>
        <option value="4">Thursday</option>
        <option value="5">Friday</option>
        <option value="6">Saturday</option>
        <option value="0">Sunday</option>

    </select>


    <label for="">Default background color</label>
    <input type="color" class="backgroundColor" name="backgroundColor">

    <label for="">Default text color</label>
    <input type="color" class="textColor" name="textColor">


    <?php if (file_exists($file)) {

        echo '<script>document.querySelector(".initialView").value = "' . $fileJson->initialView . '"</script>';
        echo '<script>document.querySelector(".firstday").value = "' . $fileJson->firstDay . '"</script>';
        echo '<script>document.querySelector(".backgroundColor").value = "' . $fileJson->backgroundColor . '"</script>';
        echo '<script>document.querySelector(".textColor").value = "' . $fileJson->textColor . '"</script>';
    }; ?>


    <label for="">Show header nav</label>
    <select name="header" class="header-input" id="">
        <option value="true">Yes</option>
        <option value="false">No</option>
    </select>

    <?php if (file_exists($file)) {
        echo '<script>document.querySelector(".header-input").value = "' . $fileJson->header . '"</script>';
    }; ?>

    <input type="submit" name="create-settings" class="create-settings" value="save settings">
</form>