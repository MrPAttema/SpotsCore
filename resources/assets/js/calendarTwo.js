$(document).ready(function(){
    var startDate;
    var endDate;
    var selectCurrentWeek = function() {
        window.setTimeout(function () {
            $('#datepickerTwo').find('.ui-datepicker-current-day a').addClass('ui-state-active')
        }, 1);
    }
    $('#datepickerTwo').datepicker({
        showOtherMonths: true,
        numberOfMonths: 2,
        minDate: new Date('2018/01/06'),
        maxDate: new Date('2018/12/31'),
        showWeek: true,
        firstDay: 6,
        onSelect: function(dateText, inst) {
            var date = $(this).datepicker('getDate');
            startDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay() - 1);
            endDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay() + 6);
            var dateFormat = inst.settings.dateFormat || $.datepicker._defaults.dateFormat;
            $('#startDateTwo').text($.datepicker.formatDate(dateFormat, startDate, inst.settings));
            $('#weekNumberTwo').text($.datepicker.iso8601Week(new Date(dateText)));
            $('#endDateTwo').text($.datepicker.formatDate(dateFormat, endDate, inst.settings));
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
});
