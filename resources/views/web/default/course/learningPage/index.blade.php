@extends('web.default.layouts.app',['appFooter' => false, 'appHeader' => false])
@php
use App\Models\ScormSession;
@endphp
    
    @push('styles_top')
        <link rel="stylesheet" href="/assets/default/learning_page/styles.css"/>
        <link rel="stylesheet" href="/assets/default/vendors/video/video-js.min.css">
    @endpush
    
    @section('content')
    @if ($course->scorm_folder && $course->scorm_launch_path)

    <iframe 
    width="100%" style="height: 100vh; margin: 0px;border: none;" 
    src="{{ route('scorm.asset.solve', ['folder' => str_replace('scorm/', '', $course->scorm_folder), 'path' => $course->scorm_launch_path]) }}"
    allowfullscreen>
</iframe>
    <script>
var sessionId = null;

var API = {
    LMSInitialize: function() {
        return fetch('/scorm/runtime/initialize', {
            method: 'POST',
            headers: {
                'Content-Type':'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ webinar_id: "{{ $course->id }}" })
        })
        .then(res => res.json())
        .then(data => { sessionId = data.session_id; return "true"; })
        .catch(err => { console.error(err); return "false"; });
    },
    LMSSetValue: function(key, value) {
        return fetch('/scorm/runtime/setvalue', {
            method: 'POST',
            headers: {
                'Content-Type':'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ session_id: sessionId, key, value })
        }).then(() => "true")
          .catch(err => { console.error(err); return "false"; });
    },
    LMSGetValue: function(key) {
        return fetch('/scorm/runtime/getvalue', {
            method: 'POST',
            headers: {
                'Content-Type':'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ session_id: sessionId, key })
        })
        .then(res => res.json())
        .then(data => data.value)
        .catch(err => { console.error(err); return ""; });
    },
    LMSCommit: function() {
        return fetch('/scorm/runtime/commit', {
            method: 'POST',
            headers: {
                'Content-Type':'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ session_id: sessionId })
        }).then(() => "true")
          .catch(err => { console.error(err); return "false"; });
    },
    LMSFinish: function() {
        return fetch('/scorm/runtime/finish', {
            method: 'POST',
            headers: {
                'Content-Type':'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ session_id: sessionId })
        }).then(() => "true")
          .catch(err => { console.error(err); return "false"; });
    },
    LMSGetLastError: function() { return "0"; }
};
</script>


    @else
        <div class="learning-page">
    
            @include('web.default.course.learningPage.components.navbar')
    
            <div class="d-flex position-relative">
                <div class="learning-page-content flex-grow-1 bg-info-light p-15">
                    @include('web.default.course.learningPage.components.content')
                </div>
    
                <div class="learning-page-tabs show">
                    <ul class="nav nav-tabs py-15 d-flex align-items-center justify-content-around" id="tabs-tab" role="tablist">
                        <li class="nav-item">
                            <a class="position-relative font-14 d-flex align-items-center active" id="content-tab"
                               data-toggle="tab" href="#content" role="tab" aria-controls="content"
                               aria-selected="true">
                                <i class="learning-page-tabs-icons mr-5">
                                    @include('web.default.panel.includes.sidebar_icons.webinars')
                                </i>
                                <span class="learning-page-tabs-link-text">{{ trans('product.content') }}</span>
                            </a>
                        </li>
    
                        <li class="nav-item">
                            <a class="position-relative font-14 d-flex align-items-center" id="quizzes-tab" data-toggle="tab"
                               href="#quizzes" role="tab" aria-controls="quizzes"
                               aria-selected="false">
                                <i class="learning-page-tabs-icons mr-5">
                                    @include('web.default.panel.includes.sidebar_icons.quizzes')
                                </i>
                                <span class="learning-page-tabs-link-text">{{ trans('quiz.quizzes') }}</span>
                            </a>
                        </li>
    
                        <li class="nav-item">
                            <a class="position-relative font-14 d-flex align-items-center" id="certificates-tab" data-toggle="tab"
                               href="#certificates" role="tab" aria-controls="certificates"
                               aria-selected="false">
                                <i class="learning-page-tabs-icons mr-5">
                                    @include('web.default.panel.includes.sidebar_icons.certificate')
                                </i>
                                <span class="learning-page-tabs-link-text">{{ trans('panel.certificates') }}</span>
                            </a>
                        </li>
                    </ul>
    
                    <div class="tab-content h-100" id="nav-tabContent">
                        <div class="pb-20 tab-pane fade show active h-100" id="content" role="tabpanel"
                             aria-labelledby="content-tab">
                            @include('web.default.course.learningPage.components.content_tab.index')
                        </div>
    
                        <div class="pb-20 tab-pane fade  h-100" id="quizzes" role="tabpanel"
                             aria-labelledby="quizzes-tab">
                            @include('web.default.course.learningPage.components.quiz_tab.index')
                        </div>
    
                        <div class="pb-20 tab-pane fade  h-100" id="certificates" role="tabpanel"
                             aria-labelledby="certificates-tab">
                            @include('web.default.course.learningPage.components.certificate_tab.index')
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endif
@endsection

@push('scripts_bottom')
    <script src="/assets/default/vendors/video/video.min.js"></script>
    <script src="/assets/default/vendors/video/youtube.min.js"></script>
   <!-- <script src="/assets/default/vendors/video/vimeo.js"></script>-->

    <script>
        var defaultItemType = '{{ !empty(request()->get('type')) ? request()->get('type') : (!empty($userLearningLastView) ? $userLearningLastView->item_type : '') }}'
        var defaultItemId = '{{ !empty(request()->get('item')) ? request()->get('item') : (!empty($userLearningLastView) ? $userLearningLastView->item_id : '') }}'
        var loadFirstContent = {{ (!empty($dontAllowLoadFirstContent) and $dontAllowLoadFirstContent) ? 'false' : 'true' }}; // allow to load first content when request item is empty

        var appUrl = '{{ url('') }}';
        var courseUrl = '{{ $course->getUrl() }}';
        var courseNotesStatus = '{{ !empty(getFeaturesSettings('course_notes_status')) }}';
        var courseNotesShowAttachment = '{{ !empty(getFeaturesSettings('course_notes_attachment')) }}';

        // lang
        var pleaseWaitForTheContentLang = '{{ trans('update.please_wait_for_the_content_to_load') }}';
        var downloadTheFileLang = '{{ trans('update.download_the_file') }}';
        var downloadLang = '{{ trans('home.download') }}';
        var showHtmlFileLang = '{{ trans('update.show_html_file') }}';
        var showLang = '{{ trans('update.show') }}';
        var sessionIsLiveLang = '{{ trans('update.session_is_live') }}';
        var youCanJoinTheLiveNowLang = '{{ trans('update.you_can_join_the_live_now') }}';
        var passwordLang = '{{ trans('auth.password') }}';
        var joinTheClassLang = '{{ trans('update.join_the_class') }}';
        var coursePageLang = '{{ trans('update.course_page') }}';
        var quizPageLang = '{{ trans('update.quiz_page') }}';
        var sessionIsNotStartedYetLang = '{{ trans('update.session_is_not_started_yet') }}';
        var thisSessionWillBeStartedOnLang = '{{ trans('update.this_session_will_be_started_on') }}';
        var sessionIsFinishedLang = '{{ trans('update.session_is_finished') }}';
        var sessionIsFinishedHintLang = '{{ trans('update.this_session_is_finished_You_cant_join_it') }}';
        var goToTheQuizPageForMoreInformationLang = '{{ trans('update.go_to_the_quiz_page_for_more_information') }}';
        var downloadCertificateLang = '{{ trans('update.download_certificate') }}';
        var enjoySharingYourCertificateWithOthersLang = '{{ trans('update.enjoy_sharing_your_certificate_with_others') }}';
        var attachmentsLang = '{{ trans('public.attachments') }}';
        var checkAgainLang = '{{ trans('update.check_again') }}';
        var learningToggleLangSuccess = '{{ trans('public.course_learning_change_status_success') }}';
        var learningToggleLangError = '{{ trans('public.course_learning_change_status_error') }}';
        var sequenceContentErrorModalTitle = '{{ trans('update.sequence_content_error_modal_title') }}';
        var sendAssignmentSuccessLang = '{{ trans('update.send_assignment_success') }}';
        var saveAssignmentRateSuccessLang = '{{ trans('update.save_assignment_grade_success') }}';
        var saveSuccessLang = '{{ trans('webinars.success_store') }}';
        var changesSavedSuccessfullyLang = '{{ trans('update.changes_saved_successfully') }}';
        var oopsLang = '{{ trans('update.oops') }}';
        var somethingWentWrongLang = '{{ trans('update.something_went_wrong') }}';
        var notAccessToastTitleLang = '{{ trans('public.not_access_toast_lang') }}';
        var notAccessToastMsgLang = '{{ trans('public.not_access_toast_msg_lang') }}';
        var cantStartQuizToastTitleLang = '{{ trans('public.request_failed') }}';
        var cantStartQuizToastMsgLang = '{{ trans('quiz.cant_start_quiz') }}';
        var learningPageEmptyContentTitleLang = '{{ trans('update.learning_page_empty_content_title') }}';
        var learningPageEmptyContentHintLang = '{{ trans('update.learning_page_empty_content_hint') }}';
        var expiredQuizLang = '{{ trans('update.expired_quiz') }}';
        var personalNoteLang = '{{ trans('update.personal_note') }}';
        var personalNoteHintLang = '{{ trans('update.this_note_will_be_displayed_for_you_privately') }}';
        var attachmentLang = '{{ trans('update.attachment') }}';
        var saveNoteLang = '{{ trans('update.save_note') }}';
        var clearNoteLang = '{{ trans('update.clear_note') }}';
        var personalNoteStoredSuccessfullyLang = '{{ trans('update.personal_note_stored_successfully') }}';
    </script>
    <script type="text/javascript" src="/assets/default/vendors/dropins/dropins.js"></script>
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>

    <script src="/assets/default/js/parts/video_player_helpers.min.js"></script>
    <script src="/assets/learning_page/scripts.min.js"></script>

    @if((!empty($isForumPage) and $isForumPage) or (!empty($isForumAnswersPage) and $isForumAnswersPage))
        <script src="/assets/learning_page/forum.min.js"></script>
    @endif
 <script>
     
     /* The MIT License (MIT)
Copyright (c) 2014-2015 Benoit Tremblay <trembl.ben@gmail.com>
Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:
The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.
THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE. */
(function (root, factory) {
  if(typeof define === 'function' && define.amd) {
    define(['video.js'], function(videojs){
      return (root.Vimeo = factory(videojs));
    });
  } else if(typeof module === 'object' && module.exports) {
    module.exports = (root.Vimeo = factory(require('video.js')));
  } else {
    root.Vimeo = factory(root.videojs);
  }
}(this, function(videojs) {
  'use strict';

  var VimeoState = {
    UNSTARTED: -1,
    ENDED: 0,
    PLAYING: 1,
    PAUSED: 2,
    BUFFERING: 3
  };
window.iframeId = null; // Global variable to store the iframe ID

  var Tech = videojs.getComponent('Tech');
 let previousTime = 7

  var Vimeo = videojs.extend(Tech, {
    constructor: function(options, ready) {
      Tech.call(this, options, ready);
      if(options.poster != "") {this.setPoster(options.poster);}
      this.setSrc(this.options_.source.src);
 var iframe = this.iframe; // Access the iframe element
    if (iframe) {
      iframe.onload = function() {
        window.iframeId = iframe.id; // Store the iframe ID in the global variable
        console.log("Extracted iframe ID:", window.iframeId); // Log the iframe ID
      };
    } else {
      console.error("Iframe is not available yet.");
    }
      // Set the vjs-vimeo class to the player
      // Parent is not set yet so we have to wait a tick
      setTimeout(function() {
        this.el_.parentNode.className += ' vjs-vimeo';

        if (Vimeo.isApiReady) {
          this.initPlayer();
        } else {
          Vimeo.apiReadyQueue.push(this);
        }
      }.bind(this));
      
      
      
      
      
      
      

    },
      playbackRate: function(rate) {
    if (rate !== undefined) {
      console.warn('Vimeo does not support playbackRate');
    }
    return 1; // Always return 1 for normal playback speed
  },

    dispose: function() {
      this.el_.parentNode.className = this.el_.parentNode.className.replace(' vjs-vimeo', '');
    },

    loadPoster: function() {
      $.getJSON(this.baseApiUrl + this.videoId + '.json?callback=?', {format: "json"}, (function(_this){
        return function(data) {
          // Set the duration of the video, since it must be manually tracked with vimeo.
          _this.vimeoInfo.duration = data[0].duration;
          _this.player_.duration(_this.vimeoInfo.duration);

          // Set the low resolution first
          if(_this.options_.poster == "") {
            if (data[0].thumbnail_large) {
              _this.setPoster(data[0].thumbnail_large);
            }
            else if (data[0].thumbnail_medium) {
              _this.setPoster(data[0].thumbnail_medium);
            }
            else {
              _this.setPoster(data[0].thumbnail_small);
            }

            _this.poster(_this.poster_);
            _this.trigger('posterchange');
            $(_this).find('.vjs-poster').css({
              'background-image': 'url(' + _this.poster_ + ')'
            });
          }
        };
      })(this));
    },

    createEl: function() {
        
      this.vimeo = {};
      this.vimeoInfo = {};
      this.baseUrl = 'https://player.vimeo.com/video/';
      this.baseApiUrl = '//www.vimeo.com/api/v2/video/';
      this.videoId = Vimeo.parseUrl(this.options_.source.src).videoId;

      this.iframe = document.createElement('iframe');
      this.iframe.setAttribute('id', this.options_.techId);
      this.iframe.setAttribute('title', 'Vimeo Video Player');
      this.iframe.setAttribute('class', 'vimeoplayer');
      this.iframe.setAttribute('src', this.baseUrl + this.videoId + '?api=1&player_id=' + this.options_.techId);
      this.iframe.setAttribute('frameborder', '0');
      this.iframe.setAttribute('scrolling', 'no');
      this.iframe.setAttribute('marginWidth', '0');
      this.iframe.setAttribute('marginHeight', '0');
      this.iframe.setAttribute('webkitAllowFullScreen', '0');
      this.iframe.setAttribute('mozallowfullscreen', '0');
      this.iframe.setAttribute('allowFullScreen', '0');

      var divWrapper = document.createElement('div');
      divWrapper.setAttribute('style', 'margin:0 auto;padding-bottom:56.25%;width:100%;height:0;position:relative;overflow:hidden;');
      divWrapper.setAttribute('class', 'vimeoFrame');
      divWrapper.appendChild(this.iframe);

      if (!_isOnMobile && !this.options_.ytControls) {
        var divBlocker = document.createElement('div');
        divBlocker.setAttribute('class', 'vjs-iframe-blocker');
        divBlocker.setAttribute('style', 'position:absolute;top:0;left:0;width:100%;height:100%');

        // In case the blocker is still there and we want to pause
        divBlocker.onclick = function() {
          this.onPause();
        }.bind(this);

        divWrapper.appendChild(divBlocker);
      }

      if (Vimeo.isApiReady) {
        this.initPlayer();
      } else {
        Vimeo.apiReadyQueue.push(this);
      }

      if(this.options_.poster == "" && this.videoId != null) {
        this.loadPoster();
      }

      return divWrapper;
    },
   /*
initPlayer: function() {
  var self = this;

  // Initialize Vimeo player when iframe is loaded
  $(self.iframe).load(function() {
    // Unload any existing Vimeo player instance
    if (self.vimeo && self.vimeo.api) {
      self.vimeo.api('unload');
      delete self.vimeo;
    }

    // Initialize the Vimeo player
    self.vimeo = $f(self.iframe);
    console.log(self.videoId); // Logs the video ID

    // Initialize Vimeo player info
    self.vimeoInfo = {
      state: VimeoState.UNSTARTED,
      volume: 1,
      muted: false,
      muteVolume: 1,
      time: 0, // Current playback time
      duration: 0, // Total video duration
      buffered: 0,
      url: self.baseUrl + self.videoId,
      error: null,
      seeking: false // Track whether seeking is in progress
    };

    // Variable to store the supposed current time
    var supposedCurrentTime = 0;

    // Add event listeners for the Vimeo player
    self.vimeo.addEvent('ready', function(id) {
      self.onReady();

      // Track progress events
      self.vimeo.addEvent('loadProgress', function(data, id) { 
        self.onLoadProgress(data); 
      });

      self.vimeo.addEvent('playProgress', function(data, id) { 
        self.onPlayProgress(data); 
        self.vimeoInfo.time = data.seconds; // Update current playback time
      });

      // Listen for time updates
      self.vimeo.addEvent('playProgress', function(data, id) {
        if (!self.vimeoInfo.seeking) {
          supposedCurrentTime = data.seconds; // Update the supposed current time
        }
      });

      // Handle play/pause/finish events
      self.vimeo.addEvent('play', function(id) { 
        self.onPlay(); 
      });
      self.vimeo.addEvent('pause', function(id) { 
        self.onPause(); 
      });

      // Handle video finish event
      self.vimeo.addEvent('finish', function(id) {
        self.onFinish();

        // Collect video data
        var videoData = {
          videoId: self.videoId,
          duration: self.vimeoInfo.duration,
          playbackTime: self.vimeoInfo.time,
          completed: true // Indicates the video has ended
        };

        // Send video data to Laravel route
        fetch('/api/xapi/statement', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // For CSRF protection
          },
          body: JSON.stringify(videoData)
        })
        .then(response => {
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          return response.json();
        })
        .then(data => {
          console.log('Video data successfully sent to Laravel:', data);
        })
        .catch(error => {
          console.error('Error sending video data to Laravel:', error);
        });
      });

      // Prevent seeking
      self.vimeo.addEvent('seek', function(data, id) {
        var delta = data.seconds - supposedCurrentTime;

        // Check if the user tried to seek (delta > 0.01 seconds)
        if (Math.abs(delta) > 0.01) {
          console.warn(`Seeking attempt detected at ${data.seconds} seconds. Resetting to ${supposedCurrentTime} seconds.`);

          // Revert to the previous time
          self.vimeo.api('setCurrentTime', supposedCurrentTime);

          // Optionally pause the video briefly to discourage further seeking attempts
          self.vimeo.api('pause');

          // Resume playback after a short delay
          setTimeout(function() {
            self.vimeo.api('play');
          }, 100); // Small delay to ensure smooth behavior
        }
      });
    });

    // Pause video when user leaves the browser tab
    document.addEventListener('visibilitychange', function() {
      if (document.visibilityState === 'hidden') {
        // Pause the video
        self.vimeo.api('pause');
      } else if (document.visibilityState === 'visible') {
        // Resume the video
        self.vimeo.api('play');
      }
    });
  });
},
*/

 initPlayer: function() {
  var self = this;
  $(self.iframe).load(function() {
    // Unload any existing Vimeo player instance
    if (self.vimeo && self.vimeo.api) {
      self.vimeo.api('unload');
      delete self.vimeo;
    }

    // Initialize the Vimeo player
    self.vimeo = $f(self.iframe);
    console.log(self.videoId); // Logs the video ID

    // Initialize Vimeo player info
    self.vimeoInfo = {
      state: VimeoState.UNSTARTED,
      volume: 1,
      muted: false,
      muteVolume: 1,
      time: 0,
      duration: 0,
      buffered: 0,
      url: self.baseUrl + self.videoId,
      error: null
    };

    // Add event listeners for the Vimeo player
    self.vimeo.addEvent('ready', function(id) {
      self.onReady();

      // Track progress events
      self.vimeo.addEvent('loadProgress', function(data, id) { 
        self.onLoadProgress(data); 
      });
      self.vimeo.addEvent('playProgress', function(data, id) { 
        self.onPlayProgress(data); 
      });

      // Handle play/pause/finish events
      self.vimeo.addEvent('play', function(id) { 
        self.onPlay(); 
      });
      self.vimeo.addEvent('pause', function(id) { 
        self.onPause(); 
      });
      self.vimeo.addEvent('finish', function(id) { 
        self.onFinish(); 
      });

     // Prevent seeking
      self.vimeo.addEvent('seek', function(data, id) {
        // Reset the video to the previous time or a fixed position
        var currentTime = data.seconds; // Current time after seeking
        console.log('current time',currentTime);
        var allowedTime = 0; // Set this to the desired fixed position (e.g., start of the video)
        // Prevent seeking by resetting the time
        self.vimeo.api('setCurrentTime', allowedTime);

        // Optionally log the attempt to seek
        console.warn(`Seeking attempt detected at ${currentTime} seconds. Resetting to ${allowedTime} seconds.`);
      });
      
 

       // Pause video when user leaves the browser tab
    document.addEventListener('visibilitychange', function() {
      if (document.visibilityState === 'hidden') {
        // Pause the video
        self.vimeo.api('pause');
      } else if (document.visibilityState === 'visible') {
        // Resume the video
        self.vimeo.api('play');
      }
    });
    });
  });
}, 
      onReady: function(){
          console.log(this);
          
          console.log()
      this.playerReady_ = true;
      this.triggerReady();
      this.trigger('loadedmetadata');
      if (this.startMuted) {
        this.setMuted(true);
        this.startMuted = false;
      }
    },

    onLoadProgress: function(data) {
      var durationUpdate = !this.vimeoInfo.duration;
      this.vimeoInfo.duration = data.duration;
      this.vimeoInfo.buffered = data.percent;
      this.trigger('progress');
      if (durationUpdate) this.trigger('durationchange');
    },
    onPlayProgress: function(data) {
      this.vimeoInfo.time = data.seconds;
    //  this.trigger('timeupdate');
    },
    onPlay: function() {
        console.log('plaaaaaay');
      this.vimeoInfo.state = VimeoState.PLAYING;
      this.trigger('play');
    },
    onPause: function() {
      this.vimeoInfo.state = VimeoState.PAUSED;
      this.trigger('pause');
    },
    onFinish: function() {
      this.vimeoInfo.state = VimeoState.ENDED;
      this.trigger('ended');
    },
 
    onError: function(error){
      this.error = error;
      this.trigger('error');
    },
           
    error: function() {
      switch (this.errorNumber) {
        case 2:
          return { code: 'Unable to find the video' };

        case 5:
          return { code: 'Error while trying to play the video' };

        case 100:
          return { code: 'Unable to find the video' };

        case 101:
        case 150:
          return { code: 'Playback on other Websites has been disabled by the video owner.' };
      }

      return { code: 'Vimeo unknown error (' + this.errorNumber + ')' };
    },

    src: function(src) {
      if (src) {
        this.setSrc({ src: src });

        if (this.options_.autoplay && !_isOnMobile) {
          this.play();
        }
      }

      return this.source;
    },

    poster: function() {
      return this.poster_;
    },

    setPoster: function(poster) {
      this.poster_ = poster;
    },

    setSrc: function(source) {
      if (!source || !source.src) {
        return;
      }

      if (source.src && this.options_ && this.options.source && this.options.source.src) {
        this.options_.source.src = source.src;
      }

      this.source = source;
      this.url = Vimeo.parseUrl(source.src);

      if (!this.options_.poster) {
        if (this.url.videoId) {
          // Update iframe refs on url change.
          this.videoId = this.url.videoId;
          this.iframe.setAttribute('src', this.baseUrl + this.videoId + '?api=1&player_id=' + this.options_.techId);

          // Update the poster on source change.
          this.loadPoster();
        }
      }

      if (this.options_.autoplay && !_isOnMobile) {
        if (this.isReady_) {
          this.play();
        } else {
          this.playOnReady = true;
        }
      }
    },

    supportsFullScreen: function() {
      return true;
    },

    //TRIGGER
    load: function(){
      this.initPlayer();
      this.loadPoster();
    },
    play: function(){ this.vimeo.api('play'); },
    pause: function(){ this.vimeo.api('pause'); },
    paused: function(){
      return this.vimeoInfo.state !== VimeoState.PLAYING &&
             this.vimeoInfo.state !== VimeoState.BUFFERING;
    },

    currentTime: function(){ return this.vimeoInfo.time || 0; },

    setCurrentTime: function(seconds){
       
      this.vimeo.api('seekTo', seconds);
      console.log("it is seekeeeed");
   //  this.player_.trigger('timeupdate');
    },

    duration: function(){ return this.vimeoInfo.duration || 0; },
    buffered: function(){ return videojs.createTimeRange(0, (this.vimeoInfo.buffered*this.vimeoInfo.duration) || 0); },

    volume: function() { return (this.vimeoInfo.muted)? this.vimeoInfo.muteVolume : this.vimeoInfo.volume; },
    setVolume: function(percentAsDecimal){
      this.vimeo.api('setvolume', percentAsDecimal);
      this.vimeoInfo.volume = percentAsDecimal;
      this.player_.trigger('volumechange');
    },
    currentSrc: function() {
      return this.el_.src;
    },
    muted: function() { return this.vimeoInfo.muted || false; },
    setMuted: function(muted) {
      if (muted) {
        this.vimeoInfo.muteVolume = this.vimeoInfo.volume;
        this.setVolume(0);
      } else {
        this.setVolume(this.vimeoInfo.muteVolume);
      }

      this.vimeoInfo.muted = muted;
      this.player_.trigger('volumechange');
    },

    // Tries to get the highest resolution thumbnail available for the video
    checkHighResPoster: function(){
      var uri = '';

      try {
        if(this.url.videoId != null){
          $.getJSON(this.baseApiUrl + this.videoId + '.json?callback=?', {format: "json"}, (function(_uri){
            return function(data) {
              // Set the low resolution first
              _uri = data[0].thumbnail_large;
            };
          })(uri));

          var image = new Image();
          image.onload = function(){
            // Onload thumbnail
            if('naturalHeight' in this){
              if(this.naturalHeight <= 90 || this.naturalWidth <= 120) {
                this.onerror();
                return;
              }
            } else if(this.height <= 90 || this.width <= 120) {
              this.onerror();
              return;
            }

            this.poster_ = uri;
            this.trigger('posterchange');
          }.bind(this);
          image.onerror = function(){};
          image.src = uri;
        }
      }
      catch(e){}
    }
  });

  Vimeo.isSupported = function() {
    return true;
  };

  Vimeo.canPlaySource = function(e) {
    return (e.type === 'video/vimeo');
  };

  var _isOnMobile = /(iPad|iPhone|iPod|Android)/g.test(navigator.userAgent);

  Vimeo.parseUrl = function(url) {
    var result = {
      videoId: null
    };

    var regex = /^.*(vimeo\.com\/)((channels\/[A-z]+\/)|(groups\/[A-z]+\/videos\/))?([0-9]+)/;
    var match = url.match(regex);

    if (match) {
      result.videoId = match[5];
    }

    return result;
  };

  function injectCss() {
    var css = // iframe blocker to catch mouse events
              '.vjs-vimeo { overflow: hidden }' +
              '.vjs-vimeo .vjs-iframe-blocker { display: none; }' +
              '.vjs-vimeo.vjs-user-inactive .vjs-iframe-blocker { display: block; }' +
              '.vjs-vimeo .vjs-poster { background-size: cover; }' +
              '.vjs-vimeo { height:100%; }' +
              '.vimeoplayer { width:100%; height:180%; position:absolute; left:0; top:-40%; }';

    var head = document.head || document.getElementsByTagName('head')[0];

    var style = document.createElement('style');
    style.type = 'text/css';

    if (style.styleSheet){
      style.styleSheet.cssText = css;
    } else {
      style.appendChild(document.createTextNode(css));
    }

    head.appendChild(style);
  }

  Vimeo.apiReadyQueue = [];

  var vimeoIframeAPIReady = function() {
    Vimeo.isApiReady = true;
    injectCss();

    for (var i = 0; i < Vimeo.apiReadyQueue.length; ++i) {
      Vimeo.apiReadyQueue[i].initPlayer();
    }
  };

  vimeoIframeAPIReady();

  videojs.registerTech('Vimeo', Vimeo);

  // Froogaloop API -------------------------------------------------------------
  // From https://github.com/vimeo/player-api/blob/master/javascript/froogaloop.js
  // Init style shamelessly stolen from jQuery http://jquery.com
  var Froogaloop = (function(){
      // Define a local copy of Froogaloop
      function Froogaloop(iframe) {
          // The Froogaloop object is actually just the init constructor
          return new Froogaloop.fn.init(iframe);
      }

      var eventCallbacks = {},
          hasWindowEvent = false,
          isReady = false,
          slice = Array.prototype.slice,
          playerOrigin = '*';

      Froogaloop.fn = Froogaloop.prototype = {
          element: null,

          init: function(iframe) {
              if (typeof iframe === "string") {
                  iframe = document.getElementById(iframe);
              }

              this.element = iframe;

              return this;
          },

          /*
           * Calls a function to act upon the player.
           *
           * @param {string} method The name of the Javascript API method to call. Eg: 'play'.
           * @param {Array|Function} valueOrCallback params Array of parameters to pass when calling an API method
           *                                or callback function when the method returns a value.
           */
          api: function(method, valueOrCallback) {
              if (!this.element || !method) {
                  return false;
              }

              var self = this,
                  element = self.element,
                  target_id = element.id !== '' ? element.id : null,
                  params = !isFunction(valueOrCallback) ? valueOrCallback : null,
                  callback = isFunction(valueOrCallback) ? valueOrCallback : null;

              // Store the callback for get functions
              if (callback) {
                  storeCallback(method, callback, target_id);
              }

              postMessage(method, params, element);
              return self;
          },

          /*
           * Registers an event listener and a callback function that gets called when the event fires.
           *
           * @param eventName (String): Name of the event to listen for.
           * @param callback (Function): Function that should be called when the event fires.
           */
          addEvent: function(eventName, callback) {
              if (!this.element) {
                  return false;
              }

              var self = this,
                  element = self.element,
                  target_id = element.id !== '' ? element.id : null;


              storeCallback(eventName, callback, target_id);

              // The ready event is not registered via postMessage. It fires regardless.
              if (eventName != 'ready') {
                  postMessage('addEventListener', eventName, element);
              }
              else if (eventName == 'ready' && isReady) {
                  callback.call(null, target_id);
              }

              return self;
          },

          /*
           * Unregisters an event listener that gets called when the event fires.
           *
           * @param eventName (String): Name of the event to stop listening for.
           */
          removeEvent: function(eventName) {
              if (!this.element) {
                  return false;
              }

              var self = this,
                  element = self.element,
                  target_id = element.id !== '' ? element.id : null,
                  removed = removeCallback(eventName, target_id);

              // The ready event is not registered
              if (eventName != 'ready' && removed) {
                  postMessage('removeEventListener', eventName, element);
              }
          }
      };

      /**
       * Handles posting a message to the parent window.
       *
       * @param method (String): name of the method to call inside the player. For api calls
       * this is the name of the api method (api_play or api_pause) while for events this method
       * is api_addEventListener.
       * @param params (Object or Array): List of parameters to submit to the method. Can be either
       * a single param or an array list of parameters.
       * @param target (HTMLElement): Target iframe to post the message to.
       */
      function postMessage(method, params, target) {
          if (target.contentWindow == null || !target.contentWindow.postMessage) {
              return false;
          }

          var data = JSON.stringify({
              method: method,
              value: params
          });

          target.contentWindow.postMessage(data, playerOrigin);
      }

      /**
       * Event that fires whenever the window receives a message from its parent
       * via window.postMessage.
       */
      function onMessageReceived(event) {
          var data, method;

          try {
              data = JSON.parse(event.data);
              method = data.event || data.method;
          }
          catch(e)  {
              //fail silently... like a ninja!
          }

          if (method == 'ready' && !isReady) {
              isReady = true;
          }

          // Handles messages from the vimeo player only
          if (!(/^https?:\/\/player.vimeo.com/).test(event.origin)) {
              return false;
          }

          if (playerOrigin === '*') {
              playerOrigin = event.origin;
          }

          var value = data.value,
              eventData = data.data,
              target_id = target_id === '' ? null : data.player_id,

              callback = getCallback(method, target_id),
              params = [];

          if (!callback) {
              return false;
          }

          if (value !== undefined) {
              params.push(value);
          }

          if (eventData) {
              params.push(eventData);
          }

          if (target_id) {
              params.push(target_id);
          }

          return params.length > 0 ? callback.apply(null, params) : callback.call();
      }


      /**
       * Stores submitted callbacks for each iframe being tracked and each
       * event for that iframe.
       *
       * @param eventName (String): Name of the event. Eg. api_onPlay
       * @param callback (Function): Function that should get executed when the
       * event is fired.
       * @param target_id (String) [Optional]: If handling more than one iframe then
       * it stores the different callbacks for different iframes based on the iframe's
       * id.
       */
      function storeCallback(eventName, callback, target_id) {
          if (target_id) {
              if (!eventCallbacks[target_id]) {
                  eventCallbacks[target_id] = {};
              }
              eventCallbacks[target_id][eventName] = callback;
          }
          else {
              eventCallbacks[eventName] = callback;
          }
      }

      /**
       * Retrieves stored callbacks.
       */
      function getCallback(eventName, target_id) {
          if (target_id && eventCallbacks[target_id]) {
              return eventCallbacks[target_id][eventName];
          }
          else if (eventCallbacks[eventName]) {
              return eventCallbacks[eventName];
          }
      }

      function removeCallback(eventName, target_id) {
          if (target_id && eventCallbacks[target_id]) {
              if (!eventCallbacks[target_id][eventName]) {
                  return false;
              }
              eventCallbacks[target_id][eventName] = null;
          }
          else {
              if (!eventCallbacks[eventName]) {
                  return false;
              }
              eventCallbacks[eventName] = null;
          }

          return true;
      }

      function isFunction(obj) {
          return !!(obj && obj.constructor && obj.call && obj.apply);
      }

      function isArray(obj) {
          return toString.call(obj) === '[object Array]';
      }

      // Give the init function the Froogaloop prototype for later instantiation
      Froogaloop.fn.init.prototype = Froogaloop.fn;

      // Listens for the message event.
      // W3C
      if (window.addEventListener) {
          window.addEventListener('message', onMessageReceived, false);
      }
      // IE
      else {
          window.attachEvent('onmessage', onMessageReceived);
      }

      // Expose froogaloop to the global object
      return (window.Froogaloop = window.$f = Froogaloop);
  })();
}));
              

</script>

    
@endpush
