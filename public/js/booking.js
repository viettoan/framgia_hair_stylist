$(document).ready(function(){
    $(".department td").on('click', function(){
        $(".department td").css("background-color", "#fcf8e3");
        $(".department td").css("color", "black");
        $(".department td").css("border-bottom", "0px solid #fcf8e3");
        $(this).css("background-color", "black");
        $(this).css("color", "white");
        $(this).css("border-bottom", "3px solid green");
    });

    $(".day_choice td").on('click', function(){
        $(".day_choice td").css("background-color", "#fcf8e3");
        $(".day_choice td").css("color", "black");
        $(".day_choice td").css("border-bottom", "0px solid #fcf8e3");
        $(this).css("background-color", "black");
        $(this).css("color", "white");
        $(this).css("border-bottom", "3px solid green");
    });

    $(".choice_time td").on('click', function(){
        $(".choice_time td").css("background-color", "#dff0d8");
        $(".choice_time td").css("color", "black");
        $(".choice_time td").css("border-bottom", "0px solid #dff0d8");
        $(this).css("background-color", "black");
        $(this).css("color", "white");
        $(this).css("border-bottom", "3px solid green");
    });
});
