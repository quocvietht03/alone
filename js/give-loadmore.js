jQuery(function($){

    function give_loadmore_callback() {
        $('.give-card__progress-custom .give-goal-progress').each( function() {
    
            if( ! $(this).parent().hasClass('give-card__progress-custom') || ! $(this).find('.give-progress-bar').length || $('body').hasClass('elementor-page') || $(this).find('svg').length ) {
                return;
            }
      
            $(this).find('.give-progress-bar').css('display','none');
      
            var $type = $(this).parent().data('type'),
                $strokeWidth = $(this).parent().data('strokewidth'),
                        $easing = $(this).parent().data('easing'),
                        $duration = $(this).parent().data('duration'),
                        $color = $(this).parent().data('color'),
                        $trailColor = $(this).parent().data('trailcolor'),
                        $trailWidth = $(this).parent().data('trailwidth'),
                        $toColor = $(this).parent().data('tocolor'),
                $svgWidth = $(this).parent().data('width'),
                        $svgHeight = $(this).parent().data('height');
      
                if( 'circle' === $type ) {
                              var bar = new ProgressBar.Circle($(this)[0], {
                                strokeWidth: $strokeWidth,
                                easing: $easing,
                                duration: $duration,
                                color: $color,
                                trailColor: $trailColor,
                                trailWidth: $trailWidth,
                                svgStyle: {width: $svgWidth, height: $svgHeight},
                                from: {color: $color},
                                to: {color: $toColor},
                                step: (state, bar) => {
                                    bar.path.setAttribute('stroke', state.color);
                                }
                              });
                          } else {
                              var bar = new ProgressBar.Line($(this)[0], {
                                strokeWidth: $strokeWidth,
                                easing: $easing,
                                duration: $duration,
                                color: $color,
                                trailColor: $trailColor,
                                trailWidth: $trailWidth,
                                svgStyle: {width: $svgWidth, height: $svgHeight},
                                from: {color: $color},
                                to: {color: $toColor},
                                step: (state, bar) => {
                                    bar.path.setAttribute('stroke', state.color);
                                }
                              });
                          }
      
                          var $barWidth = $(this).find('.give-progress-bar').attr('aria-valuenow') / 100,
      
                                waypoint = new Waypoint({
                                element: $(this),
                                handler: function() {
                                    bar.animate($barWidth);  // Number from 0.0 to 1.0
                                },
                                    offset: '100%',
                                    triggerOnce: true
                                });
      
        });
    }

    if( $('.give-forms-list').hasClass('loadmore-button') ) {
        var current_page = 1;
        $('.give-forms-loadmore .btn-loadmore').click(function(event){
            event.preventDefault();

            if($(this).parent().hasClass('give-posts-loadmore')) {
                var posts_per_page = $(this).parent().data('posts_per_page'),
                    max_page = $(this).parent().data('max_page');

                var posts_arr = {};
                posts_arr["post_type"] = "give_posts";
                posts_arr["posts_per_page"] = posts_per_page;

                give_loadmore_params.posts = JSON.stringify(posts_arr);
                give_loadmore_params.current_page = current_page;
                give_loadmore_params.max_page = max_page;

                current_page++;
                $(this).parent().attr('data-current_page', current_page);
            }
            
            var button = $(this),
                data = {
                    'action': 'give_loadmore',
                    'query': give_loadmore_params.posts, // that's how we get params from wp_localize_script() function
                    'page' : give_loadmore_params.current_page
                };
                    
            $.ajax({ // you can also use $.post here
                url : give_loadmore_params.ajaxurl, // AJAX handler
                data : data,
                type : 'POST',
                beforeSend : function ( xhr ) {
                    button.text('Loading...'); // change the button text, you can also add a preloader image
                },
                success : function( data ){
                    
                    if( data ) { 
                        button.text( 'More Posts' ).parents('.site-main').find('.give-forms-list').append(data); // insert new posts
                        give_loadmore_params.current_page++;
     
                        if ( give_loadmore_params.current_page == give_loadmore_params.max_page ) 
                            button.parent().remove(); // if last page, remove the button
     
                        // you can also fire the "post-load" event here if you use a plugin that requires it
                        // $( document.body ).trigger( 'post-load' );
                        give_loadmore_callback();
    
                    } else {
                        button.parent().remove(); // if no data, remove the button as well
                    }
                }
            });
        });

    }

    if( $('.give-forms-list').hasClass('loadmore-scroll') ) {
        var canBeLoaded = true, // this param allows to initiate the AJAX call only if necessary
	        bottomOffset = $('.give-forms-list').offset().top + $('.give-forms-list').height(); // the distance (in px) from the page bottom when you want to load more posts

        var current_page = 1;

        if($('.give-forms-loadmore').hasClass('give-posts-loadmore')) {
            var posts_per_page = $('.give-forms-loadmore').data('posts_per_page'),
                max_page = $('.give-forms-loadmore').data('max_page');

            var posts_arr = {};
            posts_arr["post_type"] = "give_posts";
            posts_arr["posts_per_page"] = posts_per_page;

            give_loadmore_params.posts = JSON.stringify(posts_arr);
            give_loadmore_params.current_page = current_page;
            give_loadmore_params.max_page = max_page;
        } else {
            return;
        }
        
        $(window).scroll(function(){
            var data = {
                'action': 'give_loadmore',
                'query': give_loadmore_params.posts, // that's how we get params from wp_localize_script() function
                'page' : give_loadmore_params.current_page
            };

            if( $(document).scrollTop() > ( $(document).height() - bottomOffset ) && canBeLoaded == true ){
                current_page++;
                $('.give-posts-loadmore').attr('data-current_page', current_page);
                
                $.ajax({
                    url : give_loadmore_params.ajaxurl,
                    data:data,
                    type:'POST',
                    beforeSend: function( xhr ){
                        // you can also add your own preloader here
                        // you see, the AJAX call is in process, we shouldn't run it again until complete
                        canBeLoaded = false; 
                        
                        $('.give-forms-loadmore').html('Loading...');
                    },
                    success:function(data){
                        if( data ) {
                            $('.give-forms-list').append(data); // insert new posts
                            give_loadmore_params.current_page++;

                            canBeLoaded = true; 

                            if ( give_loadmore_params.current_page == give_loadmore_params.max_page ) 
                            $('.give-forms-loadmore').remove(); // if last page, remove the button

                            // you can also fire the "post-load" event here if you use a plugin that requires it
                            // $( document.body ).trigger( 'post-load' );
                            give_loadmore_callback();
                        }
                    }
                });
            }
        });

    }

});
