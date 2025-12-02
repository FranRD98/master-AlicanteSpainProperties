$(function () {

    $('.addNot').click(function (e){
        e.preventDefault();
        var currentDate = new Date();
        var day = currentDate.getDate();
        var month = currentDate.getMonth() + 1;
        var year = currentDate.getFullYear();
        var hour = currentDate.getHours();
        var minutes = currentDate.getMinutes();
        day = (day > 9)?day:'0'+day;
        month = (month > 9)?month:'0'+month;
        hour = (hour > 9)?hour:'0'+hour;
        minutes = (minutes > 9)?minutes:'0'+minutes;
        $('#notas_col').val("[ " + day + "-" + month + "-" + year + " " + hour + ":" + minutes + " ] [ " + admiName + " ] → \n\n"+$('#notas_col').val());
    });

});
