$('#form-search').bind('typeahead:closed', function(e){
    $('.tt-query').val($(this).next().html());
    Box.set('searchText', $(this).next().html());
});


/*
 * Sections content
 */
App.Views.SectionHome = Backbone.View.extend({
    initialize: function(model){
        this.model.set( model );
        var that = this;
        sections.fetch().done(function(response){
            var carousel = new App.Views.SectionCarousel({ model: new App.Models.SectionsCarousel({carousel:that.model.get('home').carousel})});
            carousel.$el.parent().append(new App.Views.SectionCategories({ model: new App.Models.SectionsCarousel({sections:that.model.get('home').sections})}));
        });
    }
})

App.Views.Sections = Backbone.View.extend({
    initialize: function(options){
        this.model.set( options.model );
        var that = this;
        sections.fetch().done(function(response){
            var carousel = new App.Views.SectionCarousel({ model: new App.Models.SectionsCarousel({carousel:that.model.get(options.section).carousel})});
            carousel.$el.parent().append(new App.Views.SectionCategories({ model: new App.Models.SectionsCarousel({sections:that.model.get(options.section).sections})}));
            carousel.$el.parent().append(new App.Views.SectionThemes({ model: new App.Models.SectionsCarousel({sections:that.model.get(options.section).themes})}));
        });
    }
})

    App.Views.SectionCarousel = Backbone.View.extend({
        el: '.carousel',

        template: _.template( $('#section-carousel').html() ),

        initialize: function(model){
            this.model.set( model );
            this.render();
        },

        render: function(){
            this.$el.html( this.template( this.model.toJSON() ) );
            return this;
        }
    })

    App.Views.SectionCategories = Backbone.View.extend({
        el: '.sections-categories',

        template: _.template( $('#sections-categories').html() ),

        initialize: function(model){
            this.model.set( model );
            this.render();
        },

        render: function(){
            this.model.set('default_lang',Box.get('interface'));
            this.$el.html( this.template( this.model.toJSON() ) );
            return this;
        }
    })

    App.Views.SectionThemes = Backbone.View.extend({
        el: '.sections-themes',

        template: _.template( $('#sections-themes').html() ),

        initialize: function(model){
            this.model.set( model );
            this.render();
        },

        render: function(){
            this.model.set('default_lang',Box.get('interface'));
            this.$el.html( this.template( this.model.toJSON() ) );
            return this;
        }
    })


/*
 * Autotranslation button
 */
App.Views.Autotranslate = Backbone.View.extend({
    el: '#button-autotranslate',

    events: {
        'click input':'switch',
    },

    initialize: function(){
        home_translation = false;
        // Autotranslate home page contents
        vent.on('auto:translate', function(){
            if ( _.cookie('autotrans') && !home_translation && $('#page-home').css('display') == 'block' ){
                $('#home-content .translation-text').each(function(){
                    var that = $(this);
                    var text = $(this).html();
                    that.html('<img src="/images/ajax-loader.gif" /> '+lang('translating')+'...');
                    var request = new App.Models.Translation.Language({text: text, from:'en', to:$('#user-selected-language').attr('alt')});
                    request.fetch().done(function(response){
                        that.html(response.data.translation);
                        home_translation = true;
                    });
                })
            }
        }),

        vent.on( 'search:resolved', function(){
            if ( _.cookie('autotrans') ){
                vent.trigger('auto:translate');
            }
        }, this);

        vent.on( 'resource:loaded', function(){
            if ( _.cookie('autotrans') ){
                vent.trigger('auto:translate');
            }
        }, this);

        if ( _.cookie('autotrans') ){
            this.$el.find('input').attr('checked','checked');
        }
    },

    switch: function(){
        if ( !!_.cookie('autotrans') ){
            vent.trigger('cancel:ajaxs');
            vent.trigger('auto:rollback');
            _.cookie('autotrans',null);
        }else{
            _.cookie('autotrans', true);
            vent.trigger('auto:translate');
        }
    }
})

