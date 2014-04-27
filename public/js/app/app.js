// Filename: app.js
define([
  'jquery',
  'underscore',
  'backbone',
  'router', // Request router.js
],
function($, _, Backbone, Router)
{
  alert('x');
  var api_server = 'http://ak.oeanalytic-dev.agroknow.gr';

  (function(){
    window.App = {
      Models: {},
      Collections: {},
      Views: {},
      Router: {},
      Helpers: {},
      Ajaxs: {},
      Searches: {}
    };

    window.vent = _.extend({}, Backbone.Events);
  })();

  function show_view ( view ){
    window.scrollTo(0,0);

    $('#page-home').hide();
    $('#page-section').hide();
    $('#page-app').hide();
    $('#page-resource').hide();
    $('#page-register-user').hide();
    $('#page-navigational').hide();
    $('#page-register-user-confirm').hide();

    $('#'+view).show();
  }

  function lang ( text )
  {
    var langFile = Box.get('langFile');
    return !!langFile[text] ? langFile[text] : '[['+text+']]';
  }

  function hashcode ( s )
  {
    return s.split("").reduce(function(a,b){
      a=((a<<5)-a)+b.charCodeAt(0);
      return a&a
    }, 0);
  }

  function get_section ()
  {
      var i = Backbone.history.fragment.split('/');
      return (Backbone.history.fragment.charAt(0)=='/')?i[1]:i[0];
  }

  function get_filters_formatted (){
      var filters_format = '';
      filtersBarView.collection.each(function(filter){
          if ( filters_format != '' )
              filters_format = filters_format + ':';
          filters_format = filters_format + filter.get('clave')+'='+filter.get('valor').replace(/\//g, '@');
      }, this);
      return filters_format!='' ? '/'+filters_format : '';
  }
});
