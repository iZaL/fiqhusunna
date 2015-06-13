@extends('layouts.three_col')

@section('title')
    {{ $track->name }}
@endsection

@section('style')
    @parent
    <link href="/bower_components/jquery-ui/themes/hot-sneaks/jquery-ui.min.css" rel="stylesheet">
    {{--<link href="/css/jplayer.css" rel="stylesheet">--}}
    <style>

        .jp-gui ul li {
            list-style: none;
            cursor: pointer;
            float: right;
            padding: 10px;
            color: antiquewhite;
            background-color: rgb(219, 218, 215);
            margin: 0 10px;
            border-radius: 5px;
            font-size: 15px;
            max-width: 40px;
            min-width: 40px;
            text-align: center;
        }

        .player-icon {
            color: #646E7E;
        }

        li.jp-pause,
        li.jp-repeat-off,
        li.jp-unmute,
        .jp-no-solution {
            display: none;
        }

        .jp-progress-slider .ui-slider-handle {
            cursor: pointer;
        }

        .jp-volume-slider .ui-slider-handle {
            height: 8px;
            width: 8px;
            cursor: pointer;
        }

        .jp-gui.jp-no-volume .jp-volume-slider {
            display: none;
        }

        .ui-corner-all, .ui-corner-bottom, .ui-corner-right, .ui-corner-br {
            -webkit-border-radius: 0px;
            -moz-border-radius: 0px;
            border-radius: 0px;
        }

        .ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default {
            background-url: none;
            background: #13141D;
            border: none;
        }

        .ui-widget-header {
            background: none;
        }

        .slider-horizontal .ui-slider-handle {
            top: -4px;
        }

        .ui-slider .ui-slider-handle {
            z-index: 2;
            width: 3px;
            height: 15px;
        }

        .ui-slider-horizontal .ui-slider-handle {
            top: -4px;
            margin-left: -2px;
        }

        .ui-slider-horizontal {
            height: 8px;
        }

        .ui-widget-content {
            border: none;
            background: antiquewhite;
        }

    </style>
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

//            $('.jp-gui ul li').hover(
//                    function () {
//                        $(this).addClass('ui-state-hover');
//                    },
//                    function () {
//                        $(this).removeClass('ui-state-hover');
//                    }
//            );
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

    <div id="jquery_jplayer_1" class="jp-jplayer"></div>

    <div id="jp_container_1">
        <div class="jp-gui">
            <h1>{{$track->name}} </h1>

            <div class="col-md-12 pTop10">
                <a href="{{ action('TrackController@downloadTrack',$track->id) }}">
                    <i class="fa fa-download"></i>
                </a>
                {{ $track->downloads ? $track->downloads->count() : '0' }}
                &nbsp;&nbsp;&nbsp;
                <a href="#">
                    <i class="fa fa-eye"></i>
                </a>
                {{ $track->metas ? $track->metas->count() : '0' }}
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <ul>
                    <div class="col-md-2 col-sm-8 col-xs-5 mTop20">
                        <div class="jp-volume-slider ui-slider ui-slider-horizontal mTop15"
                             aria-disabled="false">
                            <div class="ui-slider-range ui-slider-range-min"
                                 style="width: 52%;"></div>
                            <a class="ui-slider-handle ui-state-default" href="#"
                               style="left: 52%;"></a>
                        </div>
                    </div>

                    <div class="col-md-2 col-sm-4 col-xs-5 mTop20">
                        <li class="jp-mute ">
                            <a href="javascript:;"
                               class="jp-mute"
                               tabindex="1" title="mute"><i
                                        class="fa fa-volume-off player-icon"></i></a>
                        </li>
                        <li class="jp-unmute" style="display: none;">
                            <a href="javascript:;" class="jp-unmute" tabindex="1"
                               title="unmute" style="display: none;"><i class="fa fa-volume-up player-icon"></i></a>
                        </li>
                        <li class="jp-repeat">
                            <a href="javascript:;" class="jp-repeat" tabindex="1"
                               title="repeat"><i class="fa fa-refresh player-icon"></i></a>
                        </li>
                        <li class="jp-repeat-off" style="display: none;">
                            <a href="javascript:;" class="jp-repeat-off" tabindex="1" title="repeat off"
                               style="display: none;">
                                <i class="fa fa-repeat player-icon"></i>
                            </a>
                        </li>

                    </div>

                    <div class="col-md-4 col-sm-8 col-xs-8 mTop20">
                        <div class="jp-progress-slider ui-slider ui-slider-horizontal mTop15"
                             aria-disabled="false">
                            <div class="ui-slider-range  ui-slider-range-min"
                                 style="width: 0%;"></div>
                            <a class="ui-slider-handle ui-state-default" href="#"
                               style="left: 0%;"></a>
                        </div>
                    </div>

                    <div class="col-md-2 col-sm-4 col-xs-4 mTop20">
                        <li class="jp-stop"><a href="javascript:;" class="jp-stop" tabindex="1" title="stop">
                                <i class="fa fa-stop player-icon"></i></a>
                        </li>

                        <li class="jp-play"><a href="javascript:;" class="jp-play" tabindex="1" title="play">
                                <i class="fa fa-play player-icon"></i></a>
                        </li>
                        <li class="jp-pause" style="display: none;"><a href="javascript:;" class="jp-pause" tabindex="1"
                                                                       title="pause" style="display: none;">
                                <i class="fa fa-pause player-icon"></i></a>
                        </li>


                    </div>

                </ul>

            </div>

        </div>

    </div>
@endsection