App.Views.LoginForm = Backbone.View.extend({
    el: '#user-zone',

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
        var that = this;
        model.fetch().then(function(response){
            if ( response.success ){
                _.cookie('usertoken',response.data.usertoken);
                location.reload();
            }else{
                that.$el.find('.control-group').addClass('has-error');
                that.$el.find('form').tooltip({title:lang('wrong_username_or_password'), placement:'right', trigger:'manual'});
                that.$el.find('form').tooltip('toggle');
            }
        });
    },
})

App.Views.RegisterNewUser = Backbone.View.extend({
    el: '#register-new-user',

    events: {
        'submit': 'submit',
    },

    submit: function(e){
        e.preventDefault();
        $('.close').trigger('click');
        var model = new App.Models.Register.New($('#register-new-user').serializeObject());
        var that = this;
        model.fetch().then(function(response){
            var success = response.success ? 'success' : 'danger';
            if ( response.success ){
                $('#register-new-user .row').prepend('<div class="alert alert-'+success+'"><button type="button" class="close" data-dismiss="alert">&times;</button><p>'+response.message+'</p><p>Check your email for an activation link to finish the registration process.</p></div>');
                that.$el.find('.control-group').removeClass('has-error');
            }else{
                that.$el.find('input').tooltip('destroy');
                that.$el.find('.control-group').addClass('has-error');
                $('#register-new-user .row').prepend('<div class="alert alert-'+success+'"><button type="button" class="close" data-dismiss="alert">&times;</button><p>'+response.message+'</p></div>');
            }
        });
    },
})

App.Views.Grnet = {};

