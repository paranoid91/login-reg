    "use strict";

$(document).ready(function(){
    
    //login button hover
    if($(".submit-element input").length > 0){

        $(".submit-element input").hover(function() {
            $(this).stop(true, true).animate({ backgroundColor: "#884dff" }, 200);
        }, function() {
            $(this).stop(true, true).animate({ backgroundColor: "#aa80ff" }, 200);
        });
    }


    //validate registration
    if( $("div.reg-form").length > 0){

        //validate name
        $("#input-name, #middlename, #surname").each(function () {
            $(this).blur(function(){
                var element = $(this);
                var val = $(this).val();
                validateStr( element, val, 2, 50, /^[a-zA-Z-\']+$/);
            });
        });

        //validate password
        $("#input-pass").blur(function () {
            var element = $(this);
            var val = $(this).val();
            validateStr( element, val, 8, 200, /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/);
        });

        //check if passwords match each other
        $("#input-pass-rep").blur(function () {

            if($("#input-pass").val() != "" && $("#input-pass").val() !== $("#input-pass-rep").val()){
                $(this).siblings("div.error").fadeIn();
                $(this).css({ borderColor: "red", borderWidth : "2px", borderStyle: "solid"});
            } if($("#input-pass").val().trim() == "" || $("#input-pass").val().trim() == " ") {
                $(this).siblings("div.error").fadeIn();
                $(this).css({borderColor: "red", borderWidth: "2px", borderStyle: "solid"});
            } else {
                $(this).siblings("div.error").fadeOut();
                $(this).css({ borderColor: "transparent", borderWidth : "0", borderStyle: "solid"});
            }
        });

        $("#input-email").blur(function () {
            var element = $(this);
            var val = $(this).val();
            validateStr( element, val, 7, 100, /^[^\s@]+@[^\s@]+\.[^\s@]+$/);
        });

        //check phone numbers
        $("#mob_number, #phone_number").blur(function () {
            var element = $(this);
            var val = $(this).val();
            if(val.trim().length > 0){
                validateStr( element, val, 6, 30, /^\d+$/);
            }
        });

        //check city name
        $("#reg-city").blur(function () {

            if($("#reg-city").val().trim().length > 0){
                validateStr($(this), $(this).val(), 0, 50, /^[a-zA-Z-\'\s]+$/);
            }
        });

        //check textareas
        $("#education, #work_exp, #add_info").each(function () {
            $(this).blur(function(){
                if($(this).val().length > 1000){
                    $(this).siblings("div.error").fadeIn();
                    $(this).css({ borderColor: "red", borderWidth : "2px", borderStyle: "solid"});
                } else {
                    $(this).siblings("div.error").fadeOut();
                    $(this).css({ borderColor: "#bfbfbf", borderWidth : "1px", borderStyle: "solid"});
                }
            });
        });
            
        //disabled submit button after one click
        $('form.reg-form').submit(function() {
            $(this).find("button[type='submit']").prop('disabled',true);
        });

        $("#file_upload").on('change', function() {
            if(this.files[0].size > 2000000 ){
                $(this).siblings("div.error").fadeIn();
                $(this).css({ borderColor: "red", borderWidth : "2px", borderStyle: "solid"});
            } else if(this.files[0].type != "image/jpeg" && this.files[0].type != "image/png" && this.files[0].type != "image/gif"){
                $(this).siblings("div.error").fadeIn();
                $(this).css({ borderColor: "red", borderWidth : "2px", borderStyle: "solid"});
            } else {
                $(this).siblings("div.error").fadeOut();
                $(this).css({ borderColor: "transparent", borderWidth : "0", borderStyle: "solid"});
            }
        });
    }

    //validate name, surname, middle name, passwords, email
    function validateStr(element, input, min_length, max_length, pattern){

        if(typeof element == "undefined"){
            return false;
        }

        if( input.length < min_length || input.length > max_length || !(pattern.test(input)) ){
            $(element).siblings("div.error").fadeIn();
            $(element).css({ borderColor: "red", borderWidth : "2px", borderStyle: "solid"});
        } else {
            $(element).siblings("div.error").fadeOut();
            $(element).css({ borderColor: "transparent", borderWidth : "0", borderStyle: "solid"});
        }
    }

});