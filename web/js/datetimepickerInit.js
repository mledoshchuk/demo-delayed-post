$('#main-contr').on('focus', '.datetimepicker', function() {
    if( $(this).hasClass('.datetimepicker') === false )  {
        $('.datetimepicker').datetimepicker({
            'allowInputToggle': true,
            'showClose': true,
            'showClear': true,
            'showTodayButton': true,
            'format': 'YYYY-MM-DD HH:mm:ss'
        });
    }
});