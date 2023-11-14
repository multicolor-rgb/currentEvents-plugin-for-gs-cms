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

    .event-items {
        width: 100%;
        list-style-type: none;
        margin: 10px 0 !important;
    }

    .event-item {
        box-sizing: border-box;
        padding: 5px;
        align-items: center;
        margin: 0;
        background: #fafafa;
        border: solid 1px #ddd;
        display: grid;
        grid-template-columns: 1fr 100px 100px;
    }
</style>

<h3>CurrentEvent Plugin</h3>
<?php
global $SITEURL;
global $GSADMIN; ?>

<a href="<?php echo $SITEURL . $GSADMIN; ?>/load.php?id=current-events&addevent" class="btn">Add Event</a>
<a href="<?php echo $SITEURL . $GSADMIN; ?>/load.php?id=current-events&settings" class="btn">Settings Calendar</a>
<a href="<?php echo $SITEURL . $GSADMIN; ?>/load.php?id=current-events&howto" class="btn">How to use it?</a>

<ul class="event-items">
    <?php
    if (!empty(glob(GSDATAOTHERPATH . 'current-events\*.json'))) {


        foreach (glob(GSDATAOTHERPATH . 'current-events\*.json') as $key => $file) {

            $data = json_decode(file_get_contents($file));

            echo '<li class="event-item"><b>' . $data->eventname . '</b> <a href="' . $SITEURL . $GSADMIN . '/load.php?id=current-events&addevent&edit=' . pathinfo($file)['filename'] . '" class="btn-sm">Edit</a>
            <a href="' . $SITEURL . $GSADMIN . '/load.php?id=current-events&delete=' . pathinfo($file)['filename'] . '" class="btn-sm btn-sm-red">Delete</a></li>';
        };
    };; ?>

</ul>