<?php
/*
    *
    GENERATE MAIL FOOTER 1.1
    code by Julian Cenkier
    # http://cenkier.h2g.pl/julian
    *
*/
function urlCheck($url){
    $f=@file_get_contents($url, FALSE, NULL, 0, 16);
    if ($f===false)return false;
    return true;
}
    /*
        START
    */
$f = basename($_SERVER["SCRIPT_FILENAME"],'.php');
$protocol = (isset($_SERVER['HTTPS'])?'s':'');
$uri = 'http'.$protocol.'://'.$_SERVER['HTTP_HOST'].'/';
$imgf = $uri . $f . '_background';
$img = $imgf .'.png';
if ( urlCheck($img) === false ) {
    $img = $imgf .'.jpg';
}
$set = $f . '_cfg.php';
if (urlCheck($uri . $set)!==false) {
    $sett = include $set;
}else{
    echo 'No config file found !';
    exit();
}
/*
    Settings
*/
$html = array(
    'bodysa'=>'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><meta name="viewport" content="initial-scale=1.0"><meta name="format-detection" content="telephone=no">',
    'bodysb'=>'</head><body>'
);
$twidth = $sett['table']['twidth'];
$theight = $sett['table']['theight'];
$addheight = $sett['table']['uheight'];
$label = $sett['label'];
$form = $sett['form'];
$sett['table']['image'] = $img;
    /*
        prepare template
    */
    foreach($sett['html'] as $k=>$v){ $html[$k] = $v; }
    $html['bodye'] = '</body></html>';
    foreach($html as $k=>$v){
        foreach($sett['table'] as $ki=>$vi){
            $s = '{'.$ki.'}';
            $v = str_replace($s,(string)$vi, $v);
        }
        $html[$k] = (string)$v;
    }
