$(document).ready(function () {
  var sectionArray = [1, 2, 3, 4, 5];

  // Set up scroll event handler
  $(document).scroll(function () {
    var docScroll = $(document).scrollTop();

    $.each(sectionArray, function (index, value) {
      var offsetSection = $("#" + "section_" + value).offset().top - 94;

      if (docScroll >= offsetSection) {
        $(".navbar-nav .nav-item .nav-link").removeClass("active");
        $(".navbar-nav .nav-item .nav-link").addClass("inactive");

        $(".navbar-nav .nav-item .nav-link").eq(index).addClass("active");
        $(".navbar-nav .nav-item .nav-link").eq(index).removeClass("inactive");
      }
    });
  });

  // Set up click event handler for navigation links
  $(".click-scroll").click(function (e) {
    e.preventDefault();
    var index = $(this).index(".click-scroll");
    var value = sectionArray[index];
    var offsetClick = $("#" + "section_" + value).offset().top - 94;

    $("html, body").animate(
      {
        scrollTop: offsetClick,
      },
      300
    );
  });

  // Initial setup: set the first link as active
  $(".navbar-nav .nav-item .nav-link").addClass("inactive");
  $(".navbar-nav .nav-item .nav-link").eq(0).addClass("active");
  $(".navbar-nav .nav-item .nav-link").eq(0).removeClass("inactive");
});
