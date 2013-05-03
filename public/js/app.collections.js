App.Collections.Resources = Backbone.Collection.extend({
	model: App.Models.Resource,
})

App.Collections.Facets = Backbone.Collection.extend({
	model: App.Models.Facet,

	initialize: function(facets){
	}
})

App.Collections.Filters = Backbone.Collection.extend({
	model: App.Models.Filter,

	initialize: function(filters){
	}
})