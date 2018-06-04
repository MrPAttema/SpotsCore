$(document).ready(function(){
    $("#panel-old-reservations-title").click(function(){
        $("#panel-old-reservations").slideToggle("50");
    });
});

$(document).ready(function(){
    $("#location-details-button").click(function(){
        $("#panel-body-details-lower").slideToggle("50");
    });
});

$(document).ready(function(){
    $(".button-slide-next").click(function(){
        $(".reservation-step-two").slideDown("50");
        $(".hidden").css("display", "block", "!important");
        $(".reservation-step-one").slideUp("50");
    });
});

$(document).ready(function(){
    $(".button-slide-next-two").click(function(){
        $(".slide-next-panel-three").slideDown("50");
        $(".hidden-two").css("display", "block", "!important");
        $(".reservation-step-two").slideUp("50");
    });
});

$(document).ready(function(){
    $(".button-slide-prev").click(function(){
        $(".reservation-step-two").slideUp("50");
        $(".reservation-step-one").slideDown("50");
    });
});

$(document).ready(function(){
    $(".button-slide-prev-two").click(function(){
        $(".reservation-step-three").slideUp("50");
        $(".reservation-step-two").slideDown("50");
    });
});

$(document).ready(function(){
    $("#reserv-button").on("click", function(){
        $(".waiting").css('display', 'block');
    });
});

$(document).ready(function(){
    function isNumberKey(evt){
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    };
});

// $(document).ready(function(){
//   $('#res_year').change(function(){
//     var res_year = $(this).val();
//     $.ajax({
//       type: 'POST',
//       dataType: 'json',
//       url: '/reservations/new/steptwo',
//       data: {
//         "_token": "{{ csrf_token() }}",
//         "res_year": res_year,
//       },
//       success: function(response) {
//         console.log(response);
//       },
//       error: function(data) {
//         alert('Er kan geen data op worden gehaald.\nNeem contact op met een administrator.\nU kunt niet verder met de reservering.');
//       }
//     });
//   });
// });