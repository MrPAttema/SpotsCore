$(document).ready(function() {
	$('.submit-btn').click(function() {
	    $(this).addClass('loading');
	    $('.cancable').addClass('disabled');
	    $('.cancable').prop('disabled', true);
	});
});

$(document).ready(function() {
	$('.toast-clear').click(function() {
		$(".toast").fadeOut(400);
	});
});

$(document).ready(function() {
	$('.modal-clear').click(function() {
		$(".modal").removeClass('active');
	});
});

$(document).ready(function() {
	$('.modal-open').click(function() {
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
            console.log(key, value);
            $("#price").html(result.prijs);
        });
    });
});

$(function () {
    $(".slides").slidesjs({
        width: 550,
        height: 310,
        navigation: {
            active: true,
            effect: "slide"
        },
        pagination: {
            active: false,
            effect: "slide"
        },
        effect: {
            slide: {
                speed: 1000
            }
        }
    });
});

// var slideIndex = [1, 1];
// /* Class the members of each slideshow group with different CSS classes */
// var slideId = ["mySlides1", "mySlides2", "mySlides3", "mySlides4", "mySlides5", "mySlides6", "mySlides7"]
// showSlides(1, 0);
// showSlides(1, 1);

// function plusSlides(n, no) {
//     showSlides(slideIndex[no] += n, no);
// }

// function showSlides(n, no) {
//     var i;
//     var x = document.getElementsByClassName(slideId[no]);
//     if (n > x.length) { slideIndex[no] = 1 }
//     if (n < 1) { slideIndex[no] = x.length }
//     for (i = 0; i < x.length; i++) {
//         x[i].style.display = "none";
//     }
//     x[slideIndex[no] - 1].style.display = "block";
// }

// $('input[name="subscribe"]').on('click', function(){
//     if ( $(this).is(':checked') ) {
//         $('input[name="email"]').show();
//     } 
//     else {
//         $('input[name="email"]').hide();
//     }
// });

// $(document).ready(function() {
// 	$('.checkbox-submit').is(':checked'){
// 		console.log('CHECKED');
// 	};
// });
