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

App.Models.Resources = Backbone.Model.extend({
	urlRoot: api_server+'/api/organic/resources',
});

App.Models.FullResource = Backbone.Model.extend({
	urlRoot: api_server+'/api/organic/resources/',

	default: {
		lang: 'en',
	}
});

App.Models.Grnet = {};

App.Models.Grnet.Rating = Backbone.Model.extend({

	urlRoot: api_server+'/api/analytics/resources',

	url: function() {
		return this.urlRoot + '/' + this.id + '/rating';
	},
	fetch: function(){
		return Backbone.Model.prototype.fetch.call(this, {});
	},
});

App.Models.Grnet.AddRating = Backbone.Model.extend({

	urlRoot: api_server+'/api/analytics/resources',

	url: function() {
		return this.urlRoot + '/' + this.get('location') + '/rating';
	},


	fetch: function(){
		return Backbone.Model.prototype.fetch.call(this, { data: this.toJSON() });
	},
});

App.Models.Grnet.RatingHistory = Backbone.Model.extend({

	urlRoot: api_server+'/api/analytics/resources',

	url: function() {
		return this.urlRoot + '/' + this.id + '/ratings';
	},

	fetch: function(){
		return Backbone.Model.prototype.fetch.call(this, {});
	},
});

App.Models.Search = Backbone.Model.extend({

	urlRoot: api_server+'/api/organic/search',

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
		return Backbone.Model.prototype.fetch.call(this, { data: this.toJSON(), type:this.get('type') });
	},
});

App.Models.Autocomplete = Backbone.Model.extend({

})

App.Models.Login = Backbone.Model.extend({

	urlRoot: api_server+'/api/organic/login',

	fetch: function(){
		return Backbone.Model.prototype.fetch.call(this, { data: this.toJSON() });
	},
});

App.Models.Typeahead = Backbone.Model.extend({

	urlRoot: api_server+'/api/organic/search/typeahead',

	fetch: function(){
		return Backbone.Model.prototype.fetch.call(this, { data: this.toJSON() });
	},
});

App.Models.Logout = Backbone.Model.extend({

	urlRoot: api_server+'/api/organic/logout',

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

App.Models.Register = {};

App.Models.Register.New = Backbone.Model.extend({

	urlRoot: api_server+'/api/organic/register',

	fetch: function(){
		return Backbone.Model.prototype.fetch.call(this, { data: this.toJSON(), type: 'POST' });
	},
});

App.Models.Register.AcceptChange = Backbone.Model.extend({
	urlRoot: api_server+'/api/organic/users/password/change/',

	url: function() {
		return this.urlRoot + this.get('hash') ;
	},

	fetch: function(){
		return Backbone.Model.prototype.fetch.call(this);
	},
})

App.Models.Register.Activate = Backbone.Model.extend({
	urlRoot: api_server+'/api/organic/users',

	url: function() {
		return this.urlRoot + '/' + this.get('username') + '/activate';
	},

	fetch: function(){
		return Backbone.Model.prototype.fetch.call(this, { data: this.toJSON() });
	},
})

App.Models.Register.Retrieve = Backbone.Model.extend({
	urlRoot: api_server+'/api/organic/users/retrieve',

	url: function() {
		return this.urlRoot;
	},

	fetch: function(){
		return Backbone.Model.prototype.fetch.call(this, { data: this.toJSON(), type: 'POST' });
	},
})

App.Models.Sections = Backbone.Model.extend({
	//urlRoot: '/js/sections.json?time='+new Date().getTime(),
	urlRoot: '/js/sections.json?version=0.9',
})

App.Models.SectionsCarousel = Backbone.Model.extend({
})

/**
 * Rating of automatic translations of the resources
 */
App.Models.Translation = {};

App.Models.Translation.Rating = Backbone.Model.extend({

	urlRoot: api_server+'/api/analytics/resources',

	url: function() {
		return this.urlRoot + '/' + this.get('id') + '/translation/' + this.get('hash') + '/rating';
	},

	fetch: function(){
		return Backbone.Model.prototype.fetch.call(this, {});
	},

	save: function(){
		var data = {};
		data.usertoken = this.get('usertoken');
		data.rating = this.get('rating');
		data.from = this.get('from');
		data.to = this.get('to');
		data.service = this.get('service');
		return Backbone.Model.prototype.fetch.call(this, { data: data, type: 'POST' });
	}
})

App.Models.Translation.RatingHistory = Backbone.Model.extend({

	urlRoot: api_server+'/api/analytics/resources',

	url: function() {
		return this.urlRoot + '/' + this.get('id') + '/translation/' + this.get('hash') + '/ratings';
	},

	fetch: function(){
		return Backbone.Model.prototype.fetch.call(this, {});
	},
});

App.Models.Translation.Language = Backbone.Model.extend({

	urlRoot: api_server+'/api/analytics/translate',

	fetch: function(){
		this.set('cache','true');
		return Backbone.Model.prototype.fetch.call(this, { data: this.toJSON() });
	},
});

App.Models.Feedback = Backbone.Model.extend({

	urlRoot: api_server+'/api/organic/feedback',

	save: function(){
		return Backbone.Model.prototype.fetch.call(this, { data: this.toJSON(), type: 'POST' });
	},
});

App.Models.ChangeSettings = Backbone.Model.extend({

	urlRoot: api_server+'/api/organic/users/settings',

	save: function(){
		return Backbone.Model.prototype.fetch.call(this, { data: this.toJSON(), type: 'POST' });
	},
});