  // jQuery is required to run this code
  $( document ).ready(function() {

    $(".square").hide();
    $('.tour').show();


    scaleVideoContainer();

    initBannerVideoSize('.video-container .poster img');
    initBannerVideoSize('.video-container .filter');
    initBannerVideoSize('.video-container video');

    $(window).on('resize', function() {
      scaleVideoContainer();
      scaleBannerVideoSize('.video-container .poster img');
      scaleBannerVideoSize('.video-container .filter');
      scaleBannerVideoSize('.video-container video');
    });
  });

  function scaleVideoContainer() {
    var height = $(window).height() + 5;
    var unitHeight = parseInt(height) + 'px';
    $('.homepage-hero-module').css('height',unitHeight);
  }

  function initBannerVideoSize(element){
    $(element).each(function(){
      $(this).data('height', $(this).height());
      $(this).data('width', $(this).width());
    });

    scaleBannerVideoSize(element);
  }

  function scaleBannerVideoSize(element) {

    var windowWidth = $(window).width(),
    windowHeight = $(window).height() + 5,
    videoWidth,
    videoHeight;

    // console.log(windowHeight);

    $(element).each(function(){
      var videoAspectRatio = $(this).data('height')/$(this).data('width');

      $(this).width(windowWidth);

      if(windowWidth < 1000){
          videoHeight = windowHeight;
          videoWidth = videoHeight / videoAspectRatio;
          $(this).css({'margin-top' : 0, 'margin-left' : -(videoWidth - windowWidth) / 2 + 'px'});

          $(this).width(videoWidth).height(videoHeight);
      }

      $('.homepage-hero-module .video-container video').addClass('fadeIn animated');

    });
  }

////// extra

  // init controller
  var controller = new ScrollMagic.Controller();

  // create a scene
  new ScrollMagic.Scene({
      duration: 1000,  // the scene should last for a scroll distance of 100px
      offset: 400  // start this scene after scrolling for 50px
    })
    .setPin("#image1") // pins the element for the the scene's duration
    .addTo(controller); // assign the scene to the controller


  jQuery(function($) {
  $('.square').waypoint(function() {
    $(".square").show();
    $('.square').toggleClass( 'animated fadeInUp');
  },
  {
    offset: '100%',
    triggerOnce: true
  });

  });

  jQuery(function($) {
  $('.squareImg').waypoint(function() {
    $('.squareImg').toggleClass( 'animated bounceInRight');
  },
  {
    offset: '80%',
    triggerOnce: true
  });

  });


  jQuery(function($) {
  $('.tour').waypoint(function() {
    $('.tour').show();
    $('.tour').toggleClass( 'animated bounceInLeft slow');
  },
  {
    offset: '80%',
    triggerOnce: true
  });

  });



  