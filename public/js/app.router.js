App.Router = Backbone.Router.extend({
	routes: {
		'': 'index',
		'search/:id': 'search',
	},

	index: function(){
		console.log('index page');
		$('#home-banner').show();
		$('#page-home').show();
		$('#page-app').hide();
	},

	search: function(text){
		console.log('search page: '+text);
		$('#header form input[type=text]').val(text);
		vent.trigger('search:submit');
	},
})