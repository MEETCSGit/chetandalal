jQuery(document).ready(function($) {

    //Bootstrap will close the alert because it spots the data-dismiss="alert" attribute
    //Here we also handle the alert close event. We have added two custom tags data-alertindex
    //and data-alertkey. e.g Alert1  has alertindex1. The alertkey value identifies the
    // alert content, since Alert1 (2 and 3) will be reused. We use a YUI function to set
    //the user preference for the key to the last dismissed key for the alertindex.
    //alertkey undismissable is a special case for "loginas" alert which shouldn't really
    //be permanently dismissed.
    //Justin 2015/12/05
   $('.close').click(function(){
      var alertindex = $(this).data('alertindex');
      var alertkey = $(this).data('alertkey');
      if(alertkey!='undismissable'){
         M.util.set_user_preference('theme_adaptable_alertkey' + alertindex, alertkey);
      }
    });

  $('#ticker').tickerme();
    //new for every three
    if($('header').css("position") == "fixed") {
        $('.outercont').css('padding-top', $('header').height());
    }
    var $pArr = $('.frontpage-course-list-all').children(".coursebox");
    var pArrLen = $pArr.length;
    var pPerDiv = 3;
    for (var i = 0;i < pArrLen;i+=pPerDiv){
        $pArr.filter(':eq('+i+'),:lt('+(i+pPerDiv)+'):gt('+i+')').wrapAll('<div class="row-fluid clearfix" />');
    }
    var $pArr = $('.frontpage-course-list-enrolled').children(".coursebox");
    var pArrLen = $pArr.length;
    var pPerDiv = 3;
    for (var i = 0;i < pArrLen;i+=pPerDiv){
            $pArr.filter(':eq('+i+'),:lt('+(i+pPerDiv)+'):gt('+i+')').wrapAll('<div class="row-fluid clearfix" />');
    }

// Breadcrumb ***************************************

    $(".breadcrumb li:not(:last-child) span").not('.separator').addClass('');
    $(".breadcrumb li a" );
    $(".breadcrumb li:last-child").addClass("lastli");


// Slider *******************************************

    $('#main-slider').flexslider({
        namespace           : "flex-",           //{NEW} String: Prefix string attached to the class of every element generated by the plugin
        selector            : ".slides > li",    //{NEW} Selector: Must match a simple pattern. '{container} > {slide}' -- Ignore pattern at your own peril
        animation           : "slide",           //String: Select your animation type, "fade" or "slide"
        easing              : "swing",           //{NEW} String: Determines the easing method used in jQuery transitions. jQuery easing plugin is supported!
        direction           : "horizontal",      //String: Select the sliding direction, "horizontal" or "vertical"
        reverse             : false,             //{NEW} Boolean: Reverse the animation direction
        animationLoop       : true,              //Boolean: Should the animation loop? If false, directionNav will received "disable" classes at either end
        smoothHeight        : false,             //{NEW} Boolean: Allow height of the slider to animate smoothly in horizontal mode
        startAt             : 0,                 //Integer: The slide that the slider should start on. Array notation (0 = first slide)
        slideshow           : true,              //Boolean: Animate slider automatically
        slideshowSpeed      : 7000,              //Integer: Set the speed of the slideshow cycling, in milliseconds
        animationSpeed      : 600,               //Integer: Set the speed of animations, in milliseconds
        initDelay           : 0,                 //{NEW} Integer: Set an initialization delay, in milliseconds
        randomize           : false,             //Boolean: Randomize slide order

        // Usability features
        pauseOnAction       : true,              //Boolean: Pause the slideshow when interacting with control elements, highly recommended.
        pauseOnHover        : false,             //Boolean: Pause the slideshow when hovering over slider, then resume when no longer hovering
        useCSS              : true,              //{NEW} Boolean: Slider will use CSS3 transitions if available
        touch               : true,              //{NEW} Boolean: Allow touch swipe navigation of the slider on touch-enabled devices
        video               : false,             //{NEW} Boolean: If using video in the slider, will prevent CSS3 3D Transforms to avoid graphical glitches

        // Primary Controls
        controlNav          : true,              //Boolean: Create navigation for paging control of each clide? Note: Leave true for manualControls usage
        directionNav        : true,              //Boolean: Create navigation for previous/next navigation? (true/false)
        prevText            : "Previous",        //String: Set the text for the "previous" directionNav item
        nextText            : "Next",            //String: Set the text for the "next" directionNav item

        // Secondary Navigation
        keyboard            : true,              //Boolean: Allow slider navigating via keyboard left/right keys
        multipleKeyboard    : false,             //{NEW} Boolean: Allow keyboard navigation to affect multiple sliders. Default behavior cuts out keyboard navigation with more than one slider present.
        mousewheel          : false,             //{UPDATED} Boolean: Requires jquery.mousewheel.js (https://github.com/brandonaaron/jquery-mousewheel) - Allows slider navigating via mousewheel
        pausePlay           : false,             //Boolean: Create pause/play dynamic element
        pauseText           : 'Pause',           //String: Set the text for the "pause" pausePlay item
        playText            : 'Play',            //String: Set the text for the "play" pausePlay item

        // Special properties
        controlsContainer   : "",                //{UPDATED} Selector: USE CLASS SELECTOR. Declare which container the navigation elements should be appended too. Default container is the FlexSlider element. Example use would be ".flexslider-container". Property is ignored if given element is not found.
        manualControls      : "",                //Selector: Declare custom control navigation. Examples would be ".flex-control-nav li" or "#tabs-nav li img", etc. The number of elements in your controlNav should match the number of slides/tabs.
        sync                : "",                //{NEW} Selector: Mirror the actions performed on this slider with another slider. Use with care.
        asNavFor            : "",                //{NEW} Selector: Internal property exposed for turning the slider into a thumbnail navigation for another slider
    });

$(".container.slidewrap").on('transitionend', function() {
    var slider1 = $('#main-slider').data('flexslider');
    slider1.resize();
})

    var offset = 50;
    var duration = 500;
    jQuery(window).scroll(function() {
        if (jQuery(this).scrollTop() > offset) {
            jQuery('.back-to-top').fadeIn(duration);
            if($('header').css("position") == "fixed") {
                jQuery('#page-header').hide();
                Y.Global.fire('moodle-gradereport_grader:resized');
            }
        } else {
            jQuery('.back-to-top').fadeOut(duration);
            if($('header').css("position") == "fixed") {
                jQuery('#page-header').show();
                Y.Global.fire('moodle-gradereport_grader:resized');
            }
        }
    });
    jQuery('.back-to-top').click(function(event) {
        event.preventDefault();
        jQuery('html, body').animate({scrollTop: 0}, duration);
        return false;
    })
});

