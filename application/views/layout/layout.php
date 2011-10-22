<!DOCTYPE html>
<html lang="en">
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta charset="utf-8" />
	<title>750 palabras</title>

        <link rel="stylesheet" href="/css/reset.css" type="text/css" media="all" />
        <link rel="stylesheet" href="/css/style.css" type="text/css" media="all" />
        <script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
        <script type="text/javascript" src="/js/functions.js"></script>
        <script type="text/javascript" src="/js/jquery.wordcount.js"></script>
        <script type="text/javascript" src="/js/jquery.autoresize.js"></script> <!-- https://github.com/jamespadolsey/jQuery.fn.autoResize -->
        <script type="text/javascript" src="/js/calendarPicker/jquery.calendarPicker.js"></script>
        <link rel="stylesheet" href="/js/calendarPicker/jquery.calendarPicker.css" type="text/css" media="all" />
        <script type="text/javascript" src="/js/tipsy/js/jquery.tipsy.js"></script>
        <link rel="stylesheet" href="/js/tipsy/css/tipsy.css" type="text/css" media="all" />
        <link href="/images/pen.png" rel="shortcut icon" type="image/png" />

</head>
<body>
    <?php if( $this->session->flashdata('feedback') ){
        $fb = $this->session->flashdata('feedback');
    ?>
    <div class="dvMsg <?php if($fb['error']) echo 'dvError'; ?>">
        <?=$fb['message']?>
        <a href="/" title="Cerrar">X</a>
    </div>
    <?php } ?>
    <div id="dvWrapper">
        <header id="dvHeader">
            <span class="spSup"><a href="/" class="aFooterHeader aHome" title="Ir a inicio">Inicio</a></span>
            <span class="spSub"><a href="/welcome/about" class="aFooterHeader aAbout" title="Acerca de 750 palabras">About</a></span>
        </header>
        <div id="dvContent">
            <?=$content_for_layout?>
        </div>
    </div>
</body>
</html>