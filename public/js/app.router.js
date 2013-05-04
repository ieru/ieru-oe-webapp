App.Router = Backbone.Router.extend({
	routes: {
		'': 'index',
		'search/:id': 'search',
	},

	index: function(){
		console.log('index page');
		show_view( 'page-home' );
		vent.trigger('cancel:ajaxs');
	},

	search: function(text){
		console.log('search page: '+text);
		show_view( 'page-app' );
		$('#header form input[type=text]').val(text);
		vent.trigger('search:submit', text);
	},
})