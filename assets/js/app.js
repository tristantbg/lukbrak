/* globals $:false */
var width = $(window).width(),
    height = $(window).height(),
    content,
    isMobile,
    $slider = null,
    flickityFirst = true,
    players,
    $root = '/lucbraquet';
$(function() {
    var app = {
        init: function() {
            $(window).resize(function(event) {});
            $(document).ready(function($) {
                $body = $('body');
                $nav = $('#navigation');
                nav = document.getElementById("navigation");
                $container = $('#container');
                History.Adapter.bind(window, 'statechange', function() {
                    var State = History.getState();
                    console.log(State);
                    content = State.data;
                    if (content.type == 'album') {
                        app.loadContent(State.url, $container);
                    } else if (content.type == 'page') {
                        app.loadContent(State.url, $container);
                    } else {
                        app.loadContent(State.url, $container);
                    }
                });
                $body.on('click', '#index', function(event) {
                    event.preventDefault();
                    $nav.toggleClass('visible');
                });
                $body.on('click', '.slider.nav-prev', function(event) {
                    event.preventDefault();
                    if ($('.cell.is-selected .content.video').has(event.target).length == 0) {
                        app.goPrev($slider);
                    }
                });
                $body.on('click', '.slider.nav-next', function(event) {
                    event.preventDefault();
                    if ($('.cell.is-selected .content.video').has(event.target).length == 0) {
                        app.goNext($slider);
                    }
                });
                $("#navigation").click(function(e) {
                    if (e.target == this) {
                        $nav.toggleClass('visible');
                    }
                });
                $('body').on('click', '[data-target]', function(e) {
                    $el = $(this);
                    e.preventDefault();
                    if ($el.data('target') == "album") {
                        History.pushState({
                            type: 'album'
                        }, $el.data('title') + " | " + $sitetitle, $el.attr('href'));
                    } else if ($el.data('target') == "page") {
                        History.pushState({
                            type: 'page'
                        }, $el.data('title') + " | " + $sitetitle, $el.attr('href'));
                    } else if ($el.data('target') == "index") {
                        e.preventDefault();
                        app.goIndex();
                    }
                });
                //esc
                $(document).keyup(function(e) {
                    if (e.keyCode === 27) app.goIndex();
                });
                //left
                $(document).keyup(function(e) {
                    if (e.keyCode === 37 && $slider) app.goPrev($slider);
                });
                //right
                $(document).keyup(function(e) {
                    if (e.keyCode === 39 && $slider) app.goNext($slider);
                });
                $(window).load(function() {
                    app.sizeSet();
                    app.loadSlider();
                    if (!$body.hasClass('album') && !$body.hasClass('page')) {
                        app.plyr(true);
                        if (players && players.length > 0) {
                            players[0].on('ready', function(event) {
                                players[0].play();
                            });
                        }
                    } else {
                        app.plyr(false);
                    }
                    app.mouseNav();
                    $(".loader").fadeOut("fast");
                });
            });
        },
        sizeSet: function() {
            width = $(window).width();
            height = $(window).height();
            if (width <= 770) isMobile = true;
            if (isMobile) {
                if (width >= 770) {
                    //location.reload();
                }
            }
        },
        mouseNav: function(event) {
            $(window).mousemove(function(event) {
                if ($slider && !isMobile && $body.hasClass('album')) {
                    posX = event.pageX;
                    posY = event.pageY;
                    if (posX > width / 2) {
                        $slider.removeClass('nav-prev').addClass('nav-next');
                    } else {
                        $slider.removeClass('nav-next').addClass('nav-prev');
                    }
                }
            });
        },
        plyr: function(loop) {
            players = plyr.setup('.js-player', {
                loop: loop,
                iconUrl: "/lucbraquet/assets/images/plyr.svg"
            });
        },
        loadSlider: function() {
            $slider = $('.slider.slides').flickity({
                cellSelector: '.cell',
                imagesLoaded: true,
                //lazyLoad: 2,
                setGallerySize: false,
                friction: 0.30,
                selectedAttraction: 0.020,
                //percentPosition: false,
                wrapAround: true,
                prevNextButtons: false,
                pageDots: false,
                draggable: Modernizr.touchevents
            });
            flkty = $slider.data('flickity');
            var hash = window.location.hash.substr(1);
            $slider.flickity('selectCell', '[data-id="' + hash + '"]', true, true);
            var count = $(flkty.selectedElement).attr('data-id');
            window.location.hash = count;
            if (flickityFirst) {
                $('body').on('click touchstart', '.prev', function(e) {
                    e.preventDefault();
                    app.goPrev($slider);
                });
                $('body').on('click touchstart', '.next', function(e) {
                    e.preventDefault();
                    app.goNext($slider);
                });
                flickityFirst = false;
            }
            $slider.on('select.flickity', function() {
                if ($('.plyr--playing').length > 0) {
                    for (var i = players.length - 1; i >= 0; i--) {
                        if (!players[i].isPaused()) {
                            players[i].pause();
                        }
                    }
                }
                count = $(flkty.selectedElement).attr('data-id');
                window.location.hash = count;
            });
            // $slider.on('staticClick.flickity', function(event, pointer, cellElement, cellIndex) {
            //     if (!cellElement) {
            //         return;
            //     }
            //     if (event.target.is('.content.video')) {
            //             $nav.toggleClass('visible');
            //         }
            //     app.goNext($slider, true);
            // });
        },
        goNext: function($slider) {
            $slider.flickity('next', false);
        },
        goPrev: function($slider) {
            $slider.flickity('previous', false);
        },
        goIndex: function() {
            History.pushState({
                type: 'index'
            }, $sitetitle, window.location.origin + $root);
        },
        loadContent: function(url, target) {
            $body.addClass('leaving');
            $slider = null;
            setTimeout(function() {
                $(target).load(url + ' #container .inner', function(response) {
                    setTimeout(function() {
                        $body.removeClass('leaving');
                        if (content.type == 'album') {
                            $body.attr('class', 'album');
                        } else if (content.type == 'page') {
                            $body.attr('class', 'page');
                        }
                    }, 100);
                    nav.classList.remove("visible");
                    void nav.offsetWidth;
                    if (content.type == 'album') {
                        $body.attr('class', 'album leaving');
                        app.plyr(false);
                        app.loadSlider();
                    } else if (content.type == 'page') {
                        $body.attr('class', 'page leaving');
                        app.plyr(false);
                    } else {
                        $body.attr('class', '');
                        app.plyr(true);
                        if (players && players.length > 0) {
                            players[0].on('ready', function(event) {
                                players[0].play();
                            });
                        }
                    }
                });
            }, 1000);
        },
        deferImages: function() {
            var imgDefer = document.getElementsByTagName('img');
            for (var i = 0; i < imgDefer.length; i++) {
                if (imgDefer[i].getAttribute('data-src')) {
                    imgDefer[i].setAttribute('src', imgDefer[i].getAttribute('data-src'));
                }
            }
        }
    };
    app.init();
});