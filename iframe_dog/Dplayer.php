<?php
  $video = $_SERVER["QUERY_STRING"];
  $video_danma =md5($video);

echo <<<EOF
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Access-Control-Allow-Origin" content="*" />
<meta charset="UTF-8">
    <style type="text/css">
    html,body{padding: 0;  
    margin: 0;  
    height: 100%;  
    overflow:hidden;  }
	#dplayer  
{  
    height: 100%;  
    z-index: 0;  
} 
    </style>
        <title>Dplayer</title>
</head>
 <body>
 <link class="dplayer-css" rel="stylesheet" href="./Dplayer/DPlayer.min.css">
 <script src="./Dplayer/DPlayer.min.js"></script>
<div id="dplayer"></div>
<script type="text/javascript">
 const dp = new DPlayer({
    container: document.getElementById('dplayer'),
    screenshot: false,
    video: {
        url: '$video',
        pic: '',
        thumbnails: ''
    },

    danmaku: {
        id: '$video_danma',
        api: 'https://api.prprpr.me/dplayer/'
    }
    
});
</script>
</body>
</html>
EOF;
?>