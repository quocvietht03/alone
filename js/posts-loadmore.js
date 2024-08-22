jQuery(function($){
	if( $('.posts-list').hasClass('loadmore-button') ) {
        $('.posts-loadmore .btn-loadmore').click(function(event){
			event.preventDefault();
	
			var button = $(this),
				data = {
				'action': 'posts_loadmore',
				'query': posts_loadmore_params.posts, // that's how we get params from wp_localize_script() function
				'page' : posts_loadmore_params.current_page
			};
	 
			$.ajax({ // you can also use $.post here
				url : posts_loadmore_params.ajaxurl, // AJAX handler
				data : data,
				type : 'POST',
				beforeSend : function ( xhr ) {
					button.text('Loading...'); // change the button text, you can also add a preloader image
				},
				success : function( data ){
					
					if( data ) { 
						button.text( 'More Posts' ).parents('.site-main').find('.posts-list').append(data); // insert new posts
						posts_loadmore_params.current_page++;
	 
						if ( posts_loadmore_params.current_page == posts_loadmore_params.max_page ) 
							button.remove(); // if last page, remove the button
	 
						// you can also fire the "post-load" event here if you use a plugin that requires it
						// $( document.body ).trigger( 'post-load' );
					} else {
						button.remove(); // if no data, remove the button as well
					}
				}
			});
		});

    }

	if( $('.posts-list').hasClass('loadmore-scroll') ) {
        var canBeLoaded = true, // this param allows to initiate the AJAX call only if necessary
	        bottomOffset = $('.posts-list').offset().top + $('.posts-list').height(); // the distance (in px) from the page bottom when you want to load more posts

        $(window).scroll(function(){
            var data = {
                'action': 'posts_loadmore',
                'query': posts_loadmore_params.posts, // that's how we get params from wp_localize_script() function
                'page' : posts_loadmore_params.current_page
            };

            if( $(document).scrollTop() > ( $(document).height() - bottomOffset ) && canBeLoaded == true ){
                $.ajax({
                    url : posts_loadmore_params.ajaxurl,
                    data:data,
                    type:'POST',
                    beforeSend: function( xhr ){
                        // you can also add your own preloader here
                        // you see, the AJAX call is in process, we shouldn't run it again until complete
                        canBeLoaded = false; 
                        
                        $('.posts-loadmore').html('Loading...');
                    },
                    success:function(data){
                        if( data ) {
                            $('.posts-list').append(data); // insert new posts
                            posts_loadmore_params.current_page++;

                            canBeLoaded = true; 

                            if ( posts_loadmore_params.current_page == posts_loadmore_params.max_page ) 
                            $('.posts-loadmore').remove(); // if last page, remove the button

                            // you can also fire the "post-load" event here if you use a plugin that requires it
                            // $( document.body ).trigger( 'post-load' );
                        }
                    }
                });
            }
        });

    }
	
});
