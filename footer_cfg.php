<?php
return array(
    'version' => 'company',
    'table' => array(
        'twidth' => 600,
        'theight' => 100,
        'uheight' => 26,
        'adress' => '<b>companyname</b> adress',
        'prefix' => '+48 ',
    ),
    'label' => array(
        "name" => "Name",
        "phone" => "Phone",
        "adress" => "Adress",
    ),
    'html' => array(
        'bodyc0'=>'<table style="height:{theight}px;border:none;font-family: Arial, Helvetica, sans-serif;" width="{twidth}" cellspacing="0" cellpadding="0"><tbody><tr><td style="font-size: 16px;background:white url({image}) center center no-repeat;"><p style="padding-left:34px;color:#fff;padding-bottom:10px"><span style="text-transform: uppercase; font-size: 24px;">',
        'name'=> '',
        'bodyc1'=>'</span><br><span>{prefix}',
        'phone'=>'',
        'bodyc2'=>'</span></p></td></tr></tbody></table><table style="border:none;font-family: Arial, Helvetica, sans-serif;" width="{twidth}" cellspacing="0" cellpadding="0"><tbody><tr><td><p style="padding:4px 0 4px 36px;font-size:12px;border-bottom:1px solid #999;margin:0;">',
        'adress'=> '{adress}',
        'bodyc3'=>'</p></td></tr></tbody></table>',
    )
);
?>
