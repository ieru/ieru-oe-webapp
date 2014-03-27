var WIDGET_HOST = "socialcomputing.know-center.tugraz.at/"; //change this to localhost if all of the web stuff is run on your own server
var WIDGET_PATH = "VisRecWidget/"; //change this to path on the localhost if everything is run on your own server
var WIDGET_TAG = "resource-recommendations"; //id of the element the list gets attached to

var item_id = Backbone.history.fragment.split('/')[1];
console.log("recommendations_widget for " + item_id);
try {
    var x = document.createElement("SCRIPT");
    x.type = "text/javascript";
    //x.src = "http://" + WIDGET_HOST + WIDGET_PATH + "LoadListVIZ_alternate.js?ranum=" + item_id;
    x.src = "http://" + WIDGET_HOST + WIDGET_PATH + "LoadListVIZ_alternate.js?ranum=" + item_id;
    x.setAttribute("User", ""); //user name, can be left empty for unpersonalized recommendations
    x.setAttribute("RecommendationType", "resource"); //"user" for user recommendations
    x.setAttribute("ViewType","ListSmall"); //ListLarge or ListSmall - purely informational
    x.setAttribute("NumRecommendations", 5); //how many recommendations are shown
    x.setAttribute("RecommendationIdentifier", item_id); //either resource or user id
    x.setAttribute("WidgetWidth", "100%");
    x.setAttribute("WidgetHeight", "100%");
    x.setAttribute("ShowTop", "false"); //set to "true" or "false" to show title, search box, and sort options
    x.setAttribute("WidgetTitle", ""); //empty if no title
    x.setAttribute("Language", $('html').attr('lang'));
    x.setAttribute("uiLanguage", $('html').attr('lang'));
    x.setAttribute('id', 'ListWidget');
    document.getElementById(WIDGET_TAG).appendChild(x);
} catch (e) {}

// http://socialcomputing.know-center.tugraz.at/VisRecWidget/TestListViz_r2r_alternate.html?resID=7385&lang=es

/*
        function getURLParameter(name) {
            return decodeURI(
                (RegExp(name + '=' + '(.+?)(&|$)').exec(location.search)||[,null])[1]
            );
        }
        
        var language = getURLParameter("lang");
     var resID = getURLParameter("resID");
        
        var WIDGET_HOST = "socialcomputing.know-center.tugraz.at/"; //change this to localhost if all of the web stuff is run on your own server
    var WIDGET_PATH = "VisRecWidget/"; //change this to path on the localhost if everything is run on your own server
        var WIDGET_TAG = "widget"; //id of the element the list gets attached to
        
    window.onload = function(){

    try {
        var x = document.createElement("SCRIPT");
        x.type = "text/javascript";
        x.src = "http://" + WIDGET_HOST + WIDGET_PATH + "LoadListVIZ_alternate.js";
        x.setAttribute("User", "admin"); //user name, can be left empty for unpersonalized recommendations
        x.setAttribute("RecommendationType", "resource"); //"user" for personalized recommendations or "resource" for resource recommendations
        x.setAttribute("ViewType","ListSmall"); //Available types: ListSmall, ListLarge, ListSmall, OverviewLarge, OverviewBubble
        x.setAttribute("NumRecommendations", 10); //Current maximum is 10
        x.setAttribute("RecommendationIdentifier", resID); //either resource id or user id
        x.setAttribute("WidgetWidth", "400");
        x.setAttribute("WidgetHeight", "720");
        x.setAttribute("ShowTop", "false"); //set to "true" or "false" to show title, search box, and sort options
        x.setAttribute("WidgetTitle", "Recommendations"); //empty if no title
        x.setAttribute("Language", language);
        x.setAttribute('id', 'ListWidget');
        document.getElementById(WIDGET_TAG).appendChild(x);
    } catch (e) {}
    
    };
*/