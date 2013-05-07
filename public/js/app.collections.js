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
	},
})

App.Collections.Filters.prototype.add = function(filter) {
    //Using isDupe routine from @Bill Eisenhauer's answer
    var isDupe = this.any(function(_filter) { 
        return _filter.get('valor') === filter.get('valor');
    });
    if (!!filter && isDupe) {
        //Up to you either return false or throw an exception or silently ignore
        return false;
    }
    Backbone.Collection.prototype.add.call(this, filter);
}