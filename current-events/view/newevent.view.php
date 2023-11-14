<style>
    .btn {
        display: inline-flex;
        padding: 5px 10px;
        border: solid 1px #000;
        background: #000;
        color: #fff !important;
        text-decoration: none !important;
    }

    .current-event-form {
        margin-top: 10px;
        background: #fafafa;
        border: solid 1px #ddd;
        padding: 10px;
    }

    .current-event-form input {
        width: 100%;
        padding: 5px;
        margin: 10px 0;
    }

    .current-event-form textarea {
        width: 100%;
        height: 150px;
        margin-bottom: 10px;
    }

    .current-event-form label {
        padding: 5px 0;
    }

    .submit-event {
        background: #000;
        color: #fff;
        border: solid 1px;
        padding: 10px 15px;
    }
</style>

<h3>CurrentEvent Plugin - Add new event</h3>
<?php
global $SITEURL;
global $GSADMIN;; ?>
<a href="<?php echo $SITEURL . $GSADMIN; ?>/load.php?id=current-events" class="btn">Back to list</a>


<?php if (isset($_GET['edit'])) {
    $file = file_get_contents(GSDATAOTHERPATH . 'current-events/' . $_GET['edit'] . '.json');
    $fileJS = json_decode($file);
}; ?>

<form method="post" class="current-event-form">

    <label for="title-current-event">Title (Required)</label>
    <input type="text" name="title-current-event" required <?php if (isset($_GET['edit'])) {
                                                                echo 'value="' . $fileJS->eventname . '"';
                                                            }; ?>>
    <label for="description-current-event">Description </label>
    <textarea name="description-current-event">
<?php if (isset($_GET['edit'])) {
    echo $fileJS->eventdescription;
}; ?>
</textarea>
    <label for="start-date">Start Date Event (Required)</label>
    <input type="datetime-local" name="start-date" required <?php if (isset($_GET['edit'])) {
                                                        echo 'value="' . $fileJS->start . '"';
                                                    }; ?>>
    <label for="end-date">End Date Event (Required)</label>
    <input type="datetime-local" name="end-date" required <?php if (isset($_GET['edit'])) {
                                                    echo 'value="' . $fileJS->end . '"';
                                                }; ?>>
    <label for="end-date">Color Event (Required)</label>
    <input type="color" name="color-current-event" required <?php if (isset($_GET['edit'])) {
                                                                echo 'value="' . $fileJS->color . '"';
                                                            }; ?>>

    <label for="end-date">Color text (Required)</label>
    <input type="color" name="color-current-text" required <?php if (isset($_GET['edit'])) {
                                                                echo 'value="' . $fileJS->colortext . '"';
                                                            }; ?>>

    <label for="url-current-event">Link to event (optional)</label>
    <input type="text" name="url-current-event" <?php if (isset($_GET['edit'])) {
                                                    echo 'value="' . @$fileJS->url . '"';
                                                }; ?>>
    <button type="submit" name="create-event" class="submit-event">Save Event</button>
</form>