/**
 * PEP Capping 2017 Algozzine's Class
 *
 * Form helping functions for form validation/submission/other logic
 *
 * This JS file is used to store functions needed for the forms to properly submit and display their data.
 *
 * @author Christian Menk and Stephen Bohner
 * @copyright 2017 Marist College
 * @version 0.3.3
 * @since 0.3.2
 */

$(document).ready(function(){
    initMask();
    $('input:required')
        .on('input', function() {
            validation($(this));
        })
        .on('focusin', function() {
            validation($(this));
        });
});

function initMask(){
    $('.mask-zip').mask('00000');
    $('.mask-phone').mask('(000) 000-0000');
}

function submitAll(){
    var fname = document.getElementById("pers_firstname");
    var lname = document.getElementById("pers_lastname");
    var refEmail = document.getElementById("ref_email");
    var reqForm = document.getElementById("participant_info");

    if (reqForm.checkValidity() == false) {
        document.getElementById("pers_title").focus();
        reqForm.classList.add("was-validated");
        if(lname.value.length === 0)
            lname.focus();
        if(fname.value.length === 0 )
            fname.focus();
    } else {
        reqForm.submit();
    }
}

function submitAllSelf(){
    var self_fname = document.getElementById("self_pers_firstname");
    var self_lname = document.getElementById("self_pers_lastname");
    var self_form = document.getElementById("self_participant_info");
    // Handles all validation when the user hits the submit button.
    if (self_form.checkValidity() === false) {
        document.getElementById("self_pers_title").focus();
        if(self_lname.value.length === 0)
            self_lname.focus();
        if(self_fname.value.length === 0)
            self_fname.focus();
    } else {
        self_form.submit();
    }
}

// Hides or displays the error message accordingly.
function validation(el){
    if (el.val().length !== 0) {
        el.removeClass('is-invalid');
    } else {
        el.addClass('is-invalid');
    }
}

// Functions for navigating through cards.
function section1(){
    $('#collapse1').collapse('show');
    $('#collapse2').collapse('hide');
    $('#collapse3').collapse('hide');
    $('#collapse4').collapse('hide');
    $('#collapse5').collapse('hide');
}

function section2(){
    $('#collapse1').collapse('hide');
    $('#collapse2').collapse('show');
    $('#collapse3').collapse('hide');
    $('#collapse4').collapse('hide');
    $('#collapse5').collapse('hide');
}

function section3(){
    $('#collapse1').collapse('hide');
    $('#collapse2').collapse('hide');
    $('#collapse3').collapse('show');
    $('#collapse4').collapse('hide');
    $('#collapse5').collapse('hide');
}

function section4(){
    $('#collapse1').collapse('hide');
    $('#collapse2').collapse('hide');
    $('#collapse3').collapse('hide');
    $('#collapse4').collapse('show');
    $('#collapse5').collapse('hide');
}

function section5(){
    $('#collapse1').collapse('hide');
    $('#collapse2').collapse('hide');
    $('#collapse3').collapse('hide');
    $('#collapse4').collapse('hide');
    $('#collapse5').collapse('show');
}