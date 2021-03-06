
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */

// Vue.component('example', require('./components/Example.vue'));

// Vue.component('reservationsteptwo', require('./components/ReservationStepTwo.vue'));

// const app = new Vue({
//     el: '#vue'
// });

$(function () {
    $(".slides").slidesjs({
        pagination: {
            active: false,
        },
        width: 940,
        height: 528
    });
});

$(document).ready(function () {
    $('.submit-btn').click(function () {
        $(this).addClass('loading');
        $('.cancable').addClass('disabled');
        $('.cancable').prop('disabled', true);
    });
});

$(document).ready(function () {
    $('.toast-clear').click(function () {
        $(".toast").fadeOut(400);
    });
});

$(document).ready(function () {
    $('.modal-clear').click(function () {
        $(".modal").removeClass('active');
    });
});

$(document).ready(function () {
    $('.modal-open').click(function () {
        $('.modal').addClass('active');
    });
});

$(document).ready(function () {
    $(".mobileIcon").click(function () {
        $(".mobile-menu").toggle();
    });
});

$(document).ready(function () {
    $('select[name=res_week1]').change(function () {
        var obj = $('select[name=res_week1]').val();
        var result = jQuery.parseJSON(obj);
        $.each(result, function (key, value) {
            $("#weekOne").html(result.week);
            $("#priceOne").html(result.prijs);
            $("#in").html(result.in);
            $("#uit").html(result.uit);
        });
    });
});


$(document).ready(function () {
    $('select[name=res_week2]').change(function () {
        var obj = $('select[name=res_week2]').val();
        var result = jQuery.parseJSON(obj);
        $.each(result, function (key, value) {
            $("#weekTwo").html(result.week_two);
            $("#priceTwo").html(result.prijs_two);
            $("#inTwo").html(result.in_two);
            $("#uitTwo").html(result.uit_two);
        });
    });
});
