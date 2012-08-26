!function ($) {

  $(function(){

    if (window.location.pathname.indexOf("/fr") != -1){
        $("#select-language").val("fr");
    }
    else if (window.location.pathname.indexOf("/de") != -1){
              $("#select-language").val("de");
    }
    else if (window.location.pathname.indexOf("/en") != -1){
              $("#select-language").val("en");
    }
    // Disable certain links in docs
    $('section [href^=#]').click(function (e) {
      e.preventDefault()
    })

    $('.pull-right [href^=#]').click(function (e) {
      e.preventDefault();
      $('html, body').animate({scrollTop: '0px'}, 300);
    })

    // make code pretty
    window.prettyPrint && prettyPrint()

    // add-ons
    $('.add-on :checkbox').on('click', function () {
      var $this = $(this)
        , method = $this.attr('checked') ? 'addClass' : 'removeClass'
      $(this).parents('.add-on')[method]('active')
    })

    // position static twipsies for components page
    if ($(".twipsies a").length) {
      $(window).on('load resize', function () {
        $(".twipsies a").each(function () {
          $(this)
            .tooltip({
              placement: $(this).attr('title')
            , trigger: 'manual'
            })
            .tooltip('show')
          })
      })
    }

    // add tipsies to grid for scaffolding
    if ($('#grid-system').length) {
      $('#grid-system').tooltip({
          selector: '.show-grid > div'
        , title: function () { return $(this).width() + 'px' }
      })
    }

    // fix sub nav on scroll
    var $win = $(window)
      , $nav = $('.subnav')
      , navTop = $('.subnav').length && $('.subnav').offset().top - 40
      , isFixed = 0

    processScroll()

    $win.on('scroll', processScroll)

    function processScroll() {
      var i, scrollTop = $win.scrollTop()
      if (scrollTop >= navTop && !isFixed) {
        isFixed = 1
        $nav.addClass('subnav-fixed')
      } else if (scrollTop <= navTop && isFixed) {
        isFixed = 0
        $nav.removeClass('subnav-fixed')
      }
    }

    // tooltip demo
    $('.tooltip-blandine').tooltip({
      //selector: "a[rel=tooltip]"
    })

    $('.tooltip-demo.well').tooltip({
      selector: "a[rel=tooltip]"
    })

    $('.tooltip-test').tooltip()
    $('.popover-test').popover()

    // popover demo
    $("a[rel=popover]")
      .popover()
      .click(function(e) {
        e.preventDefault()
      })

    // button state demo
    $('#fat-btn')
      .click(function () {
        var btn = $(this)
        btn.button('loading')
        setTimeout(function () {
          btn.button('reset')
        }, 3000)
      })

    // carousel demo
    $('#myCarousel').carousel('pause')

    // javascript build logic
    var inputsComponent = $("#components.download input")
      , inputsPlugin = $("#plugins.download input")
      , inputsVariables = $("#variables.download input")

    // toggle all plugin checkboxes
    $('#components.download .toggle-all').on('click', function (e) {
      e.preventDefault()
      inputsComponent.attr('checked', !inputsComponent.is(':checked'))
    })

    $('#plugins.download .toggle-all').on('click', function (e) {
      e.preventDefault()
      inputsPlugin.attr('checked', !inputsPlugin.is(':checked'))
    })

    $('#variables.download .toggle-all').on('click', function (e) {
      e.preventDefault()
      inputsVariables.val('')
    })

    // request built javascript
    $('.download-btn').on('click', function () {

      var css = $("#components.download input:checked")
            .map(function () { return this.value })
            .toArray()
        , js = $("#plugins.download input:checked")
            .map(function () { return this.value })
            .toArray()
        , vars = {}
        , img = ['glyphicons-halflings.png', 'glyphicons-halflings-white.png']

    $("#variables.download input")
      .each(function () {
        $(this).val() && (vars[ $(this).prev().text() ] = $(this).val())
      })

      $.ajax({
        type: 'POST'
      , url: 'http://bootstrap.herokuapp.com'
      , dataType: 'jsonpi'
      , params: {
          js: js
        , css: css
        , vars: vars
        , img: img
      }
      })
    })

  })

// Modified from the original jsonpi https://github.com/benvinegar/jquery-jsonpi
$.ajaxTransport('jsonpi', function(opts, originalOptions, jqXHR) {
  var url = opts.url;

  return {
    send: function(_, completeCallback) {
      var name = 'jQuery_iframe_' + jQuery.now()
        , iframe, form

      iframe = $('<iframe>')
        .attr('name', name)
        .appendTo('head')

      form = $('<form>')
        .attr('method', opts.type) // GET or POST
        .attr('action', url)
        .attr('target', name)

      $.each(opts.params, function(k, v) {

        $('<input>')
          .attr('type', 'hidden')
          .attr('name', k)
          .attr('value', typeof v == 'string' ? v : JSON.stringify(v))
          .appendTo(form)
      })

      form.appendTo('body').submit()
    }
  }
})

//add special class to last child in navbar
$("#main-menu > li:last-child").addClass("last-item");

//liens externes
$(".widget ul li a.external").hover(
  function () {
    $(this).append($("<img class='external' src='/wordpress/wp-content/themes/theme-blandine-0.3/img/fleche.png'>"));
  }, 
  function () {
    $(this).find("img:last").remove();
  }
);

//sidebar effect
var $scrollingDiv = $("#scrollingDiv");

$(window).scroll(function(){      
  $scrollingDiv
    //.stop()
    //.animate({"marginTop": ($(window).scrollTop()) + "px"}, 0 );      
});

//gestion des chevrons dans les accordeons
$('#accordion2').on('shown', function () {
  $(".accordion-body.in").parent().children().find("i").removeClass("icon-chevron-right");
  $(".accordion-body.in").parent().children().find("i").addClass("icon-chevron-down");
});

$('#accordion2').on('hidden', function () {
  $(".accordion-body").parent().children().find("i").removeClass("icon-chevron-down");
  $(".accordion-body").parent().children().find("i").addClass("icon-chevron-right");
});

$('#accordion3').on('shown', function () {
  $(".accordion-body.in").parent().children().find("i").removeClass("icon-chevron-right");
  $(".accordion-body.in").parent().children().find("i").addClass("icon-chevron-down");
});

$('#accordion3').on('hidden', function () {
  $(".accordion-body").parent().children().find("i").removeClass("icon-chevron-down");
  $(".accordion-body").parent().children().find("i").addClass("icon-chevron-right");
});

//style tag button
$('a[rel="tag"]').addClass("btn btn-warning");


//change language
$("#select-language").change(function (){
var oldLocale;
if (window.location.pathname.indexOf("/fr/") != -1){
  oldLocale = "fr";
}
else if (window.location.pathname.indexOf("/en/") != -1){
  oldLocale = "en";
}
else if (window.location.pathname.indexOf("/de/") != -1){
  oldLocale = "de";
}
else {
    oldLocale = "fr";

}
     var host = window.location.href.split(oldLocale)[0];
     var locale =  $("#select-language").val();
     var query = window.location.href.split(oldLocale)[1];
     
    if (query != null) {
      window.location.href = host+locale+query;
    }
    else {
      window.location.href = host+locale;
    }

  //window.location.href = "http://" + window.location.host + window.location.pathname + "?lang=" + $("#select-language").val();
});



}(window.jQuery)