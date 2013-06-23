<?php

class HomeController extends BaseController {

    /*
    |--------------------------------------------------------------------------
    | Default Home Controller
    |--------------------------------------------------------------------------
    |
    | You may wish to use controllers instead of, or in addition to, Closure
    | based routes. That's great! Here is an example controller method to
    | get you started. To route to this controller, just add the route:
    |
    |   Route::get('/', 'HomeController@showWelcome');
    |
    */

    private $_user = null;

    public function __construct ()
    {
        // Check if the user is trying to change the website language
        if ( Input::has( 'lang-selector' ) )
            Session::put( 'language', Input::get( 'lang-selector' ) );
        // Set default language
        elseif ( !Session::has( 'language' ) )
            Session::put( 'language', 'en' );

        // Define language as constant and change locale
        define( 'LANG', Session::get( 'language' ) );
        App::setLocale(LANG);

        // Get user data
        if ( isset( $_COOKIE['usertoken'] ) AND $_COOKIE['usertoken'] )
        {
            $this->_user = User::join( 'tokens', 'users.user_id', '=', 'tokens.user_id')
                                 ->where( 'tokens.token_chars', '=', $_COOKIE['usertoken'] )
                                 ->where( 'tokens.token_active', '=', 1 )
                                 ->first();
        }
    }

    public function index ()
    {
        # Fetch one featured resource to show
        $ch = curl_init();
        $lang['en'] = 'english';
        $lang['fr'] = 'french';
        $lang['de'] = 'deutsch';
        $lang['el'] = 'greek';
        $lang['lv'] = 'latvian';
        $lang['it'] = 'italian';
        $lang['et'] = 'estonian';
        $lang['es'] = 'spanish';
        $lang['tr'] = 'turk';
/*
        curl_setopt( $ch, CURLOPT_URL, 'http://portal.organic-edunet.eu:8080/OrganicFeaturedResource/getMetadata?lang='.$lang[Session::get( 'language' )] );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 5 );
        curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 5 );
        curl_setopt( $ch, CURLOPT_TIMEOUT, 15 );
        $featured = @get_object_vars( json_decode( curl_exec( $ch ) ) );
        curl_close( $ch );

        foreach ( $lang as $k=>$v )
            if ( $featured['lang'] == $v )
                $featured['lang'] = $k;
*/
        # Get a featured resource
        $filter = array(15879,9390);
        $featured = DB::select(DB::raw('SELECT string.Text as title, strings.Text as description, string.FK_general, identifier.entry_metametadata as entry,
                                        technical.location as url, string.language as language
                               FROM string
                                   INNER JOIN string as strings ON string.FK_general=strings.FK_general
                                   INNER JOIN identifier ON string.FK_general=identifier.FK_general
                                   INNER JOIN technical ON string.FK_general=technical.FK_lom
                               WHERE string.FK_title is not NULL AND strings.FK_description is not NULL
                                   AND ( ( string.language="en" AND strings.language="en" ) OR ( string.language="'.LANG.'" AND strings.language="'.LANG.'" ) )
                                   AND string.FK_general IN ( '.implode(',', $filter).' )
                               ORDER BY RAND()
                               LIMIT 1' ));
        $featured[0]->description = substr( $featured[0]->description, 0, 300 );

        # Get the required information for showing the resources at the home page
        $filter = array(13754, 13753, 13751, 13750, 13749);
        $carousel = DB::select(DB::raw('SELECT string.Text as title, strings.Text as description, string.FK_general, identifier.entry_metametadata as entry,
                                        technical.location as url, string.language as language
                               FROM string
                                   INNER JOIN string as strings ON string.FK_general=strings.FK_general
                                   INNER JOIN identifier ON string.FK_general=identifier.FK_general
                                   INNER JOIN technical ON string.FK_general=technical.FK_lom
                               WHERE string.FK_title is not NULL AND strings.FK_description is not NULL
                                   AND ( ( string.language="en" AND strings.language="en" ) OR ( string.language="'.LANG.'" AND strings.language="'.LANG.'" ) )
                               ORDER BY string.FK_general DESC
                               LIMIT 0,5' ));

        # Shorten the description
        foreach ( $carousel as &$item )
            $item->description = substr( $item->description, 0, 170 );

        # Get the user language of the resource
        if ( Session::get( 'language' ) <> 'en' )
        {
            foreach ( $carousel as &$resource )
            {
                $new = DB::select(DB::raw('SELECT string.Text as title, strings.Text as description, string.FK_general, identifier.entry_metametadata as entry,
                                identifier.entry as url, string.language as language
                       FROM string
                            INNER JOIN string as strings ON string.FK_general=strings.FK_general
                            INNER JOIN identifier ON string.FK_general=identifier.FK_general
                       WHERE string.FK_title is not NULL AND strings.FK_description is not NULL
                            AND string.language="'.Session::get( 'language' ).'" AND strings.language="'.Session::get( 'language' ).'"
                            AND string.fk_general = '.$resource->FK_general.'
                       ORDER BY string.FK_general DESC
                       LIMIT 1' ));
                if ( count( $new ) )
                    $resource = $new[0];
            }
        }

        return View::make('appview')
                ->with( 'carousel', $carousel )
                ->with( 'featured', $featured )
                ->with( '_user', $this->_user );
    }
}