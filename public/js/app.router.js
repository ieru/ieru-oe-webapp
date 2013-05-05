App.Router = Backbone.Router.extend({
	routes: {
		'': 'index',
		'search/:id': 'search',
		'search/:id/:page': 'search_page',
		'resource/:id': 'resource',
	},

	index: function(){
		console.log('index page');
		show_view( 'page-home' );
		vent.trigger( 'cancel:ajaxs' );
	},

	search: function(text){
		console.log('search page: '+text);
		show_view( 'page-app' );
		$('#header form input[type=text]').val(text,1);
		vent.trigger( 'search:submit', text );
	},

	search_page: function(text,page){
		console.log('search pagination: '+text);
		show_view( 'page-app' );
		$('#header form input[type=text]').val(text);
		vent.trigger( 'search:submit', text, page );
	},

	resource: function(id){
		console.log('resource '+id)
		show_view( 'page-resource' );
		vent.trigger( 'cancel:ajaxs' );
	},

})