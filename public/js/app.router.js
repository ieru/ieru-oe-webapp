App.Router = Backbone.Router.extend({
	routes: {
		'': 'index',
		'search/:id': 'search',
		'search/:id/:page': 'search_page',
		'resource/:id': 'resource',
		'user/register': 'register',
		'navigation': 'navigation',
		'navigation/:id': 'navigation',
	},

	index: function(){
		vent.on('auto:translate', function(){
			$('#home-content .translation-text').each(function(){
				var that = $(this);
            	var text = new App.Models.Translation({text: $(this).html(), from:'en', to:$('#user-selected-language').attr('alt')});
            	$(this).request = text.fetch().done(function(response){
            		that.html(response.data.translation);
            	});
			})
		})

		show_view( 'page-home' );

		vent.trigger( 'cancel:ajaxs' );

        // Add Ratings
        $('#page-home .grnet-rating').each(function(){

        	if ( $(this).html() == '' ){
	            var request = new App.Models.Grnet.Rating({id:$(this).attr('data-resource').replace( /[:\/]/g, '_' ).replace( /\?/g, '@' )})
	            var ratings = new App.Views.Grnet.Rating({model: request});
	            $(this).empty().append(ratings.el);
        	}
        });

        vent.trigger('auto:translate');
	},

	navigation: function(id){
		show_view( 'page-navigational' );
		Box.set('page', !!id?id:1);
		if ( $('#flash').html() == '' ){
	    	swfobject.embedSWF(URL, flashID, width, height, flashVersion, expressInstallURL, flashvars, params, attributes);
		}
    	initInterface($);
	},

	search: function(text){
		Router.navigate('#/search/'+text+'/1');
	},

	search_page: function(text,page){
		show_view( 'page-app' );

		vent.trigger( 'cancel:ajaxs' );
		$('#header form input[type=text]').val(text);
		vent.trigger( 'search:submit', text, page );
	},

	resource: function(id){
		show_view( 'page-resource' );

		var resource = new App.Views.FullResource({ model: new App.Models.FullResource({id:id}) });

		$('#page-resource article').html( resource.el );
	},

	register: function(){
		show_view( 'page-register-user' );

		vent.trigger( 'cancel:ajaxs' );
	},

})