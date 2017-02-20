<!DOCTYPE HTML>
<html>
<head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
    <script type="text/javascript" src="{{asset('plugins/ueditor/dialogs/internal.js')}}"></script>
    <link rel="stylesheet" href="{{asset('plugins/ueditor/dialogs/template/template.css')}}" type="text/css" />
</head>
<body>
    <div class="wrap">
        <div class="left">
            <div class="top">
                <label><var id="lang_template_clear"></var>：<input id="issave" type="checkbox"></label>
            </div>
            <div class="bottom border_style1" id="preview"></div>
        </div>
        <fieldset  class="right border_style1">
            <legend><var id="lang_template_select"></var></legend>
            <div class="pre" id="preitem"></div>
        </fieldset>
        <div class="clear"></div>
    </div>
    <script type="text/javascript" src="{{asset('plugins/ueditor/dialogs/template/config.js')}}"></script>
    <script type="text/javascript" src="{{asset('plugins/ueditor/dialogs/template/template.js')}}"></script>

</body>
</html>
