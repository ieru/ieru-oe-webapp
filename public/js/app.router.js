App.Router = Backbone.Router.extend({
	routes: {
		'': 'index',
		'search/:id': 'search',
		'search/:id/:page': 'search_page',
		'resource/:id': 'resource',
		'user/register': 'register',
	},

	index: function(){
		show_view( 'page-home' );

		vent.trigger( 'cancel:ajaxs' );
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

		vent.trigger( 'cancel:ajaxs' );
	},

	register: function(){
		show_view( 'page-register-user' );

		vent.trigger( 'cancel:ajaxs' );
	},

})