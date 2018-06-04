$(document).ready(function(factory) {
    	if ( typeof define === "function" && define.amd ) {

    		// AMD. Register as an anonymous module.
    		define( [ "../widgets/datepicker" ], factory );
    	} else {

    		// Browser globals
    		factory(jQuery.datepicker);
    	}
    }( function(datepicker) {

    datepicker.regional.nl = {
    	closeText: "Sluiten",
    	prevText: "←",
    	nextText: "→",
    	currentText: "Vandaag",
    	monthNames: [ "januari", "februari", "maart", "april", "mei", "juni",
    	"juli", "augustus", "september", "oktober", "november", "december" ],
    	monthNamesShort: [ "jan", "feb", "mrt", "apr", "mei", "jun",
    	"jul", "aug", "sep", "okt", "nov", "dec" ],
    	dayNames: [ "zondag", "maandag", "dinsdag", "woensdag", "donderdag", "vrijdag", "zaterdag" ],
    	dayNamesShort: [ "zon", "maa", "din", "woe", "don", "vri", "zat" ],
    	dayNamesMin: [ "zo", "ma", "di", "wo", "do", "vr", "za" ],
    	weekHeader: "Week",
    	dateFormat: "dd-mm-yy",
    	firstDay: 1,
    	isRTL: false,
    	showMonthAfterYear: false,
    	yearSuffix: "" };
    datepicker.setDefaults( datepicker.regional.nl );

    return datepicker.regional.nl;

}));

$(function() {
    var startDate;
    var endDate;

    var selectCurrentWeek = function() {
        window.setTimeout(function () {
            $('.week-picker').find('.ui-datepicker-current-day a').addClass('ui-state-active')
        }, 1);
    }
    $('.week-picker').datepicker( {
        showOtherMonths: true,
        numberOfMonths: 2,
        minDate: new Date('2017/01/01'),
        maxDate: new Date('2017/12/31'),
        selectOtherMonths: true,
        dateFormat: 'dd-mm-yy',
        showWeek: true,
        firstDay: 6,
        onSelect: function(dateText, inst) {
            var date = $(this).datepicker('getDate');
            startDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay() - 1);
            endDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay() + 6);
            var dateFormat = inst.settings.dateFormat || $.datepicker._defaults.dateFormat;
            $('#startDate').text($.datepicker.formatDate(dateFormat, startDate, inst.settings));
            $('#weekNumber').text($.datepicker.iso8601Week(new Date(dateText)));
            $('#endDate').text($.datepicker.formatDate(dateFormat, endDate, inst.settings));

            selectCurrentWeek();
        },
        beforeShowDay: function(date) {
            var cssClass = '';
            if(date >= startDate && date <= endDate)
                cssClass = 'ui-datepicker-current-day';
            return [true, cssClass];
        },
        onChangeMonthYear: function(year, month, inst) {
            selectCurrentWeek();
        }
    });

    // $('.week-picker .ui-datepicker-calendar tr').live('mousemove', function() { $(this).find('td a').addClass('ui-state-hover'); });
    // $('.week-picker .ui-datepicker-calendar tr').live('mouseleave', function() { $(this).find('td a').removeClass('ui-state-hover'); });
});
