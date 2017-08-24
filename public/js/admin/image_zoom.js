$(document).ready(function(){
    $("#zoom_01").elevateZoom({tint:true, tintColour:'#F90', tintOpacity:0.5, zoomWindowPosition:3});
    $("#zoom_02").elevateZoom({tint:true, tintColour:'#F90', tintOpacity:0.5, zoomWindowPosition:3});
    $("#zoom_03").elevateZoom({tint:true, tintColour:'#F90', tintOpacity:0.5, zoomWindowPosition:9});

    $(".zoomWindowContainer").css("zIndex", 1); 
    $("#create-item").css("zIndex", 1);
});
