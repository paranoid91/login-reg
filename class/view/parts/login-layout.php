<h1 class="top-form-headline"><?=clearStr($GLOBALS["trans"]["signin"])?></h1>
<div class="form-wrapper">
    <?php
    if(isset($_SESSION["success"]))
    {
        echo "<div class='success-wrapper'><ul>";
        echo "<li>{$_SESSION["success"]}</li>";
        echo "</div></ul>";
        destroyMsg("success");
    }
    if(isset($_SESSION["err"]))
    {
        echo "<div class='errors-wrapper'><ul>";
        if(is_array($_SESSION["err"])) {
            foreach($_SESSION["err"] as $error)
            {
                echo "<li>{$error}</li>";
            }
        }
        else{
            echo "<li>{$_SESSION["err"]}</li>";
        }

        echo "</div></ul>";
        destroyMsg("err");
    }
    ?>
    <div class="form-items">
        <form action="" name="login-form" method="POST" enctype="application/x-www-form-urlencoded" accept-charset="UTF-8">
            <input type="hidden" value="<?=clearStr($_SESSION["token"])?>" name="token" />
            <div class="input-element">
                <input type="text" name="mail" placeholder="<?=clearStr($GLOBALS["trans"]["email"])?>" required/>
            </div>
            <div class="input-element">
                <input type="password" name="pass" placeholder="<?=clearStr($GLOBALS["trans"]["password"])?>" required/>
            </div>
            <div class="remember-element">
                <label><input type="checkbox" name="remember"><?=clearStr($GLOBALS["trans"]["remember"])?></label>
            </div>
            <div class="submit-element">
                <input type="submit" value="<?=clearStr($GLOBALS["trans"]["login"])?>" name="login"/>
            </div>
            <div class="regist-link">
                <p><?=clearStr($GLOBALS["trans"]["notreg"])?> <a href="?option=Registration"><?=clearStr($GLOBALS["trans"]["signup"])?></a></p>
            </div>
        </form>
    </div>
</div>
