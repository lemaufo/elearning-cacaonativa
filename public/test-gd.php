<?php
echo function_exists('imagecreatefrompng') ? 'GD OK' : 'GD NO';
echo '<br>';
echo extension_loaded('gd') ? 'Extension OK' : 'Extension NO';