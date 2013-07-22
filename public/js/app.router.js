App.Router = Backbone.Router.extend({
	routes: {
		'': 'index',

		'search/:id': 				 'search',
		'search/:id/:page':    		 'search_page',
		'search/:id/:page/:filters': 'search_page',

		'resource/:id': 			 'resource',

		'user/register': 			 'register',
		'user/register/:user/:hash': 'activate',

		'navigation': 				 'navigation',
		'navigation/:id': 			 'navigation',
	},

	index: function(){
		show_view( 'page-home' );

		vent.trigger('cancel:ajaxs');

        // Add Ratings
        $('#page-home .grnet-rating').each(function(){
        	if ( $(this).html() == '' ){
	            var request = new App.Models.Grnet.Rating({id:$(this).attr('data-resource')})
	            var ratings = new App.Views.Grnet.Rating({model: request});
	            $(this).empty().append(ratings.el);
        	}
        });

        // Check for need of autotranslation
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
		$('#header form').submit();
	},

	search_page: function(text,page,filters){
		show_view( 'page-app' );

		$('#header form input[type=text]').val(text);
		vent.trigger( 'search:submit', text, page, filters );
	},

	resource: function(id){
		show_view( 'page-resource' );

		var resource = new App.Views.FullResource({ model: new App.Models.FullResource({id:id}) });
	},

	register: function(){
		show_view( 'page-register-user' );

		vent.trigger('cancel:ajaxs');
	},

	activate: function(user,hash){
		show_view('page-register-user-confirm');

		var register = new App.Views.Register.Activate({model: new App.Models.Register.Activate({username:user,hash:hash})});
		register.render();
		vent.trigger('cancel:ajaxs');
	}
})