App.Views.Grnet.Rating = Backbone.View.extend({
    tagName: 'span',

    template: _.template( $('#grnet-rating').html() ),

    templateStars: _.template( $('#grnet-rating-stars').html() ),

    events: {
        'click .grnet-rating-star': 'addRating',
        'click .rating-history a': 'getHistory',
    },

    getHistory: function(e){
        //e.preventDefault();
        var that = this;
        var request = new App.Models.Grnet.RatingHistory({id:this.model.get('id')});
        var box = this.$el.find('.rating-history > ul');
        if ( box.html() == '' ){
            box.append('<img src="/images/ajax-loader.gif" />');
            this.ajax = request.fetch();
            this.ajax.then(function(response){
                box.empty();
                if ( response.data.length ){
                    for ( var i in response.data ){
                        box.append( that.templateStars( response.data[i] ) );
                    }
                }else{
                    box.append( lang('no_ratings_yet') );
                }
            })
        }
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
            // No ratings retrieved for the resource: show null ratings
            if ( !response.data ){
                response.data = {};
                response.data.votes = 0;
                response.data.rating = 0;
            }
            that.$el.html( that.template( response.data ) );
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
});

App.Views.Translation = {};

App.Views.Translation.Rating = Backbone.View.extend({
    tagName: 'span',

    template: _.template( $('#translation-rating').html() ),

    templateStars: _.template( $('#translation-rating-stars').html() ),

    events: {
        'click .translation-rating-star': 'addRating',
        'click .rating-history a': 'getHistory',
    },

    getHistory: function(e){
        //e.preventDefault();
        var that = this;
        var request = new App.Models.Translation.RatingHistory({id:this.model.get('id'), hash:this.model.get('hash')});
        var box = this.$el.find('.rating-history > ul');
        if ( box.html() == '' ){
            box.append('<img src="/images/ajax-loader.gif" />');
            this.ajax = request.fetch();
            this.ajax.then(function(response){
                box.empty();
                if ( response.data.length ){
                    for ( var i in response.data ){
                        box.append( that.templateStars( response.data[i] ) );
                    }
                }else{
                    box.append( lang('no_ratings_yet') );
                }
            })
        }
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
            // No ratings retrieved for the resource: show null ratings
            if ( !response.data ){
                response.data = {};
                response.data.votes = 0;
                response.data.rating = 0;
            }
            that.$el.html( that.template( response.data ) );
        });
        return this;
    },

    addRating: function(e){
        // Translation Rating Model Save
        e.preventDefault();
        if ( _.cookie('usertoken')){
            this.model.set('rating', parseInt($(e.currentTarget).attr('class').split(' ')[1].split('-')[2])+1);
            var that = this;
            this.model.save().then(function(response){
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
            $('#content-filters-bar').show();
            $(this.el).find('#jquery-results-first').html(first);
            $(this.el).find('#jquery-results-last').html(last);
            $(this.el).find('#jquery-results-total').html(total);
        }, this);
    },

    changePerPage: function(e){
        e.preventDefault();
        Box.set('perPage',$(e.currentTarget).find('a').html());
        Box.set('page', 1);
        var stext = Box.get('searchText') == '' ? '' : '/'+Box.get('searchText');
        Router.navigate('#/'+get_section()+stext+'/1'+get_filters_formatted());
        $('#results-per-page').find('> a').html(Box.get('perPage')+'<span class="glyphicon glyphicon-chevron-down"></span>');
        if ( Box.get('searchText') != '' )
            $('#header form').submit();
        else
            doSearch.submitNavigational();
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

        if ( !_.cookie('usertoken') )
            $('body .ugc-widget').tooltip({'title':lang('log_in_or_register_for_improving_translation')});

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
            if ( !!e ) {
                e.preventDefault();
                vent.trigger('cancel:ajaxs');
            }

            var texts = this.model.get('texts');
            var to = ( !!e ) ? $(e.currentTarget).attr('class').split('-')[2] : $('#user-selected-language').attr('alt');
            var from = 'en';
            var that = this.$el;
            var box = this;

            that.find('header h2 a').html('<img src="/images/ajax-loader.gif" /> '+lang('translating')+'...');
            this.model.set('metadata_language', to);

            // Change to the desired language if there is a translation set for it
            if ( texts[to].title != '' ){
                this.render();
            // If the texts are not in the desired language, request translation
            }else{
                // Get the language to translate from (english by default)
                if ( texts[from] == undefined || texts[from].title == '' )
                    for ( from in texts )
                        if ( texts[from].title )
                            break;

                // Translate title
                var title = new App.Models.Translation.Language({text: texts[from].title.substr(0,200), from:from, to:to});
                this.ajaxTitle = title.fetch({timeout:10000});
                this.ajaxTitle.done(function(response){
                    texts[to].title = response.data.translation;
                    that.find('header h2 a').html(response.data.translation);
                    // Translate description
                    if ( !!texts[from].description ){
                        that.find('> p > span').html('<img src="/images/ajax-loader.gif" /> '+lang('translating')+'...');
                        var description = new App.Models.Translation.Language({text: texts[from].description.substr(0,200), from:from, to:to});
                        this.ajaxDescription = description.fetch({timeout:10000});
                        this.ajaxDescription.done(function(response){
                            texts[to].description = response.data.translation;
                            that.find('> p > span').html(response.data.translation);

                            // translate keywords
                            if ( !!texts[from].keywords ){
                                that.find('.search-result-keywords').html('<strong>'+lang('keywords')+':</strong> <img src="/images/ajax-loader.gif" /> '+lang('translating')+'...');
                                var keywords = new App.Models.Translation.Language({text: texts[from].keywords.join(','), from:from, to:to});
                                this.ajaxKeywords = keywords.fetch({timeout:10000});
                                this.ajaxKeywords.done(function(response){
                                    texts[to].keywords = response.data.translation.split(',');
                                    box.render();
                                }); 
                            }
                        }); 
                    // Translate keywords
                    }else if ( !!texts[from].keywords ){
                        var keywords = new App.Models.Translation.Language({text: texts[from].keywords.join(','), from:from, to:to});
                        this.ajaxKeywords = keywords.fetch({timeout:10000});
                        this.ajaxKeywords.done(function(response){
                            texts[to].keywords = response.data.translation.split(',');
                            box.render();
                        }); 
                    }
                });
            }
        },

        addKeywordFilter: function(e){
            e.preventDefault();

            if ( Box.get('searchText') != '' ){
                var filterModel = new App.Models.Filter({
                    clave:  'keyword', 
                    valor:  $(e.currentTarget).attr('href').split('/')[3], 
                    indice: Box.get('filters').length
                });
                filtersBarView.collection.add(filterModel);
                Box.set('page',1);
                changedFilters = true;
                Box.set('filters', filtersBarView.collection);
                Router.navigate('#/search/'+Box.get('searchText')+'/'+Box.get('page')+get_filters_formatted());
            }
        },

        initialize: function(){
            // Cancel any ongoing ajax requests
            vent.on( 'cancel:ajaxs', function(){
                if ( !!this.ajaxTitle ){
                    this.ajaxTitle.abort();
                    delete this.ajaxTitle;
                }
                if ( !!this.ajaxDescription ){
                    this.ajaxDescription.abort();
                    delete this.ajaxDescription;
                }
            }, this );

            vent.on( 'auto:translate', function(){
                this.changeLanguage();
            }, this );

            vent.on('auto:rollback', function(){
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
            }, this);

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
            this.$el.html( this.template( this.model.toJSON() ) );
            
            // Add Ratings
            var grnet = this.$el.find('.grnet-rating');
            
            grnet.append('<img src="/images/ajax-loader.gif" />');
            var request = new App.Models.Grnet.Rating({id:this.model.get('id')})
            var ratings = new App.Views.Grnet.Rating({model: request});
            this.model.set('ratingsModel',ratings);
            grnet.find('img').remove();
            grnet.append(this.model.get('ratingsModel').el);

            return this;
        }
    });

