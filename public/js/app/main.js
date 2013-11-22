require.config({
  paths: {
    'jquery': '/js/jquery',
    'underscore': '/js/underscore',
    'backbone': '/js/backbone',
  }
});

require(['app'], function(AppView) {
    //$.ajaxSetup({ cache: false });

    // Wait for search request
    var Box = new App.Models.App();
    var sections = new App.Models.Sections();
    var filtersBarView = new App.Views.FiltersBar({ collection: Box.get('filters') });
    var searchBarInfo = new App.Views.SearchInfoBar();
    Box.set('langFile', lang_file);
    var doSearch = new App.Views.DoSearch();
    var doLogin = new App.Views.LoginForm();
    var doRegister = new App.Views.RegisterNewUser();
    var autoTranslate = new App.Views.Autotranslate();
    var changedFilters = false;

    // Router + History
    Router = new App.Router;
    Backbone.history.start();

    // Redirection
    $('#lang-selector .dropdown-menu li a').click(function(){
        window.location = $(this).attr('href')+'#'+Backbone.history.getFragment();
        return false;
    })
});