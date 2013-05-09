App.Router = Backbone.Router.extend({
	routes: {
		'': 'index',
		'search/:id': 'search',
		'search/:id/:page': 'search_page',
		'resource/:id': 'resource',
		'user/register': 'register',
	},

	index: function(){
		console.log('index page');
		show_view( 'page-home' );

		vent.trigger( 'cancel:ajaxs' );
	},

	search: function(text){
		console.log('search: '+text);
		show_view( 'page-app' );

		$('#header form input[type=text]').val(text);
		vent.trigger( 'search:submit', text, 1 );
	},

	search_page: function(text,page){
		console.log('search/page: '+text);
		show_view( 'page-app' );

		$('#header form input[type=text]').val(text);
		vent.trigger( 'search:submit', text, page );
	},

	resource: function(id){
		console.log('resource '+id)
		show_view( 'page-resource' );

		vent.trigger( 'cancel:ajaxs' );
	},

	register: function(){
		console.log('register user');
		show_view( 'page-register-user' );

		vent.trigger( 'cancel:ajaxs' );
	},

})