App.Views.Facets = Backbone.View.extend({
    className: 'accordion',

    id: 'app-content-filters-accordion',

    render: function(){
        filters_box = Box.get('filters').toJSON();
        this.collection.each(function(facet){
            this.$el.append( new App.Views.Facet({ model: facet }).el );
            //alert(JSON.stringify(facet));
        }, this);

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
            var found = false;
            this.$el.append('<div id="collapse-'+this.model.get('name')+'" class="accordion-body collapse"><div class="accordion-inner"></div></div>')
                .find('.accordion-inner').append( filtersView.render().el );

            //[{"clave":"educationalContext","valor":"higher education","indice":0}]

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
                    this.model.set('active', false);
                    if ( filters_box.length > 0 ){
                        for ( var f in filters_box ){
                            if ( filters_box[f].valor == this.model.get('filter') )
                                this.model.set('active', true);
                        }
                    }
                    this.$el.html( this.template( this.model.toJSON() ) );

                    return this;
                },

                addFacetFilter: function(){
                    var found   = false;
                    var filters = Box.get('filters');
                    var filter  = this.$el.find('a').attr('title');
                    var parent  = this.$el.parents('.accordion-group').find('.accordion-heading').find('a').attr('title');

                    Box.set('page',1);
                    
                    // Try to add the filter
                    for ( var i in filtersBarView.collection.models )
                        if ( filtersBarView.collection.models[i].get('valor') == filter )
                            found = true;

                    // If it couldnt add the filter, remove it from the collection
                    if ( found == true ){
                        $('#close-button-'+filter.replace(/ /g, '-').replace('/', '--')).trigger('click');
                    }else{
                        var filterModel = new App.Models.Filter({clave:parent, valor:filter, indice:filters.length});
                        filtersBarView.collection.add(filterModel);
                        changedFilters = true;
                        Router.navigate('#/search/'+Box.get('searchText')+'/'+Box.get('page')+get_filters_formatted());
                    }
                    Box.set('filters', filtersBarView.collection);
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
            var filterName = $(e.currentTarget).parent().find('span').html().trim().replace(/ /g, '-').replace('/', '--');
            $('#checkbox-'+filterName).attr('checked',false);
            var parent = $('#content-filters-bar').find('span');
            if ( $.trim(parent.html()) == '' )
                parent.html(lang('none'));
            Router.navigate('#/search/'+Box.get('searchText')+'/'+Box.get('page')+get_filters_formatted());
            changedFilters = true;
        },

        remove: function(){
            this.$el.remove();
        },

        render: function(){
            if ( this.model.get('clave') == 'keyword' )
                this.$el.addClass('label-info').removeClass('label-success');
            this.$el.html( '<button id="close-button-'+this.model.get('valor').trim().replace(/ /g, '-').replace('/', '--')+'" class="close" style="float: none;">&times;</button> <span>'+this.model.get('valor').replace(/@/g, '-').replace('--', '/').replace(/\|/g, ' or ')+'</span>' );
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
        this.model.set('route', get_section());

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
        vent.on( 'search:submit', function(text,page,filters){
            Box.set('searchText', text);
            Box.set('page',page);

            // Set the filters for the request
            if ( !!filters && !changedFilters ){
                var params = filters.split(':');
                for ( var i in params ){
                    var filterinfo = params[i].split('=');

                    var found   = false;
                    var filters = Box.get('filters');
                    var filter  = filterinfo[1];
                    var parent  = filterinfo[0];

                    // Try to add the filter
                    for ( var i in filtersBarView.collection.models )
                        if ( filtersBarView.collection.models[i].get('valor') == filter )
                            found = true;

                    Box.set('filters', filtersBarView.collection);

                    // If it couldnt add the filter, remove it from the collection
                    if ( found == true ){
                        // Remove filter from list
                        for ( var i in filtersBarView.collection.models )
                            if ( filtersBarView.collection.models[i].get('valor') == filter )
                                filtersBarView.collection.remove(filtersBarView.collection.models[i]);

                        // Remove filter from filter bar
                        $('#close-button-'+filter.trim().replace(/ /g, '-').replace('/', '--')).trigger('click');
                        vent.trigger('cancel:ajaxs');
                    }else{
                        var filterModel = new App.Models.Filter({clave:parent, valor:filter, indice:filters.length});
                        filtersBarView.collection.add(filterModel);
                    }
                }
                changedFilters = true;
            }

            $('#header form').submit();
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
        //$('#search-form input[type=text]').keyup(this.autocomplete);
        $('#form-search').typeahead({
            name: 'terms',
            local: [],
            remote: {url:api_server+'/api/organic/search/typeahead?text=%QUERY'}
        });
    },

    autocomplete: function(e){
    },

    submitNavigational: function(){
        this.ajax = $.ajax({
            url: 'http://oe.dynalias.net/indexa.php?option=com_navigational&tmpl=component&task=search&format=raw&offset='+((parseInt(Box.get('page'))-1)*Box.get('perPage'))+'&limit=' + Box.get('perPage') + '&language=null&elevel=null&rtype=null&order=alphabetical&flash=yes&predicate=null&inclusive=yes',
            jsonpCallback: 'jsonCallback',
            contentType: "application/json",
            dataType: 'jsonp',
            success: function(data) 
            {
                if ( !!data ){

                    // Visualization thingies
                    $('#page-app').show();
                    $('#content-filters-bar').css({visibility:'hidden'});
                    $('#app-content-filters').css({visibility:'hidden'});
                    $('#app-content-results').empty().html('<img src="/images/loading_edu.gif" /> '+lang('loading_resources'));
                    $('#app-content-info').hide();

                    // If searchText is different, reset filters
                    Box.set('searchText', '');

                    // Create search request
                    var search = new App.Models.Search();
                    Box.set('totalRecords', data.totalSize);
                    Box.set('totalPages', Math.ceil(parseInt(data.totalSize)/Box.get('perPage')));
                    search.set('lang', Box.get('interface'));
                    search.set('offset', (parseInt(Box.get('page'))-1)*Box.get('perPage'));
                    search.set('limit', Box.get('perPage'));
                    search.set('total', data.totalSize);
                    search.set('identifiers', data.identifiers);
                    search.set('type', 'POST');

                    this.ajax = search.fetch();

                    // Generate response
                    this.ajax.then(function(response){
                        if ( get_section() != 'navigation' )
                            return;

                        // On error
                        if ( !response.success ){
                            vent.trigger('search:error',response.message);
                            return;
                        }

                        // Assign facets and results
                        var resources = new App.Collections.Resources(search.get('records'));

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
            }
        });        
    },

    submit: function(e){
        // Abort any current ajax requests
        e.preventDefault();
        vent.trigger('cancel:ajaxs');

        // Get text search
        var formBoxText = $('#form-search').val();

        // When showing the navigational search results, we hide the following boxes,
        // so now we have to show them up
        $('#content-filters-bar').css({visibility:'visible'});
        $('#app-content-filters').css({visibility:'visible'});

        // If search through submit button, reset
        if ( !e.isTrigger ) {
            if ( formBoxText == Box.get('searchText') ){
                Router.navigate('#/search/'+formBoxText+'/1'+get_filters_formatted());
            }else{
                Box.set('searchText', formBoxText);
            }
            if ( Backbone.history.fragment.split('/')[1] != 'search' )
                Router.navigate('#/search/'+formBoxText+'/1'+get_filters_formatted());
            $('#content-filters-bar').find('span').html(lang('none'));
            Box.set('page', 1);
            Box.set('filters', new App.Collections.Filters());
            return;
        }

        // Check empty search
        if ( formBoxText.trim() == '' ){
            var box = $('#search-form input');
            var text = '<div class="alert"><button type="button" class="close" data-dismiss="alert">&times;</button>'+lang('empty_search_not_allowed')+'</div>'
            box.after(text);
            return;
        }

        // Check not allowed characters
        if ( formBoxText.match(/[<>]/g) ){
            var box = $('#form-search');
            var text = '<div class="alert"><button type="button" class="close" data-dismiss="alert">&times;</button>'+lang('character_not_allowed')+'</div>'
            box.after(text);
            return;
        }
        $('#app-content-filters').empty();

        // Visualization thingies
        window.scrollTo(0,0);
        show_view( 'page-app' );
        $('#app-content-results').empty().html('<img src="/images/loading_edu.gif" /> '+lang('loading_resources'));
        $('#app-content-info').hide();
        $('#content-filters-bar').hide();
        $('#app-content-filters').show();;

        // Create search request
        var search = new App.Models.Search();
        search.set('text', Box.get('searchText'));
        search.set('lang', Box.get('interface'));
        search.set('offset', (parseInt(Box.get('page'))-1)*Box.get('perPage'));
        search.set('limit', Box.get('perPage'));
        search.set('total', 0);
        search.set('filter', Box.get('filters').toJSON());

        this.ajax = search.fetch();

        // Generate response
        this.ajax.then(function(response){
            
            if ( get_section() != 'search' )
                return;

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
            $('#app-content-filters').html('<h4 style="margin: 0 0 10px 0; ">'+lang('apply_filters')+':</h4>');
            $('#app-content-filters').append(facetsView.render().el);
            $('#collapse-click-educationalContext').trigger('click');

            // Render the results
            var resultsView = new App.Views.SearchResults({ collection: resources });
            $('#app-content-results').html(resultsView.render().el);

            // Render the pagination
            var paginationView = new App.Views.Pagination({ model: Box });
            $('.app-content-pagination').html(paginationView.render().el);

            // Remove memory of request object
            //delete App.Ajaxs.search;
            vent.trigger('search:resolved');
        });
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
            if ( !!this.ajaxTitle ){
                this.ajaxTitle.abort();
                delete this.ajaxTitle;
            }
            if ( !!this.ajaxDescription ){
                this.ajaxDescription.abort();
                delete this.ajaxDescription;
            }
            if ( !!this.ajaxKeywords ){
                this.ajaxKeywords.abort();
                delete this.ajaxKeywords;
            }
        }, this );

        vent.on( 'auto:translate', function(){
            this.changeLanguage();
        }, this );

        $('#resource-viewport').html('<img src="/images/loading_edu.gif" /> '+lang('loading_resource'));

        // Fetch the resource data
        var that = this;
        this.ajax = this.model.fetch();
        this.ajax.then(function(response){
            that.model = new App.Models.FullResource(response.data);

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

            // Set default hash string
            that.model.set('hash',Sha1.hash(that.model.get('texts')[that.model.get('metadata_language')].title+that.model.get('texts')[that.model.get('metadata_language')].description));

            // Render
            that.render();

            // Add recommendations
            $('#ugc-dialog-form').remove();
            var script = document.createElement('script');
            script.id = 'resource-related-resources';
            script.type = 'text/javascript';
            script.src = '/js/_other/recommendations.js';
            $('#page-resource > .container > .row').append(script);

            vent.trigger('resource:loaded');
        });
    },

    changeLanguage: function(e){
        if ( !!e ) {
            e.preventDefault();
            vent.trigger('cancel:ajaxs');
        }

        var texts = this.model.get('texts');
        var to = ( !!e ) ? $(e.currentTarget).attr('class').split('-')[2] : $('#user-selected-language').attr('alt');
        var from = 'en';
        var that = this.$el;
        var thot = this;
        var box = this;

        that.find('header h2 a').html('<img src="/images/ajax-loader.gif" /> '+lang('translating')+'...');
        this.model.set('metadata_language', to);

        // Change to the desired language if there is a translation set for it
        if ( texts[to].title != '' ){
            this.model.set('hash',Sha1.hash(this.model.get('texts')[to].title+this.model.get('texts')[to].description));
            this.render();
        // If the texts are not in the desired language, request translation
        }else{
            // Get the language to translate from (english by default)
            if ( texts[from] == undefined || texts[from].title == '' )
                for ( from in texts )
                    if ( texts[from].title )
                        break;

            // Translate title
            var title = new App.Models.Translation.Language({text: texts[from].title, from:from, to:to});
            this.ajaxTitle = title.fetch({timeout:10000});
            this.ajaxTitle.done(function(response){
                texts[to].title = response.data.translation;
                that.find('header h2 a').html(response.data.translation);
                // Translate description
                if ( !!texts[from].description ){
                    that.find('> p > span').html('<img src="/images/ajax-loader.gif" /> '+lang('translating')+'...');
                    var description = new App.Models.Translation.Language({text: texts[from].description, from:from, to:to});
                    this.ajaxDescription = description.fetch({timeout:10000});
                    this.ajaxDescription.done(function(response){
                        texts[to].description = response.data.translation;
                        thot.model.set('hash',Sha1.hash(texts[to].title+texts[to].description));
                        that.find('> p > span').html(response.data.translation);

                        // translate keywords
                        if ( !!texts[from].keywords ){
                            that.find('.search-result-keywords').html('<strong>'+lang('keywords')+':</strong> <img src="/images/ajax-loader.gif" /> '+lang('translating')+'...');
                            var keywords = new App.Models.Translation.Language({text: texts[from].keywords.join(','), from:from, to:to});
                            this.ajaxKeywords = keywords.fetch({timeout:10000});
                            this.ajaxKeywords.done(function(response){
                                texts[to].keywords = response.data.translation.split(',');
                                box.render();
                            }); 
                        }
                    }); 
                // Translate keywords
                }else if ( !!texts[from].keywords ){
                    var keywords = new App.Models.Translation.Language({text: texts[from].keywords.join(','), from:from, to:to});
                    this.ajaxKeywords = keywords.fetch({timeout:10000});
                    this.ajaxKeywords.done(function(response){
                        texts[to].keywords = response.data.translation.split(',');
                        box.render();
                    }); 
                }
            });
        }
    },

    render: function(){
        this.$el.html( this.template( this.model.toJSON() ) );
        
        // Add resource ratings
        var grnet = this.$el.find('.grnet-rating');
        grnet.append('<img src="/images/ajax-loader.gif" />');
        var request = new App.Models.Grnet.Rating({id:this.model.get('id')})
        var ratings = new App.Views.Grnet.Rating({model: request});
        this.model.set('ratingsModel',ratings);
        grnet.find('img').remove();
        grnet.append(this.model.get('ratingsModel').el);

        // Add translation ratings
        var translation = this.$el.find('.translation-rating');
        var request = new App.Models.Translation.Rating({id:this.model.get('id'), rating:5, usertoken:_.cookie('usertoken'), hash: this.model.get('hash')});
        var ratings = new App.Views.Translation.Rating({model: request});
        this.model.set('tratingsModel',ratings);
        translation.find('img').remove();
        translation.append(this.model.get('tratingsModel').el);

        return this;
    }
});

App.Views.Register = {};
App.Views.Register.Activate = Backbone.View.extend({
    render: function (){
        $('#page-register-user-confirm .row').empty();
        this.model.fetch().done(function(response){
            var success = response.success ? 'success' : 'danger';
            $('#page-register-user-confirm .row').html('<div class="alert alert-'+success+'">'+response.message+'</div>');
        });
    }
});
