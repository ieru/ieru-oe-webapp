var WIDGET_HOST = "socialcomputing.know-center.tugraz.at/";
//var WIDGET_HOST = "localhost/";
var WIDGET_PATH = "VisRecWidget/";
var WIDGET_TAG = "page-recommended-div";

//default values for Bubble version
var SOURCE = "LoadBubbleVIZ_alternate.js"
var ID = 'BubbleWidget';

//random function for switching between Bubble and List version
var rand = Math.random();
if(rand < 0.5) {
        SOURCE = "LoadListVIZ_alternate.js";
        ID = 'ListWidget';
}

console.log(rand+" : "+SOURCE+" : "+ID);

//window.onload = function(){
//function loadWidget() {
try {
	var x = document.createElement("SCRIPT");
	x.type = "text/javascript";
	x.src = "http://" + WIDGET_HOST + WIDGET_PATH + SOURCE;
	console.log("http://" + WIDGET_HOST + WIDGET_PATH + SOURCE)
	x.setAttribute("RecommendationType", "user"); //or "resource" for resource recommendations
	x.setAttribute("ViewType","ListLarge"); //ListLarge, ListSmall, OverviewLarge, OverviewBubble
	x.setAttribute("RecommendationIdentifier", $("#user-username").html()); //either resource or user id aionescu mdaliani
	x.setAttribute("WidgetWidth", "710");
	x.setAttribute("WidgetHeight", "710");
	x.setAttribute("NumRecommendations", 100);
	x.setAttribute("ShowTop", "true");
	x.setAttribute("Language", $('html').attr('lang'));
	x.setAttribute("WidgetTitle", "");
	x.setAttribute('id', ID);
	document.getElementsByTagName("head")[0].appendChild(x);
} catch (e) {}
