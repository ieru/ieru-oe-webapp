App.Views.SearchInfoBar = Backbone.View.extend({
    el: '#app-content-info',

    events: {
        'click #results-per-page li': 'changePerPage',
    },

    initialize: function(){
        // Submit search event
        vent.on( 'search:resolved', function(){
            var total = Box.get('totalRecords');
            var first = (parseInt(Box.get('page'))-1)*Box.get('perPage') + 1;
            var last = (parseInt(Box.get('page')))*Box.get('perPage');

            if ( last > total )
                last = total;

            $('#app-content-info').show();
            $(this.el).find('#jquery-results-first').html(first);
            $(this.el).find('#jquery-results-last').html(last);
            $(this.el).find('#jquery-results-total').html(total);
        }, this );
    },

    changePerPage: function(e){
        e.preventDefault();
        Box.set('perPage',$(e.currentTarget).find('a').html());
        $('#results-per-page').find('> a').html(Box.get('perPage')+'<span class="glyphicon glyphicon-chevron-down"></span>');
        $('#header form').submit();
    },
})

App.Views.SearchResults = Backbone.View.extend({
    tagName: 'section',

    render: function(){
        //this.$el.append( '<div class="app-content-pagination"></div>' );
        this.collection.each(function(resource){
            this.$el.append( new App.Views.Resource({ model: resource }).el );
        }, this);

        // Add pagination box
        this.$el.append( '<div class="app-content-pagination"></div>' );

        return this;
    }
});

    App.Views.Resource = Backbone.View.extend({
        tagName: 'article',

        className: 'clearfix',

        template: _.template( $('#resource-content').html() ),

        events: {
            'click .search-result-keywords a': 'addFilter',
        },

        addFilter: function(e){
            var filterModel = new App.Models.Filter({clave:'keyword', valor:$(e.currentTarget).attr('href').split('/')[3], indice:Box.get('filters').length});
            filtersBarView.collection.add(filterModel);
            $('#header form').submit();
        },

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
                    if ( model.texts[lang].title ){
                        model.metadata_language = lang;
                        break;
                    }

            // Render view
            this.$el.html( this.template( model ) );
            return this;
        },
    });

App.Views.Facets = Backbone.View.extend({

    className: 'accordion',

    idName: 'facets-listing-ajax',

    render: function(){
        this.collection.each(function(facet){
            this.$el.append( new App.Views.Facet({ model: facet }).el );
        }, this);

        // Loop the filters and set as selected those in the filters
        var filters = Box.get('filters');
        return this;
    }

});

    App.Views.Facet = Backbone.View.extend({
        tagName: 'div',

        className: 'accordion-group',

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
            this.$el.append('<div id="collapse-'+this.model.get('name')+'" class="accordion-body collapse in"><div class="accordion-inner"></div></div>')
                .find('.accordion-inner').append( filtersView.render().el );

            return this;
        },
    });

        App.Views.Filters = Backbone.View.extend({
            tagName: 'ul',

            className: 'list-unstyled',

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

                events: {
                    'click input': 'addFilter',
                },

                initialize: function(){
                    this.render();
                },

                render: function(){
                    // Take the last part in technical format filters
                    var translation = this.model.get('translation').split('/');
                    this.model.set('translation', translation[translation.length-1]);

                    // Check if the filter has been already set, remove if so
                    var filters = Box.get('filters');
                    this.model.set('active',false);
                    this.$el.html( this.template( this.model.toJSON() ) );
                    return this;
                },

                addFilter: function(){
                    var found   = false;
                    var filters = Box.get('filters');
                    var filter  = this.$el.find('a').attr('title');
                    var parent  = this.$el.parents('.accordion-group').find('.accordion-heading').find('a').attr('title');

                    var filterModel = new App.Models.Filter({clave:parent, valor:filter, indice:filters.length});
                    filtersBarView.collection.add(filterModel);
                    Box.set('page',1);

                    $('#header form').submit();
                }
            })

