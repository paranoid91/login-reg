<div class="profile-container">
    <div class="logout-wr">
        <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="POST" name="logout" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
            <div class="logout-input">
                <input type="hidden" value="<?=clearStr($_SESSION["token"])?>" name="token" />
                <input type="submit" name="logout" value="<?=clearStr($GLOBALS["trans"]["logout"])?>" />
            </div>
        </form>
    </div>
    <div class="user-main-info">
        <div class="prof-left">
            <div class="prof-bg" style="background-image: url('<?=( !file_exists($user["photo"]) ) ? "img/no-avatar.jpg" : $user["photo"] ?>');"></div>
        </div>
        <div class="prof-right">
            <div class="user-info">
                <h1 class="usr-hdl"><?=clearStr($GLOBALS["trans"]["userinfo"])?>:</h1>
                <div class="user-data user-name">
                    <h2><span class="usr-dt-type"><?=clearStr($GLOBALS["trans"]["name"])?>:</span> <?=$user["name"]?>&nbsp;<?=$user["surname"]?>&nbsp;<?=$user["middlename"]?></h2>
                </div>
                <div class="user-data">
                    <h2><span class="usr-dt-type"><?=clearStr($GLOBALS["trans"]["gender"])?>:</span> <?=($user["gender"] == 1 ? "Male" : "Female")?></h2>
                </div>
                <div class="user-data user-birth">
                    <h2><span class="usr-dt-type"><?=clearStr($GLOBALS["trans"]["dateofbirth"])?></span> <?=$user["birth_date"]?></h2>
                </div>
                <div class="user-data user-city">
                    <h2><span class="usr-dt-type"><?=clearStr($GLOBALS["trans"]["city"])?>:</span> <?=$user["city"]?></h2>
                </div>
                <div class="user-data">
                    <h2><span class="usr-dt-type"><?=clearStr($GLOBALS["trans"]["mobnum"])?>:</span> <?=$user["mob_number"]?></h2>
                </div>
                <div class="user-data">
                    <h2><span class="usr-dt-type"><?=clearStr($GLOBALS["trans"]["phonenum"])?>:</span> <?=$user["phone_number"]?></h2>
                </div>
                <div class="user-data">
                    <h2><span class="usr-dt-type"><?=clearStr($GLOBALS["trans"]["email"])?>:</span> <?=$user["mail"]?></h2>
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <div class="user-texts-wr">
            <div class="text-holder">
                <h1 class="usr-hdl"><?=clearStr($GLOBALS["trans"]["education"])?></h1>
                <span><?=$user["education"]?></span>
            </div>
            <div class="text-holder">
                <h1 class="usr-hdl"><?=clearStr($GLOBALS["trans"]["work"])?></h1>
                <span><?=$user["work_exp"]?></span>
            </div>
            <div class="text-holder">
                <h1 class="usr-hdl"><?=clearStr($GLOBALS["trans"]["additional"])?></h1>
                <span><?=$user["add_info"]?></span>
            </div>
        </div>
    </div>
</div>