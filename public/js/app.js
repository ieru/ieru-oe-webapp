(function(){
	window.App = {
		Models: {},
		Collections: {},
		Views: {},
		Router: {},
		Helpers: {},
		Ajaxs: {},
	};
	
	window.vent = _.extend({}, Backbone.Events);
})();

function show_view ( view ){
	$('#page-home').hide();
	$('#page-app').hide();
	$('#page-resource').hide();

	$('#'+view).show();
}

function lang ( text )
{
	var langFile = Box.get('langFile');
	return !!langFile[text] ? langFile[text] : '[['+text+']]';
}