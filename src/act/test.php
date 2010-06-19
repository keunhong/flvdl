<?php
$html =  file_get_contents("http://youtube.com/watch?v=_hwQaOpscso");
preg_match("/video_id=\S+&.+&t=.+&hl/i",$html,$matches);

echo "http://www.youtube.com/get_video?".$matches[0];

?>