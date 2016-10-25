<h1 class="top-form-headline"><?=clearStr($GLOBALS["trans"]["signup"])?></h1>
<div class="form-wrapper reg-form">
    <?php
        if(isset($_SESSION["err"]))
        {
            echo "<div class='errors-wrapper'><ul>";
            foreach($_SESSION["err"] as $error)
            {
                echo "<li>{$error}</li>";
            }
            echo "</div></ul>";
            destroyMsg("err");
        }
    ?>
    <div class="req-wrap">
        <p><span class="req-sing">*</span> - <?=clearStr($GLOBALS["trans"]["req_field"])?></p>
    </div>
    <div class="form-items">
        <form action="<?php $_SERVER['PHP_SELF'];?>" name="reg-form" method="POST" enctype="multipart/form-data" accept-charset="UTF-8">
           <input type="hidden" value="<?=clearStr($_SESSION["token"])?>" name="token" />
           <div class="form-left">
               <div class="input-element reg-input">
                   <div class="lab-reg">
                       <label for="input-name"><span class="req-sing">*</span> <?=clearStr($GLOBALS["trans"]["name"])?></label>
                   </div>
                   <div class="error">
                       <div class="error-item">
                           <img src="img/warning-sign.png" alt="warning" width="11"> <?=clearStr($GLOBALS["trans"]["name"])?> <?=$GLOBALS["trans"]["name_err"]?>
                       </div>
                   </div>
                   <input type="text" name="name" id="input-name" value="<?=putValue("name")?>"/>
               </div>
               <div class="input-element reg-input add-margin">
                   <div class="lab-reg">
                       <label for="surname">
                           <span class="req-sing">*</span> <?=clearStr($GLOBALS["trans"]["surname"])?><br/>
                       </label>
                   </div>
                   <div class="error">
                       <div class="error-item">
                           <img src="img/warning-sign.png" alt="warning" width="11"> <?=clearStr($GLOBALS["trans"]["surname"])?> <?=$GLOBALS["trans"]["name_err"]?>
                       </div>
                   </div>
                   <input type="text" name="surname" id="surname" value="<?=putValue("surname")?>"/>
               </div>
               <div class="input-element reg-input add-margin">
                   <div class="lab-reg">
                       <label for="middlename">
                           <span class="req-sing">*</span> <?=clearStr($GLOBALS["trans"]["midname"])?>
                       </label>
                   </div>
                   <div class="error">
                       <div class="error-item">
                           <img src="img/warning-sign.png" alt="warning" width="11"> <?=clearStr($GLOBALS["trans"]["midname"])?> <?=$GLOBALS["trans"]["name_err"]?>
                       </div>
                   </div>
                   <input type="text" name="middlename" id="middlename" value="<?=putValue("middlename")?>"/>
               </div>
               <div class="input-element reg-input add-margin">
                   <div class="lab-reg">
                       <label for="input-pass">
                           <span class="req-sing">*</span> <?=$GLOBALS["trans"]["password"]?><br/>
                        </label>
                    </div>
                    <span class="req-desc"><?=$GLOBALS["trans"]["pass_desc"]?><br/>
                   <div class="error">
                       <div class="error-item">
                           <img src="img/warning-sign.png" alt="warning" width="11"> <?=$GLOBALS["trans"]["pass_err"]?><br/>
                       </div>
                   </div>
                   <input type="password" name="pass" id="input-pass" />
               </div>
               <div class="input-element reg-input add-margin">
                   <div class="lab-reg">
                       <label  for="input-pass-rep"><span class="req-sing">*</span> <?=clearStr($GLOBALS["trans"]["rep_pass"])?></label>
                   </div>
                   <div class="error">
                       <div class="error-item">
                           <img src="img/warning-sign.png" alt="warning" width="11"> <?=clearStr($GLOBALS["trans"]["rep_pass_err"])?>
                       </div>
                   </div>
                   <input type="password" name="pass-rep" id="input-pass-rep" />
               </div>
               <div class="input-element reg-input add-margin">
                   <div class="birth-date-wr">
                       <p class="date-birth"><span class="req-sing">*</span> <?=clearStr($GLOBALS["trans"]["dateofbirth"])?></p>
                       <div class="error">
                           <div class="error-item">
                               <img src="img/warning-sign.png" alt="warning" width="11"> <?=clearStr($GLOBALS["trans"]["selectdatebirth"])?>
                           </div>
                       </div>
                       <select class='select_date' name='month' onChange="changeDate(this.options[selectedIndex].value);">
                           <option value='na'><?=clearStr($GLOBALS["trans"]["month"])?></option>
                           <option value='1'><?=clearStr($GLOBALS["trans"]["jan"])?></option>
                           <option value='2'><?=clearStr($GLOBALS["trans"]["feb"])?></option>
                           <option value='3'><?=clearStr($GLOBALS["trans"]["mar"])?></option>
                           <option value='4'><?=clearStr($GLOBALS["trans"]["apr"])?></option>
                           <option value='5'><?=clearStr($GLOBALS["trans"]["may"])?></option>
                           <option value='6'><?=clearStr($GLOBALS["trans"]["jun"])?></option>
                           <option value='7'><?=clearStr($GLOBALS["trans"]["jul"])?></option>
                           <option value='8'><?=clearStr($GLOBALS["trans"]["aug"])?></option>
                           <option value='9'><?=clearStr($GLOBALS["trans"]["sep"])?></option>
                           <option value='10'><?=clearStr($GLOBALS["trans"]["oct"])?></option>
                           <option value='11'><?=clearStr($GLOBALS["trans"]["nov"])?></option>
                           <option value='12'><?=clearStr($GLOBALS["trans"]["dec"])?></option>
                       </select>
                       <select class='select_date' name='day' id='day'>
                           <option value='na'><?=clearStr($GLOBALS["trans"]["day"])?></option>
                       </select>
                       <select class='select_date' name='year' id='year'>
                           <option value='na'><?=clearStr($GLOBALS["trans"]["year"])?></option>
                       </select>
                   </div>
               </div>
               <div class="input-element reg-input add-margin">
                   <div class="lab-reg">
                       <label for="input-email">
                           <span class="req-sing">*</span> <?=clearStr($GLOBALS["trans"]["email"])?>
                       </label>
                   </div>
                   <div class="error">
                       <div class="error-item">
                           <img src="img/warning-sign.png" alt="warning" width="11"> <?=clearStr($GLOBALS["trans"]["mail_err"])?>
                       </div>
                   </div>
                   <input id="input-email" value="<?=putValue("mail")?>" placeholder="Example@mail.com" type="text" name="mail" />
               </div>
               <div class="input-element reg-input">
                   <div class="lab-reg">
                       <label for="reg-city">
                           &nbsp;&nbsp;&nbsp;<?=clearStr($GLOBALS["trans"]["city"])?><br/>
                       </label>
                   </div>
                   <div class="error">
                       <div class="error-item">
                           <img src="img/warning-sign.png" alt="warning" width="11"> <?=clearStr($GLOBALS["trans"]["city_err"])?>
                       </div>
                   </div>
                   <input type="text" name="city" id="reg-city" value="<?=putValue("city")?>"/>
               </div>
               <div class="input-element reg-input add-margin">
                   <div class="lab-reg">
                       <label for="mob_number">
                           &nbsp;&nbsp;&nbsp;<?=clearStr($GLOBALS["trans"]["mobnum"])?>
                       </label>
                   </div>
                   <div class="error">
                       <div class="error-item">
                           <img src="img/warning-sign.png" alt="warning" width="11"> <?=$GLOBALS["trans"]["mob_err"]?>
                       </div>
                   </div>
                   <input type="text" value="<?=putValue("mob_number")?>" name="mob_number" id="mob_number"  placeholder="<?=clearStr($GLOBALS["trans"]["onlydig"])?>" />
               </div>
               <div class="input-element reg-input add-margin">
                   <div class="lab-reg">
                       <label  for="mob_number">
                           &nbsp;&nbsp;&nbsp;<?=$GLOBALS["trans"]["phonenum"]?>
                       </label>
                   </div>
                   <div class="error">
                       <div class="error-item">
                           <img src="img/warning-sign.png" alt="warning" width="11"> <?=$GLOBALS["trans"]["phone_err"]?>
                       </div>
                   </div>
                   <input type="text" value="<?=putValue("phone_number")?>" name="phone_number" placeholder="<?=clearStr($GLOBALS["trans"]["onlydig"])?>" id="phone_number"/>
               </div>
           </div>
            <div class="form-right">
                <div class="input-element reg-input radio-element">
                    <span class="req-sing">*</span> <?=clearStr($GLOBALS["trans"]["gender"])?><br/>
                    <fieldset id="checkMartial">
                        <input type="radio" name="gender" value="1"/> <?=clearStr($GLOBALS["trans"]["male"])?> <br>
                        <input type="radio" name="gender" value="0"/> <?=clearStr($GLOBALS["trans"]["female"])?>
                    </fieldset>
                </div>
                <div class="input-element add-margin">
                    <div class="lab-reg">
                        <label for="education">
                            <?=clearStr($GLOBALS["trans"]["education"])?>
                        </label>
                    </div>
                    <div class="error">
                        <div class="error-item">
                            <img src="img/warning-sign.png" alt="warning" width="11"> <?=$GLOBALS["trans"]["textar_err"]?>
                        </div>
                    </div>
                    <textarea cols="40" rows="10" name="education" class="text-ar add-margin" id="education"><?=putValue("education")?></textarea>
                </div>
                <div class="input-element add-margin">
                    <div class="lab-reg">
                        <label for="work_exp">
                            <?=clearStr($GLOBALS["trans"]["work"])?>
                        </label>
                    </div>
                    <div class="error">
                        <div class="error-item">
                            <img src="img/warning-sign.png" alt="warning" width="11"> <?=$GLOBALS["trans"]["textar_err"]?>
                        </div>
                    </div>
                    <textarea  cols="40" rows="10" name="work_exp" class="text-ar add-margin" id="work_exp"><?=putValue("work_exp")?></textarea>
                </div>
                <div class="input-element add-margin">
                    <div class="lab-reg">
                        <label for="add_info">
                            <?=clearStr($GLOBALS["trans"]["additional"])?>
                        </label>
                    </div>
                    <div class="error">
                        <div class="error-item">
                            <img src="img/warning-sign.png" alt="warning" width="11"> <?=$GLOBALS["trans"]["textar_err"]?>
                        </div>
                    </div>
                    <textarea cols="40" rows="10" name="add_info" class="text-ar add-margin" id="add_info"><?=putValue("add_info")?></textarea>
                </div>
                <div class="input-element add-margin file-upload">
                    <p><?=clearStr($GLOBALS["trans"]["upload"])?></p>
                    <div class="error">
                        <div class="error-item">
                            <img src="img/warning-sign.png" alt="warning" width="11"> <?=$GLOBALS["trans"]["photo_err"]?>
                        </div>
                    </div>
                    <input type="file" name="photo" id="file_upload" accept="image/*,image/jpeg,image/png,image/gif" />
                </div>
            </div>
            <div class="submit-element add-margin clear">
                <input type="submit" value="<?=$GLOBALS["trans"]["submit"]?>" name="reg" />
            </div>
        </form>
    </div>
</div>
<script>
    //define how many days should be in date of birth select list
    function changeDate(i){

        var e = document.getElementById('day');
        var k;

        while(e.length > 0) {
            e.remove(e.length - 1);
        }

        var j=-1;

        if(i == "na")
            k = 0;
        else if(i ==2)
            k = 28;
        else if(i == 4|| i== 6|| i== 9|| i == 11)
            k = 30;
        else
            k = 31;

        while(j++ < k){

            var s = document.createElement('option');
            var e = document.getElementById('day');

            if(j == 0){
                s.text = "Day";
                s.value = "na";
                try{
                    e.add(s,null);
                } catch(ex){
                    e.add(s);
                }
            }
            else{
                s.text = j;
                s.value = j;
                try{
                    e.add(s,null);
                } catch(ex){
                    e.add(s);
                }
            }
        }
    }
    var y = 2017;

    while (y-->1900){
        var s = document.createElement('option');
        var e = document.getElementById('year');
        s.text = y;
        s.value = y;
        try{
            e.add(s,null);
        } catch(ex){
            e.add(s);
        }
    }

</script>