// Zoom ************************************************
var onZoom = function() {
  var zoomin = Y.one('body').hasClass('zoomin');
  if (zoomin) {
    Y.one('body').removeClass('zoomin');
    M.util.set_user_preference('theme_adaptable_zoom', 'nozoom');
  } else {
    Y.one('body').addClass('zoomin');
    M.util.set_user_preference('theme_adaptable_zoom', 'zoomin');
  }
};

//When the button with class .moodlezoom is clicked fire the onZoom function
M.theme_adaptable = M.theme_adaptable || {};
M.theme_adaptable.zoom =  {
  init: function() {
    Y.one('body').delegate('click', onZoom, '.moodlezoom');
  }
};


var onFull = function() {
    if ( $("#page").hasClass("fullin") ) {
        $( "#page").removeClass('fullin');
        M.util.set_user_preference('theme_adaptable_full', 'nofull');
    } else {
        $( "#page").addClass('fullin');
        //Y.one('#page').addClass('fullin');
        M.util.set_user_preference('theme_adaptable_full', 'fullin');
    }
};

//When the button with class .moodlezoom is clicked fire the onZoom function
M.theme_adaptable = M.theme_adaptable || {};
M.theme_adaptable.full =  {
  init: function() {
    Y.one('body').delegate('click', onFull, '.moodlewidth');
  }
};
