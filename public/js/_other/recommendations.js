var WIDGET_HOST = "socialcomputing.know-center.tugraz.at/"; //change this to localhost if all of the web stuff is run on your own server
var WIDGET_PATH = "VisRecWidget/"; //change this to path on the localhost if everything is run on your own server
var WIDGET_TAG = "resource-recommendations";

var item_id = Backbone.history.fragment.split('/')[1];
console.log("recommendations_widget for " + item_id);
try {
    var x = document.createElement("SCRIPT");
    x.type = "text/javascript";
    x.src = "http://" + WIDGET_HOST + WIDGET_PATH + "LoadListVIZ_alternate.js?ranum=" + item_id;
    x.setAttribute("RecommendationType", "user"); //"user" for user recommendations
    x.setAttribute("ViewType","ListSmall"); //ListLarge or ListSmall - purely informational
    x.setAttribute("NumRecommendations", 5); //how many recommendations are shown
    x.setAttribute("RecommendationIdentifier", item_id); //either resource or user id
    x.setAttribute("WidgetWidth", "100%");
    x.setAttribute("WidgetHeight", "100%");
    x.setAttribute("ShowTop", "false"); //set to "true" or "false" to show title, search box, and sort options
    x.setAttribute("WidgetTitle", ""); //empty if no title
    x.setAttribute('id', 'ListWidget');
    $("#resource-recommendations").append(x);
} catch (e) {}