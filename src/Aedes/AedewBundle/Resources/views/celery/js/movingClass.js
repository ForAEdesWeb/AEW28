function movingClass(movingObject, form)
{
    var viewObject = $(window);
    var hiddingBlockTop = $("#header").height();
    var hiddingBlockBotton = $("#footer").height();
    var max = 3072 - viewObject.width();
    var min = 0;

    var objectTop = movingObject.offset().top;
    var objectBotton = movingObject.offset().top + movingObject.height();

    var viewTop = viewObject.scrollTop() + hiddingBlockTop;
    var viewBotton = viewObject.scrollTop() + viewObject.height() - hiddingBlockBotton;

    var par = (max - min) / (viewObject.height() + movingObject.height() - (hiddingBlockTop + hiddingBlockBotton));

    var moving = (viewBotton - objectTop) * par;

    if(max < moving)
        moving = max;

    if(min > moving)
        moving = min;

    if(0 > form)
        moving = max - moving;

    movingObject.css("background-position-x","-" + moving + "px");
}

$(window).scroll(function(){
    movingClass($(".movingBackground[title=\"1\"]"), 1);
    movingClass($(".movingBackground[title=\"2\"]"), -1);
    movingClass($(".movingBackground[title=\"3\"]"), 1);
    movingClass($(".movingBackground[title=\"4\"]"), -1);
});