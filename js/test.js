$( document ).ready(function() {
    $( "#next_form_1" ).click(function() {
        $('#form_2').removeClass('hiddenforms');
        $('#form_1').addClass('hiddenforms');
        $("#prog").css("width", "10%");
        $("#prog").text('10%');
    });
    $( "#next_form_2" ).click(function() {
        $('#form_2').addClass('hiddenforms');
        $('#form_3').removeClass('hiddenforms');
        $("#prog").css("width", "20%");
        $("#prog").text('20%');
    });
    $( "#prev_form_2" ).click(function() {
        $("#prog").css("width", "0%");
        $("#prog").text('0%');
        $('#form_2').addClass('hiddenforms');
        $('#form_1').removeClass('hiddenforms');
    });

    $( "#next_form_3" ).click(function() {
        $("#prog").css("width", "30%");
        $("#prog").text('30%');
        $('#form_3').addClass('hiddenforms');
        $('#form_4').removeClass('hiddenforms');
    });
    $( "#prev_form_3" ).click(function() {
        $("#prog").css("width", "20%");
        $("#prog").text('20%');
        $('#form_3').addClass('hiddenforms');
        $('#form_2').removeClass('hiddenforms');
    });
    $( "#next_form_4" ).click(function() {
        $("#prog").css("width", "40%");
        $("#prog").text('40%');
        $('#form_4').addClass('hiddenforms');
        $('#form_5').removeClass('hiddenforms');
    });
    $( "#prev_form_4" ).click(function() {
        $("#prog").css("width", "30%");
        $("#prog").text('30%');
        $('#form_4').addClass('hiddenforms');
        $('#form_3').removeClass('hiddenforms');
    });
    $( "#next_form_5" ).click(function() {
        $("#prog").css("width", "50%");
        $("#prog").text('50%');
        $('#form_5').addClass('hiddenforms');
        $('#form_6').removeClass('hiddenforms');
    });
    $( "#prev_form_5" ).click(function() {
        $("#prog").css("width", "40%");
        $("#prog").text('40%');
        $('#form_5').addClass('hiddenforms');
        $('#form_4').removeClass('hiddenforms');
    });
    $( "#next_form_6" ).click(function() {
        $("#prog").css("width", "60%");
        $("#prog").text('60%');
        $('#form_6').addClass('hiddenforms');
        $('#form_7').removeClass('hiddenforms');
    });
    $( "#prev_form_6" ).click(function() {
        $("#prog").css("width", "50%");
        $("#prog").text('50%');
        $('#form_6').addClass('hiddenforms');
        $('#form_5').removeClass('hiddenforms');
    });
    $( "#next_form_7" ).click(function() {
        $("#prog").css("width", "70%");
        $("#prog").text('70%');
        $('#form_7').addClass('hiddenforms');
        $('#form_8').removeClass('hiddenforms');
    });
    $( "#prev_form_7" ).click(function() {
        $("#prog").css("width", "60%");
        $("#prog").text('60%');
        $('#form_7').addClass('hiddenforms');
        $('#form_6').removeClass('hiddenforms');
    });
    $( "#next_form_8" ).click(function() {
        $("#prog").css("width", "80%");
        $("#prog").text('80%');
        $('#form_8').addClass('hiddenforms');
        $('#form_9').removeClass('hiddenforms');
    });
    $( "#prev_form_8" ).click(function() {
        $("#prog").css("width", "70%");
        $("#prog").text('70%');
        $('#form_8').addClass('hiddenforms');
        $('#form_7').removeClass('hiddenforms');
    });
    $( "#next_form_9" ).click(function() {
        $("#prog").css("width", "90%");
        $("#prog").text('90%');
        $('#form_9').addClass('hiddenforms');
        $('#form_10').removeClass('hiddenforms');
    });
    $( "#prev_form_9" ).click(function() {
        $("#prog").css("width", "70%");
        $("#prog").text('70%');
        $('#form_9').addClass('hiddenforms');
        $('#form_8').removeClass('hiddenforms');
    });
    $( "#next_form_10" ).click(function() {
        $("#prog").css("width", "100%");
        $("#prog").text('100%');
        $('#form_10').addClass('hiddenforms');
        $('#form_11').removeClass('hiddenforms');
    });
    $( "#prev_form_10" ).click(function() {
        $("#prog").css("width", "90%");
        $("#prog").text('90%');
        $('#form_10').addClass('hiddenforms');
        $('#form_9').removeClass('hiddenforms');
    });
    $( "#prev_form_11" ).click(function() {
        $("#prog").css("width", "90%");
        $("#prog").text('90%');
        $('#form_11').addClass('hiddenforms');
        $('#form_10').removeClass('hiddenforms');
    });
});