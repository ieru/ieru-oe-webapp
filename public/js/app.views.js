App.Views.SearchResults = Backbone.View.extend({
	tagName: 'section',

	render: function(){
		this.collection.each(function(resource){
			this.$el.append( new App.Views.Resource({ model: resource }).el );
		}, this);
		return this;
	}

});

	App.Views.Resource = Backbone.View.extend({
		tagName: 'article',

		template: _.template( $('#resource-content').html() ),

		initialize: function(){
			this.render();
		},

		render: function(){
			// Get language to show of those in the resource
			var model = this.model.toJSON();
			if ( !!model.texts[Box.get('interface')] && model.texts[Box.get('interface')].title != '' )
				model.metadata_language = Box.get('interface');
			else if ( !!model.texts.en && model.texts.en.title != '' )
				model.metadata_language = 'en';
			else
				for ( var lang in model.texts )
					if ( lang.title != '' )
						model.metadata_language = lang;

			// Render view
			this.$el.html( this.template( model ) );
			return this;
		},
	});

App.Views.Facets = Backbone.View.extend({
	tagName: 'ul',

	render: function(){
		this.collection.each(function(facet){
			this.$el.append( new App.Views.Facet({ model: facet }).el );
		}, this);
		return this;
	}

});

	App.Views.Facet = Backbone.View.extend({
		tagName: 'li',

		template: _.template( $('#facets-content').html() ),

		initialize: function(){
			this.render();
		},

		render: function(){
			// Render the facet view
			this.$el.html( this.template( this.model.toJSON() ) );

			// Render the filters of this facet and append to this
			var filters = new App.Collections.Filters(this.model.get('results'));
			var filtersView = new App.Views.Filters({ collection: filters });
			this.$el.append( filtersView.render().el );

			return this;
		},
	});

		App.Views.Filters = Backbone.View.extend({
			tagName: 'ul',

			render: function(){
				this.collection.each(function(filter){
					this.$el.append( new App.Views.Filter({ model: filter }).el );
				}, this);
				return this;
			}
		})

			App.Views.Filter = Backbone.View.extend({
				tagName: 'li',

				template: _.template( $('#facets-filter').html() ),

				initialize: function(){
					this.render();
				},

				render: function(){
					this.$el.html( this.template( this.model.toJSON() ) );
					return this;
				}
			})

App.Views.DoSearch = Backbone.View.extend({
	el: '#search-form',

	events: {
		'submit': 'submit',
	},

	initialize: function(){
		vent.on( 'search:submit', function(){
			$('#header form input[type=submit]').trigger('click');
		}, this );
	},

	submit: function(e){
		e.preventDefault();

		// Remove elements not needed
		$('#home-banner').hide();
		$('#page-home').hide();
		$('#page-app').show();

		// Get the search text
		var searchText = $(e.currentTarget).find('input[type=text]').val();

		// Do the search
		var search = new App.Models.Search({ text: searchText, lang: Box.get('interface'), offset: 0, limit: 10, total: 0 });
		search.fetch().then(function(response){
			// Assign facets and results
			var facets = new App.Collections.Facets(search.get('data').facets);
			var resources = new App.Collections.Resources(search.get('data').resources);

			// Render the facets in the View
			var facetsView = new App.Views.Facets({ collection: facets });
			$('#app-content-filters').empty().append(facetsView.render().el);

			// Render the results
			var resultsView = new App.Views.SearchResults({ collection: resources });
			$('#app-content-results').empty().append(resultsView.render().el);
		});
	}
});