App.Views.FiltersBar = Backbone.View.extend({
    el: '#content-filters-bar',

    initialize: function(){
        this.collection.on('add', this.addOne, this);
    },

    render: function(){
        this.collection.each(this.addOne, this);
        return this;
    },

    addOne: function(filter) {
        if ( this.collection.length == 1 )
            $(this.el).find('span').empty();

        var filterView = new App.Views.FilterActive({ model: filter });
        this.$el.find('span').append(filterView.render().el);
        this.$el.find('span').append(' ');
    },
})

    App.Views.FilterActive = Backbone.View.extend({
        tagName: 'a',

        className: 'label label-success',

        attributes: {
            'href': '#',
            'onclick': 'return false',
        },

        events: {
            'click .close': 'destroy',
        },

        initialize: function(){
            this.model.on('destroy', this.remove, this);
        },

        destroy: function(){
            this.model.destroy();
            $('#checkbox-higher-education').attr('checked',false);
            var parent = $('#content-filters-bar').find('span');
            if ( $.trim(parent.html()) == '' )
                parent.html(lang('none'));
            $('#header form').submit();
        },

        remove: function(){
            this.$el.remove();
        },

        render: function(){
            if ( this.model.get('clave') == 'keyword' )
                this.$el.addClass('label-info').removeClass('label-success');
            this.$el.html( '<button class="close" style="float: none;">&times;</button> '+this.model.get('valor') );
            return this;
        },
    })

App.Views.Pagination = Backbone.View.extend({

    template: _.template( $('#search-pagination').html() ),

    render: function(){
        // Set vars and startPage
        this.model.set('page',parseInt(this.model.get('page')));
        this.model.set('totalPages',parseInt(this.model.get('totalPages')));
        this.model.set('numPagLinks',2);
        var startPage = this.model.get('page') - this.model.get('numPagLinks');
        if (startPage < 1)
            startPage = 1;
        this.model.set('startPage',startPage);

        this.$el.html( this.template( this.model.toJSON() ) );
        return this;
    }

});

App.Views.DoSearch = Backbone.View.extend({
    el: '#search-form',

    events: {
        'submit': 'submit'
    },

    initialize: function(){

        // Submit search event
        vent.on( 'search:submit', function(text,page){
            // Remove elements not needed
            if ( !Box.get('searchText') || Box.get('searchText') != text || Box.get('page') != page ){
                $('#app-content-filters').empty();
                $('#app-content-results').empty();
                    Box.set('page',page);
                $('#header form').submit();
            }
        }, this );

        // Cancel any ongoing ajax requests
        vent.on( 'cancel:ajaxs', function(){
            if ( !!this.ajax ){
                this.ajax.abort();
                delete this.ajax;
            }
        }, this );

        // Search request was not successful
        vent.on( 'search:error', function(message){
            $('#app-content-results').html('<div class="alert alert-danger">'+message+'</div>');
        }, this );

        // Add event for key pressing in the search form
        $('#search-form input[type=text]').keyup(this.autocomplete);
    },

    autocomplete: function(e){
        console.log(e.type, e.keyCode);
    },

    submit: function(e){
        // Abort any current ajax requests
        e.preventDefault();
        vent.trigger('cancel:ajaxs');

        // Get the search text
        Box.set('searchText', $(e.currentTarget).find('input[type=text]').val());
        $('#app-content-results').empty().html('<img src="/images/loading_edu.gif" /> '+lang('loading_resource'));
        $('#app-content-info').hide();

        // Change URL
        Router.navigate('#/search/'+Box.get('searchText')+'/'+Box.get('page'));

        // Create search request
        var search = new App.Models.Search();
        search.set('text', Box.get('searchText'));
        search.set('lang', Box.get('interface'));
        search.set('offset', (parseInt(Box.get('page'))-1)*Box.get('perPage'));
        search.set('limit', Box.get('perPage'));
        search.set('total', 0);
        search.set('filter', Box.get('filters').toJSON());

        // Register ajax request for being able to abort the request
        this.ajax = search.fetch();

        // Generate response
        this.ajax.then(function(response){
            // On error
            if ( !response.success ){
                vent.trigger('search:error',response.message);
                return;
            }

            // Assign total pages and other data
            Box.set('totalPages',response.data.pages);
            Box.set('totalRecords', response.data.total);

            // Assign facets and results
            var facets = new App.Collections.Facets(search.get('data').facets);
            var resources = new App.Collections.Resources(search.get('data').resources);

            // Render the facets in the View
            var facetsView = new App.Views.Facets({ collection: facets });
            $('#app-content-filters').html(facetsView.render().el);

            // Render the results
            var resultsView = new App.Views.SearchResults({ collection: resources });
            $('#app-content-results').html(resultsView.render().el);

            // Render the pagination
            var paginationView = new App.Views.Pagination({ model: Box });
            $('.app-content-pagination').html(paginationView.render().el);

            // Remove memory of request object
            delete App.Ajaxs.search;
            vent.trigger('search:resolved');
        });

    }
});