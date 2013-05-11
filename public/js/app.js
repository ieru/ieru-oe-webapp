(function(){
	window.App = {
		Models: {},
		Collections: {},
		Views: {},
		Router: {},
		Helpers: {},
		Ajaxs: {},
		Searches: {}
	};
	
	window.vent = _.extend({}, Backbone.Events);
})();

function show_view ( view ){
	window.scrollTo(0,0);

	$('#page-home').hide();
	$('#page-app').hide();
	$('#page-resource').hide();
	$('#page-register-user').hide();

	$('#'+view).show();
}

function lang ( text )
{
	var langFile = Box.get('langFile');
	return !!langFile[text] ? langFile[text] : '[['+text+']]';
}