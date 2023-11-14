<style>
   .btn {
        display: inline-flex;
        padding: 5px 10px;
        border: solid 1px #000;
        background: #000;
        color: #fff !important;
        text-decoration: none !important;
    }
</style>

<h3>CurrentEvent Plugin-How use?</h3>
<a href="<?php
global $SITEURL;
global $GSADMIN;
echo $SITEURL . $GSADMIN; ?>/load.php?id=current-events" class="btn">Back to list</a>
<br><br>
<p>Put this shortcode ond content</p>
<code style="width:100%;border:solid 1px #ddd; background:#fafafa;display:block;padding:10px;margin:10px 0;">[% ce %]</code>
or on your template
<code style="width:100%;border:solid 1px #ddd; background:#fafafa;display:block;padding:10px;margin:10px 0;">&lt;?php showEventCalendar() ;?&gt;</code>