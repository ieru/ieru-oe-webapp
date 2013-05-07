App.Models.Resource = Backbone.Model.extend({
	default: {
		metadata_language: 'en',
	}
});

App.Models.Facet = Backbone.Model.extend({
});

App.Models.Filter = Backbone.Model.extend({
});

App.Models.Pagination = Backbone.Model.extend({
});

App.Models.Search = Backbone.Model.extend({

	urlRoot: '/api/organic/search',

	defaults: {
		text: '',
		lang: '',
		offset: '',
		limit: '',
		total: ''
	},

	initialize: function(){
	},

	fetch: function(){
		return Backbone.Model.prototype.fetch.call(this, { data: this.toJSON() });
	}
});

App.Models.Autocomplete = Backbone.Model.extend({

})

App.Models.App = Backbone.Model.extend({
	defaults: {
		interface: 'en',
		searchText: '',
		page: 1,
		perPage: 10,
		totalPages: 1,
		filters: [],
	},

	initialize: function(){
		this.set('interface', $('#lang-selector').find('a').attr('id').split('-')[1] );
	}
})