/*
    -> page body
*/
?>
<?=$html['bodysa']?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js" integrity="sha512-OqcrADJLG261FZjar4Z6c4CfLqd861A3yPNMb+vRQ2JwzFT49WT4lozrh3bcKxHxtDTgNiqgYbEUStzvZQRfgQ==" crossorigin="anonymous"></script>
<style>
    html, body {margin: 0;padding: 0;height: 100%;}
    a,a:hover,a:focus,a:active,a:visited,.btn,.btn:hover,.btn:focus,.btn:visited,.btn:active{outline: 0 !important;text-decoration:none;border:0;}
    .jumbotron{margin:0;background-color:#ddd;}
    .preview, #previewImage{padding:2em 0;}
    #previewHtml{width:<?=$twidth?>px;height:<?=$theight+$addheight?>px;display:block;background-color:#fff;}
</style>
<script>
const copyToClipboard = str => {
    const el = document.createElement('textarea');
    el.value = str;
    el.setAttribute('readonly', '');
    el.style.position = 'absolute';
    el.style.left = '-9999px';
    document.body.appendChild(el);
    const selected = document.getSelection().rangeCount > 0 ? document.getSelection().getRangeAt(0) : false;
    el.select();
    document.execCommand('copy');
    document.body.removeChild(el);
    if (selected) {
        document.getSelection().removeAllRanges();
        document.getSelection().addRange(selected);
    }
};
var html = <?=json_encode($html, JSON_PRETTY_PRINT)?>;

function formatPhoneNumber(phone) {
    phone = phone.replace(/[^\d]/g, "");
    if (phone.substring(0,1) == '0') {
        phone = phone.substring(1);
        // if 0523451122 -> 52 345 11 22
        return phone.replace(/(\d{2})(\d{3})(\d{2})(\d{2})/, "$1 $2 $3 $4");
    }else{
        // if 111222333 -> 111 222 333
        return phone.replace(/(\d{3})(\d{3})(\d{3})/, "$1 $2 $3");
    }
}
function capitalize(str) {
    let result = str[0].toUpperCase();
    for (let i = 1; i <str.length; i++) {
        if(str[i-1] === ' ') {
            result += str[i].toUpperCase();
        } else {
            result += str[i].toLowerCase();
        }
    }
    return result;
}

function getScreenshotOfElement(element, posX, posY, width, height, callback) {
    html2canvas(element, {
        onrendered: function (canvas) {
            var context = canvas.getContext('2d');
            var imageData = context.getImageData(posX, posY, width, height).data;
            var outputCanvas = document.createElement('canvas');
            var outputContext = outputCanvas.getContext('2d');
            outputCanvas.width = width;
            outputCanvas.height = height;

            var idata = outputContext.createImageData(width, height);
            idata.data.set(imageData);
            outputContext.putImageData(idata, 0, 0);
            callback(outputCanvas.toDataURL().replace("data:image/png;base64,", ""));
        },
        width: width,
        height: height,
        useCORS: true,
        taintTest: false,
        allowTaint: false
    });
}

$(function(){
    /*
        Life input and format fields: phone and name
    */
    $('#tinput input').on('keyup',function(){
        field = $(this).attr('id');
        v = $(this).val().trim();
        if (field == 'phone') {
            v = formatPhoneNumber(v);
        }else if (field == 'name') {
            v = capitalize(v);
        }
        $('#htmllive .'+field).html(v);
        if (typeof html[field] != "undefined") {
            html[field] = v;
        }
    });
    /*
        Copy html markup
    */
    $('#copyto').on('click',function(){
        h = '';
        ht = html;
        ht['bodysa'] = '';
        ht['bodysb'] = '';
        ht['bodye'] = '';
        for( i in ht) {
                h = h + html[i];
        }
        copyToClipboard(h);
    });
    /*
        Screenshot image from div and trigger download
    */
    $('#makeimg').on('click',function(){
        getScreenshotOfElement($("#previewHtml").get(0), 0, 0, <?=$twidth?>, <?=$theight+$addheight?>, function(data) {
            // in the data variable there is the base64 image
            // exmaple for displaying the image in an <img>
            header = "data:image/png;base64,";
            $("#captured").attr("src", header+data);
            $("#capturedlink").attr("href", header+data).attr("download", $('#tinput input#name').val().replace(/\s/g, '')+"_mail.png");
            $("#capturedlink")[0].click();
        });
    });
    /*
        Refresh fields if they in case not empty
    */
    var e = $.Event( "keyup", { which: 27 } );
    $('#tinput input').each( function(){ $(this).trigger(e); })
    $('#captured').attr( "height", $('#previewHtml').height() );
    $('#captured').attr( "width", $('#previewHtml').width() );
});
</script>

<?=$html['bodysb']?>

<div class="jumbotron">
<section class="container">

<div class="page-header">
  <h2><?=$form['header']?><span class="badge"><?=$sett['version']?></span><small><?=$form['headersml']?></small></h2>
</div>

<div  id="tinput">
    <?php
        $h = '';
        foreach( $html as $k=>$v){
            if (strpos($k,'body')===false){
                $v = '<div class="form-group"><label for="'.$k.'" class="text-label">'.$label[$k].'</label><input type="text" class="form-control" name="'.$k.'" access="false" id="'.$k.'" value="'.$v.'"></div>';
                $h = $h . $v;
            }
        }
        echo $h;
    ?>
</div>
</section>
</div>

<div class="preview">
<div class="container">
<section>
<button type="button" class="btn-primary btn-lg btn" name="copyto" access="false" style="default" id="copyto"><?=$form['btnhtml']?></button>&nbsp;
<button type="button" class="btn-success btn-lg btn" name="makeimg" access="false" style="default" id="makeimg"><?=$form['btnimg']?></button>
<hr />
<p> </p>
</section>

<?php
/*
    Build template and put live plugs
*/
$h = '<section id="htmllive"><p class="badge">'.$form['badgehtml'].'</p><div id="previewHtml">';
foreach( $html as $k=>$v){
    if (strpos($k,'body')===false){
        $v = '<span class="'.$k.'">' . $v .'</span>';
    }
    $h = $h . $v;
}
$h = $h . '</div></section>';
echo $h;
echo '<section id="previewImage"><p class="badge">'.$form['badgeimg'].'</p><div>';
echo '<a id="capturedlink" href="" download=""><img src="" id="captured" width="" height=""></img></a></div></section>';
?>
</div></div>
<?=$html['bodye']?>
