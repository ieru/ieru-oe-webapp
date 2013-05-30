App.Views.LoginForm = Backbone.View.extend({
    el: '#user-login',

    events: {
        'submit #login-form': 'submit',
        'click #user-logout': 'logout',
    },

    logout: function(e){
        e.preventDefault();

        var model = new App.Models.Logout({usertoken:_.cookie('usertoken')});
        model.fetch().then(function(response){
            _.cookie('usertoken',null);
            location.reload();
        });
    },

    submit: function(e){
        e.preventDefault();

        var model = new App.Models.Login({
            username: $('#login-form-username').val(),
            password: $('#login-form-password').val(),
        });
        model.fetch().then(function(response){
            _.cookie('usertoken',response.data.usertoken);
            location.reload();
        });
    },
})

App.Views.Grnet = {};

App.Views.Grnet.Rating = Backbone.View.extend({
    tagName: 'span',

    template: _.template( $('#grnet-rating').html() ),

    events: {
        'click .grnet-rating-star': 'addRating',
    },

    initialize: function(){
        // Cancel any ongoing ajax requests
        vent.on( 'cancel:ajaxs', function(){
            if ( !!this.ajax ){
                this.ajax.abort();
                delete this.ajax;
            }
        }, this );

        this.render();
    },

    render: function(){
        var that = this;
        this.ajax = this.model.fetch();
        this.ajax.then(function(response){
            that.$el.html( that.template( response.data ) );
            if ( !_.cookie('usertoken'))
                that.$el.find('a.grnet-rating-tooltip').tooltip({'title':lang('log_in_or_register_for_rating')});

            $('.grnet-rating-info').popover();
        });
        return this;
    },

    addRating: function(e){
        e.preventDefault();
        if ( _.cookie('usertoken')){
            var rating = $(e.currentTarget).attr('class').split(' ')[1].split('-')[2];
            var addRating = new App.Models.Grnet.AddRating({location:this.model.get('id'), rating:parseInt(rating)+1, usertoken:_.cookie('usertoken')});
            var that = this;
            addRating.save().then(function(response){
                if ( response.success )
                    that.$el.html( that.template( response.data ) );
            });
        }
    }
})

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
        }, this);
    },

    changePerPage: function(e){
        e.preventDefault();
        Box.set('perPage',$(e.currentTarget).find('a').html());
        $('#results-per-page').find('> a').html(Box.get('perPage')+'<span class="glyphicon glyphicon-chevron-down"></span>');
        if ( Box.get('searchText') != '' )
            $('#header form').submit();
        else
            doSearch.submit();
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
            'click .search-result-keywords a': 'addKeywordFilter',
            'click .organic-dropdown ul a': 'changeLanguage',
        },

        changeLanguage: function(e){
            e.preventDefault();
            vent.trigger('cancel:ajaxs');

            var texts = this.model.get('texts');
            var to = $(e.currentTarget).attr('class').split('-')[2];
            var from = 'en';
            var that = this.$el;

            that.find('header h2 a').html('<img src="/images/ajax-loader.gif" /> Translating...');
            that.find('> p > span').html('<img src="/images/ajax-loader.gif" /> Translating...');
            this.model.set('metadata_language', to);

            // If the texts are not in the desired language, request translation
            if ( texts[to].title == '' ){
                // Get the language to translate from (english by default)
                if ( texts[from] == undefined || texts[from].title == '' )
                    for ( from in texts )
                        if ( texts[from].title )
                            break;


                var title = new App.Models.Translation({text: texts[from].title.substr(0,200), from:from, to:to});
                var description = new App.Models.Translation({text: texts[from].description.substr(0,200), from:from, to:to});

                this.ajaxTitle = title.fetch();
                this.ajaxTitle.done(function(response){
                    texts[to].title = response.data.translation;
                    that.find('header h2 a').html(response.data.translation);
                });
                this.ajaxDescription = description.fetch();
                this.ajaxDescription.done(function(response){
                    texts[to].description = response.data.translation;
                    that.find('> p > span').html(response.data.translation);
                }); 
            }

            this.render();
        },

        addKeywordFilter: function(e){
            var filterModel = new App.Models.Filter({
                clave:  'keyword', 
                valor:  $(e.currentTarget).attr('href').split('/')[3], 
                indice: Box.get('filters').length
            });
            filtersBarView.collection.add(filterModel);
            if ( Box.get('searchText') != '' )
                $('#header form').submit();
        },

        initialize: function(){
            // Cancel any ongoing ajax requests
            vent.on( 'cancel:ajaxs', function(){
                if ( !!this.ajaxTitle ){
                    this.ajaxTitle.abort();
                    delete this.ajaxTitle;
                    this.ajaxDescription.abort();
                    delete this.ajaxDescription;
                }
            }, this );

            this.model.set('location_rep', this.model.get('location').replace( /[:\/]/g, '_' ).replace( /\?/g, '@' ));

            // Get language to show of those available in the resource
            if ( !!this.model.get('texts')[Box.get('interface')] && this.model.get('texts')[Box.get('interface')].title != '' )
                this.model.set('metadata_language', Box.get('interface'));
            else if ( !!this.model.get('texts').en && this.model.get('texts').en.title != '' )
                this.model.set('metadata_language', 'en');
            else
                for ( var lang in this.model.get('texts') )
                    if ( this.model.get('texts')[lang].title ){
                        this.model.set('metadata_language', lang);
                        break;
                    }

            this.render();
        },

        render: function(){
            // Render view
            this.$el.html( this.template( this.model.toJSON() ) );

            // Add Ratings
            var grnet = this.$el.find('.grnet-rating');
            if ( !this.model.get('ratings') ){
                grnet.append('<img src="/images/ajax-loader.gif" />');
                var request = new App.Models.Grnet.Rating({id:this.model.get('location_rep')})
                var ratings = new App.Views.Grnet.Rating({model: request});
                this.model.set('ratings',ratings.el);
                grnet.find('img').remove();
            }
            grnet.append(this.model.get('ratings'));
            
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
                    'click input': 'addFacetFilter',
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

                addFacetFilter: function(){
                    var found   = false;
                    var filters = Box.get('filters');
                    var filter  = this.$el.find('a').attr('title');
                    var parent  = this.$el.parents('.accordion-group').find('.accordion-heading').find('a').attr('title');

                    // Try to add the filter
                    for ( var i in filtersBarView.collection.models )
                        if ( filtersBarView.collection.models[i].get('valor') == filter )
                            found = true;

                    // If it couldnt add the filter, remove it from the collection
                    if ( found == true ){
                        // Remove filter from list
                        for ( var i in filtersBarView.collection.models )
                            if ( filtersBarView.collection.models[i].get('valor') == filter )
                                filtersBarView.collection.remove(filtersBarView.collection.models[i]);

                        // Remove filter from filter bar
                        $('#close-button-'+filter.trim().replace(/ /g, '-')).trigger('click');
                        vent.trigger('cancel:ajaxs');
                    }else{
                        var filterModel = new App.Models.Filter({clave:parent, valor:filter, indice:filters.length});
                        filtersBarView.collection.add(filterModel);
                    }
                    Box.set('filters', filtersBarView.collection);
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
        vent.trigger( 'cancel:ajaxs' );
        if ( this.collection.length == 1 )
            $(this.el).find('span').empty();

        var filterView = new App.Views.FilterActive({ model: filter });
        $(this.$el.find('span')[0]).append(filterView.render().el);
        $(this.$el.find('span')[0]).append(' ');
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

        destroy: function(e){
            vent.trigger( 'cancel:ajaxs' );
            this.model.destroy();
            var filterName = $(e.currentTarget).parent().find('span').html().trim().replace(/ /g, '-');
            $('#checkbox-'+filterName).attr('checked',false);
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
            this.$el.html( '<button id="close-button-'+this.model.get('valor').trim().replace(/ /g, '-')+'" class="close" style="float: none;">&times;</button> <span>'+this.model.get('valor')+'</span>' );
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
        this.model.set('route', Backbone.history.fragment.split('/')[1]);

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
            vent.trigger('cancel:ajaxs');
            Box.set('searchText', text);
            Box.set('page',page);
            console.log('Reroute');
            Router.navigate('#/search/'+Box.get('searchText')+'/'+Box.get('page'));
            $('#header form').submit();
            console.log('---');
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

    submitNavigational: function(){
        $.ajax({
            url: 'http://oe.dynalias.net/indexa.php?option=com_navigational&tmpl=component&task=search&format=raw&offset='+((parseInt(Box.get('page'))-1)*Box.get('perPage'))+'&limit=' + Box.get('perPage') + '&language=null&elevel=null&rtype=null&order=alphabetical&flash=yes&predicate=null&inclusive=yes',
            async: false,
            jsonpCallback: 'jsonCallback',
            contentType: "application/json",
            dataType: 'jsonp',
            success: function(data, textStatus, jqXHR) 
            {
                alert('aye');
                if ( !!data ){

                    // Visualization thingies
                    $('#page-app').show();
                    $('#app-content-results').empty().html('<img src="/images/loading_edu.gif" /> '+lang('loading_resource'));
                    $('#app-content-info').hide();

                    // If searchText is different, reset filters
                    Box.set('searchText', '');

                    // Create search request
                    var search = new App.Models.Search();
                    Box.set('totalRecords', data.totalSize);
                    Box.set('totalPages', (parseInt(data.totalSize)/Box.get('perPage')));
                    search.set('lang', Box.get('interface'));
                    search.set('offset', (parseInt(Box.get('page'))-1)*Box.get('perPage'));
                    search.set('limit', Box.get('perPage'));
                    search.set('total', data.totalSize);
                    search.set('identifiers', data.identifiers);
                    search.set('type', 'POST');

                    this.ajax = search.fetch();

                    // Generate response
                    this.ajax.then(function(response){
                        // On error
                        if ( !response.success ){
                            vent.trigger('search:error',response.message);
                            return;
                        }

                        // Assign facets and results
                        var facets = new App.Collections.Facets({});
                        var resources = new App.Collections.Resources(search.get('records'));

                        // Render the facets in the View
                        var facetsView = new App.Views.Facets({ collection: facets });
                        $('#app-content-filters').html('<h4 style="margin: 0 0 10px 0; ">Apply filters:</h4>');
                        $('#app-content-filters').append(facetsView.render().el);

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
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('asd');
            }
        });        
    },

    submit: function(e){
        // Abort any current ajax requests
        e.preventDefault();

        // Visualization thingies
        window.scrollTo(0,0);
        show_view( 'page-app' );
        $('#app-content-results').empty().html('<img src="/images/loading_edu.gif" /> '+lang('loading_resource'));
        $('#app-content-info').hide();

        // If searchText is different, reset filters
        var formBoxText = $(e.currentTarget).find('input[type=text]').val();
        if ( formBoxText != Box.get('searchText') ) {
            Router.navigate('#/search/'+formBoxText+'/'+Box.get('page'));
            $('#app-content-filters').empty();
            $('#content-filters-bar').find('span').html(lang('none'));
            Box.set('page', 1);
            Box.set('filters', new App.Collections.Filters());
            Box.set('searchText', formBoxText);
        }

        // Create search request
        var search = new App.Models.Search();
        search.set('text', Box.get('searchText'));
        search.set('lang', Box.get('interface'));
        search.set('offset', (parseInt(Box.get('page'))-1)*Box.get('perPage'));
        search.set('limit', Box.get('perPage'));
        search.set('total', 0);
        search.set('filter', Box.get('filters').toJSON());

        // Create hash with request params for not requesting twice same data
        var hash = hashcode( JSON.stringify(search.toJSON()) );

        // If it is a fresh request
        if ( !App.Searches[hash] ){
            this.ajax = search.fetch();

            // Generate response
            this.ajax.then(function(response){
                // On error
                if ( !response.success ){
                    vent.trigger('search:error',response.message);
                    return;
                }
                App.Searches[hash] = response;

                // Assign total pages and other data
                Box.set('totalPages',response.data.pages);
                Box.set('totalRecords', response.data.total);

                // Assign facets and results
                var facets = new App.Collections.Facets(search.get('data').facets);
                var resources = new App.Collections.Resources(search.get('data').resources);

                // Render the facets in the View
                var facetsView = new App.Views.Facets({ collection: facets });
                $('#app-content-filters').html('<h4 style="margin: 0 0 10px 0; ">Apply filters:</h4>');
                $('#app-content-filters').append(facetsView.render().el);

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

        // Duplicated request
        }else{
            var response = App.Searches[hash];

            // Assign total pages and other data
            Box.set('totalPages',response.data.pages);
            Box.set('totalRecords', response.data.total);

            // Assign facets and results
            var facets = new App.Collections.Facets(response.data.facets);
            var resources = new App.Collections.Resources(response.data.resources);

            // Render the facets in the View
            var facetsView = new App.Views.Facets({ collection: facets });
            $('#app-content-filters').html('<h4 style="margin: 0 0 10px 0; ">Apply filters:</h4>');
            $('#app-content-filters').append(facetsView.render().el);

            // Render the results
            var resultsView = new App.Views.SearchResults({ collection: resources });
            $('#app-content-results').html(resultsView.render().el);

            // Render the pagination
            var paginationView = new App.Views.Pagination({ model: Box });
            $('.app-content-pagination').html(paginationView.render().el);

            // Remove memory of request object
            delete App.Ajaxs.search;
            vent.trigger('search:resolved');
        }
    }
});

App.Views.FullResource = Backbone.View.extend({
    el: '#resource-viewport',

    className: 'clearfix',

    template: _.template( $('#resource-content-full').html() ),

        events: {
            'click .organic-dropdown ul a': 'changeLanguage',
        },

    initialize: function(){
        // Cancel any ongoing ajax requests
        vent.on( 'cancel:ajaxs', function(){
            if ( !!this.ajax ){
                this.ajax.abort();
                delete this.ajax;
            }
            if ( !!this.ajaxTitle ){
                this.ajaxTitle.abort();
                delete this.ajaxTitle;
                this.ajaxDescription.abort();
                delete this.ajaxDescription;
            }
        }, this );

        // Fetch the resource data
        var that = this;
        this.ajax = this.model.fetch();
        this.ajax.then(function(response){
            // Parse fetch data
            that.model.set('location_rep', that.model.get('location').replace( /[:\/]/g, '_' ).replace( /\?/g, '@' ));

            // Get language to show of those available in the resource
            if ( !!that.model.get('texts')[Box.get('interface')] && that.model.get('texts')[Box.get('interface')].title != '' )
                that.model.set('metadata_language', Box.get('interface'));
            else if ( !!that.model.get('texts').en && that.model.get('texts').en.title != '' )
                that.model.set('metadata_language', 'en');
            else
                for ( var lang in that.model.get('texts') )
                    if ( that.model.get('texts')[lang].title ){
                        that.model.set('metadata_language', lang);
                        break;
                    }
            that.render();
        });
    },

    changeLanguage: function(e){
        e.preventDefault();
        vent.trigger('cancel:ajaxs');

        var texts = this.model.get('texts');
        var to = $(e.currentTarget).attr('class').split('-')[2];
        var from = 'en';
        var that = this.$el;

        that.find('header h2 a').html('<img src="/images/ajax-loader.gif" /> Translating...');
        that.find('> p > span').html('<img src="/images/ajax-loader.gif" /> Translating...');
        this.model.set('metadata_language', to);

        // If the texts are not in the desired language, request translation
        if ( texts[to].title == '' ){
            // Get the language to translate from (english by default)
            if ( texts[from] == undefined || texts[from].title == '' )
                for ( from in texts )
                    if ( texts[from].title )
                        break;


            var title = new App.Models.Translation({text: texts[from].title.substr(0,200), from:from, to:to});
            var description = new App.Models.Translation({text: texts[from].description.substr(0,200), from:from, to:to});

            this.ajaxTitle = title.fetch();
            this.ajaxTitle.done(function(response){
                texts[to].title = response.data.translation;
                that.find('header h2 a').html(response.data.translation);
            });
            this.ajaxDescription = description.fetch();
            this.ajaxDescription.done(function(response){
                texts[to].description = response.data.translation;
                that.find('> p > span').html(response.data.translation);
            }); 
        }

        this.render();
    },

    render: function(){
        this.$el.html( this.template( this.model.toJSON() ) );
        
        // Add Ratings
        var grnet = this.$el.find('.grnet-rating');
        if ( !this.model.get('ratings') ){
            grnet.append('<img src="/images/ajax-loader.gif" />');
            var request = new App.Models.Grnet.Rating({id:this.model.get('location_rep')})
            var ratings = new App.Views.Grnet.Rating({model: request});
            this.model.set('ratings',ratings.el);
            grnet.find('img').remove();
        }
        grnet.append(this.model.get('ratings'));

        return this;
    }
});