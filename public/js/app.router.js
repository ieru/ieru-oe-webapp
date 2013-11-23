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

		'listing': 					 'listing',
		'listing/:id': 				 'listing',

		'section/:section':          'section',

		'recommended':               'recommended',

		'about':                     'about',

		'feedback':                  'feedback',

		'suggest':                   'suggest',

		'privacy': 					 'privacy',
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

        // Show sections
        var section = new App.Views.SectionHome({ model: sections });

        ganalytics();
	},

	navigation: function(id){
		show_view( 'page-navigational' );
		Box.set('page', !!id?id:1);
		if ( $('#flash').html() == '' ){
	    	swfobject.embedSWF(URL, flashID, width, height, flashVersion, expressInstallURL, flashvars, params, attributes);
		}
    	initInterface($);

    	ganalytics();
	},

	listing: function(){
		show_view( 'page-app' );
	},

	search: function(text){
		//$('#header form').submit();
		Router.navigate('#/search/'+text+'/1');
	},

	search_page: function(text,page,filters){
		show_view( 'page-app' );

		$('#header form input[type=text]').val(text);
		vent.trigger( 'search:submit', text, page, filters );

		ganalytics();
	},

	resource: function(id){
		show_view( 'page-resource' );

		var resource = new App.Views.FullResource({ model: new App.Models.FullResource({id:id}) });

		ganalytics();
	},

	register: function(){
		show_view( 'page-register-user' );

		vent.trigger('cancel:ajaxs');

		ganalytics();
	},

	activate: function(user,hash){
		show_view('page-register-user-confirm');

		var register = new App.Views.Register.Activate({model: new App.Models.Register.Activate({username:user,hash:hash})});
		register.render();
		vent.trigger('cancel:ajaxs');

		ganalytics();
	},

	section: function(section){
		show_view( 'page-section' );
		vent.trigger('cancel:ajaxs');

		// Show sections
        var section = new App.Views.Sections({ model: sections, section: section });

        ganalytics();
	},

	recommended: function(){
		show_view( 'page-recommended' );

		var section = new App.Views.Recommended();

		ganalytics();
	},

	privacy: function(){
		show_view( 'page-privacy' );
		ganalytics();
	},

	about: function(){
		show_view( 'page-about' );
		ganalytics();
	},

	feedback: function(){
		show_view( 'page-feedback' );
		ganalytics();
	},

	suggest: function(){
		show_view( 'page-suggest' );
		ganalytics();
	}
})