@extends('layouts.three_col')

@section('title')
    {{ $track->name }}
@endsection

@section('style')
    @parent
    <link href="/bower_components/jquery-ui/themes/hot-sneaks/jquery-ui.min.css" rel="stylesheet">
    <link href="/css/jplayer.css" rel="stylesheet">
@endsection

@section('script')
    @parent
    <script src="/bower_components/jplayer/dist/jplayer/jquery.jplayer.min.js"></script>
    <script src="/bower_components/jquery-ui/jquery-ui.min.js"></script>
    <script>
        $(document).ready(function () {

            var myPlayer = $("#jquery_jplayer_1"),
                    myPlayerData,
                    fixFlash_mp4, // Flag: The m4a and m4v Flash player gives some old currentTime values when changed.
                    fixFlash_mp4_id, // Timeout ID used with fixFlash_mp4
                    ignore_timeupdate, // Flag used with fixFlash_mp4
                    options = {
                        ready: function (event) {
                            // Hide the volume slider on mobile browsers. ie., They have no effect.
                            if (event.jPlayer.status.noVolume) {
                                // Add a class and then CSS rules deal with it.
                                $(".jp-gui").addClass("jp-no-volume");
                            }
                            // Determine if Flash is being used and the mp4 media type is supplied. BTW, Supplying both mp3 and mp4 is pointless.
                            fixFlash_mp4 = event.jPlayer.flash.used && /m4a|m4v/.test(event.jPlayer.options.supplied);
                            // Setup the player with media.
                            $(this).jPlayer("setMedia", {
                                // mp3: "http://www.jplayer.org/audio/mp3/Miaow-07-Bubble.mp3",
                                title: '{{ $track->title }}',
                                {{--mp3: '{{$trackPath.'//'.$track->url}}',--}}
                                mp3: '{{$trackUrl }}',
                            });
                        },
                        timeupdate: function (event) {
                            if (!ignore_timeupdate) {
                                myControl.progress.slider("value", event.jPlayer.status.currentPercentAbsolute);
                            }
                        },
                        volumechange: function (event) {
                            if (event.jPlayer.options.muted) {
                                myControl.volume.slider("value", 0);
                            } else {
                                myControl.volume.slider("value", event.jPlayer.options.volume);
                            }
                        },
                        swfPath: "../dist/jplayer",
                        supplied: "mp3",
                        cssSelectorAncestor: "#jp_container_1",
                        wmode: "window",
                        keyEnabled: true
                    },
                    myControl = {
                        progress: $(options.cssSelectorAncestor + " .jp-progress-slider"),
                        volume: $(options.cssSelectorAncestor + " .jp-volume-slider")
                    };

            // Instance jPlayer
            myPlayer.jPlayer(options);

            // A pointer to the jPlayer data object
            myPlayerData = myPlayer.data("jPlayer");

            $('.jp-gui ul li').hover(
                    function () {
                        $(this).addClass('ui-state-hover');
                    },
                    function () {
                        $(this).removeClass('ui-state-hover');
                    }
            );
//
//        // Create the progress slider control
            myControl.progress.slider({
                animate: "fast",
                max: 100,
                range: "min",
                step: 0.1,
                value: 0,
                slide: function (event, ui) {
                    var sp = myPlayerData.status.seekPercent;
                    if (sp > 0) {
                        // Apply a fix to mp4 formats when the Flash is used.
                        if (fixFlash_mp4) {
                            ignore_timeupdate = true;
                            clearTimeout(fixFlash_mp4_id);
                            fixFlash_mp4_id = setTimeout(function () {
                                ignore_timeupdate = false;
                            }, 1000);
                        }
                        // Move the play-head to the value and factor in the seek percent.
                        myPlayer.jPlayer("playHead", ui.value * (100 / sp));
                    } else {
                        // Create a timeout to reset this slider to zero.
                        setTimeout(function () {
                            myControl.progress.slider("value", 0);
                        }, 0);
                    }
                }
            });

            // Create the volume slider control
            myControl.volume.slider({
                animate: "fast",
                max: 1,
                range: "min",
                step: 0.01,
                value: $.jPlayer.prototype.options.volume,
                slide: function (event, ui) {
                    myPlayer.jPlayer("option", "muted", false);
                    myPlayer.jPlayer("option", "volume", ui.value);
                }
            });

        });

    </script>
@endsection

@section('content')

    <div class="no-gutter row">

        <div id="jquery_jplayer_1" class="jp-jplayer"></div>

        <div id="jp_container_1">
            <div class="jp-gui ui-widget ui-widget-content ui-corner-all">
                <div class="row">
                    <div class="col-md-6 col-sm-12 col-xs-12">

                        <ul>

                            <div class="col-md-2 col-sm-6 col-xs-5">
                                <div class="jp-volume-slider ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all"
                                     aria-disabled="false">
                                    <div class="ui-slider-range ui-widget-header ui-corner-all ui-slider-range-min"
                                         style="width: 52%;"></div>
                                    <a class="ui-slider-handle ui-state-default ui-corner-all" href="#"
                                       style="left: 52%;"></a>
                                </div>
                            </div>

                            <div class="col-md-3 col-sm-4 col-xs-5">
                                <li class="jp-repeat ui-state-default ui-corner-all"><a href="javascript:;"
                                                                                        class="jp-repeat ui-icon ui-icon-refresh"
                                                                                        tabindex="1"
                                                                                        title="repeat">repeat</a>
                                </li>
                                <li class="jp-repeat-off ui-state-default ui-state-active ui-corner-all"
                                    style="display: none;">
                                    <a
                                            href="javascript:;" class="jp-repeat-off ui-icon ui-icon-refresh"
                                            tabindex="1"
                                            title="repeat off" style="display: none;">repeat off</a></li>
                                <li class="jp-mute ui-state-default ui-corner-all"><a href="javascript:;"
                                                                                      class="jp-mute ui-icon ui-icon-volume-off"
                                                                                      tabindex="1" title="mute">mute</a>
                                </li>
                                <li class="jp-unmute ui-state-default ui-state-active ui-corner-all"
                                    style="display: none;">
                                    <a
                                            href="javascript:;" class="jp-unmute ui-icon ui-icon-volume-off"
                                            tabindex="1"
                                            title="unmute" style="display: none;">unmute</a></li>
                                <li class="jp-volume-max ui-state-default ui-corner-all"><a href="javascript:;"
                                                                                            class="jp-volume-max ui-icon ui-icon-volume-on"
                                                                                            tabindex="1"
                                                                                            title="max volume">max
                                        volume</a></li>

                            </div>

                            <div class="col-md-4 col-sm-8 col-xs-8">
                                <div class="jp-progress-slider ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all"
                                     aria-disabled="false">
                                    <div class="ui-slider-range ui-widget-header ui-corner-all ui-slider-range-min"
                                         style="width: 0%;"></div>
                                    <a class="ui-slider-handle ui-state-default ui-corner-all" href="#"
                                       style="left: 0%;"></a>
                                </div>
                            </div>

                            <div class="col-md-2 col-sm-4 col-xs-4">
                                <li class="jp-play ui-state-default ui-corner-all"><a href="javascript:;"
                                                                                      class="jp-play ui-icon ui-icon-play"
                                                                                      tabindex="1" title="play">play</a>
                                </li>
                                <li class="jp-pause ui-state-default ui-corner-all" style="display: none;"><a
                                            href="javascript:;"
                                            class="jp-pause ui-icon ui-icon-pause"
                                            tabindex="1"
                                            title="pause"
                                            style="display: none;">pause</a>
                                </li>

                                <li class="jp-stop ui-state-default ui-corner-all"><a href="javascript:;"
                                                                                      class="jp-stop ui-icon ui-icon-stop"
                                                                                      tabindex="1" title="stop">stop</a>

                                </li>

                            </div>

                        </ul>

                    </div>
                    <div class="col-md-12 pTop10">
                        <div class="col-md-2">
                            <div class="col-md-1 col-sm-3 col-xs-3">
                                <ul>
                                    <li class="ui-state-default ui-corner-all ">
                                        <a href="#">
                                            <i class="fa fa-download icon-download"></i>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                            <div class="col-md-2 col-sm-3 col-xs-3">
                                10202
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="col-md-1 col-sm-3 col-xs-3">
                                <ul>
                                    <li class="ui-state-default ui-corner-all ">
                                        <a href="#">
                                            <i class="fa fa-eye icon-download"></i>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                            <div class="col-md-2 col-sm-3 col-xs-3">
                                10202
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="jp-no-solution" style="display: none;">
                <span>Update Required</span>
                To play the media you will need to either update your browser to a recent version or update your <a
                        href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
            </div>
        </div>
    </div>
@endsection