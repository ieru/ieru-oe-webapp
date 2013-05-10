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

App.Models.Translation = Backbone.Model.extend({

	urlRoot: '/api/analytics/translate',

	fetch: function(){
		return Backbone.Model.prototype.fetch.call(this, { data: this.toJSON() });
	},
});

App.Models.Grnet = {};

App.Models.Grnet.Rating = Backbone.Model.extend({

	urlRoot: '/api/analytics/resources',

	url: function() {
		return this.urlRoot + '/' + this.id + '/rating';
	},

	fetch: function(){
		return Backbone.Model.prototype.fetch.call(this, { data: this.toJSON() });
	},
});

App.Models.Grnet.AddRating = Backbone.Model.extend({

	urlRoot: '/api/analytics/resources',

	url: function() {
		return this.urlRoot + '/' + this.get('location') + '/rating';
	},


	fetch: function(){
		return Backbone.Model.prototype.fetch.call(this, { data: this.toJSON() });
	},
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
	},
});

App.Models.Autocomplete = Backbone.Model.extend({

})

App.Models.Login = Backbone.Model.extend({

	urlRoot: '/api/organic/login',

	fetch: function(){
		return Backbone.Model.prototype.fetch.call(this, { data: this.toJSON() });
	},
});

App.Models.Logout = Backbone.Model.extend({

	urlRoot: '/api/organic/logout',

	fetch: function(){
		return Backbone.Model.prototype.fetch.call(this, { data: this.toJSON() });
	},
});

App.Models.App = Backbone.Model.extend({
	defaults: {
		interface: 'en',
		searchText: '',
		page: 1,
		perPage: 10,
		totalPages: 1,
		filters: [],
		totalRecords: 0,
	},

	initialize: function(){
		var filters = new App.Collections.Filters([]);
		this.set('filters', filters);
		this.set('interface', $('#lang-selector').find('a').attr('id').split('-')[1] );
	}
})