<?php
class AdminController extends BaseController {

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
        // Report all errors
        error_reporting( E_ALL );
        ini_set( 'display_errors', '1' );

        // Constants
        define( 'PERMISSION_ACCESS_ADMIN_ZONE', 100 );
        define( 'API_SERVER', 'organic-edunet.eu' );

        // Get user data
        if ( isset( $_COOKIE['usertoken'] ) AND $_COOKIE['usertoken'] )
        {
            $this->_user = User::join( 'tokens', 'users.user_id', '=', 'tokens.user_id')
                               ->where( 'tokens.token_chars', '=', $_COOKIE['usertoken'] )
                               ->where( 'tokens.token_active', '=', 1 )
                               ->first();

            if ( !$this->_user->check_permission( PERMISSION_ACCESS_ADMIN_ZONE ) )
            {
                die( '403 Unauthorized Access' );
            }
        }
        else
        {
            die( '403 Unauthorized Access' );
        }
    }

    /**
     * Home page
     *
     * @return View
     */
    public function home ()
    {
        return View::make( 'adminhome' )
                   ->with( 'title', 'Organic Lingua' );
    }

    /**
     * Administration of language files
     *
     * @return View
     */
    public function langfiles ()
    {
        $to = Input::has( 'to' ) ? Input::get( 'to' ) : 'en';

        $lang = require( app_path().'/lang/'.$to.'/website.php' );

        // Check to translate empty tags
        foreach ( $lang as $key=>&$term )
        {
            if ( $term == '' )
            {
                $url = 'http://'.API_SERVER.'/api/analytics/translate?text='.str_replace( '_', '+', $key ).'&service=microsoft&to='.$to;
                $data = json_decode( $this->_curl_get_data( $url ) );
                $term = $data->data->translation;
            }
        }

        return View::make( 'adminview' )
                ->with( 'title', 'Organic Lingua' )
                ->with( 'lang', $lang );
    }

    /**
     * Save the information changed in the language file form
     */
    public function langfilessend ()
    {
        // Language to translate to
        $to = Input::has( 'to' ) ? Input::get( 'to' ) : 'en';

        // Path to the file that stores the variables
        $file = app_path().'/lang/'.$to.'/website.php';

        // Write the file
        if ( $fp = fopen( $file, 'w+' ) )
        {
            fwrite( $fp, "<?php\n" );
            fwrite( $fp, "return array(\n" );
            foreach ( $_POST as $key=>$value )
                fwrite( $fp, "'".strtolower($key)."'=>'". addslashes($value)."',\n" );
            fwrite( $fp, ");" );
            fclose( $fp );
        }

        // Load the language file
        $lang = require( app_path().'/lang/'.$to.'/website.php' );

        // Request to build the view
        return View::make( 'adminview' )
                ->with( 'title', 'Organic Lingua' )
                ->with( 'lang', $lang );
    }

    /**
     * Connects with the remote services. Sets a timeout for connecting the 
     * service and a timeout for receiving the data.
     *
     * @param   String  $url        The url to retrieve, it must return a json.
     * @return  String  json returned by remote service
     */
    private function & _curl_get_data ( $url, $data = null ) 
    {
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 2 );
        curl_setopt( $ch, CURLOPT_TIMEOUT, 7 );
        $data = curl_exec( $ch );
        curl_close( $ch );
        return $data;
    }

    /**
     * Para los archivos JavaScript
     * @return View
     */
    public function langfilesjs ()
    {
        $to = Input::has( 'to' ) ? Input::get( 'to' ) : 'en';

        $lang = require( app_path().'/lang/'.$to.'/website.php' );

        // The NYT must be the first key of the array
        if ( array_key_exists( 'NYT', $lang ) )
        {
            unset( $lang['NYT'] );
            foreach ( $lang as &$term )
            {
                $url = 'http://lingua.dev/api/analytics/translate?text='.str_replace( ' ', '+', $term ).'&service=microsoft&to='.$to;
                $data = json_decode( $this->_curl_get_data( $url ) );
                $term = @$data->data->translation;
            }
        }

        // Check for empty fields (newly added lang keys)
        foreach ( $lang as $key=>&$term )
        {
            if ( $term == '' )
            {
                $url = 'http://lingua.dev/api/analytics/translate';
                $data = json_decode( $this->_curl_get_data( $url, array( 'text'=>str_replace( '_', ' ', $key ), 'to'=>$to ) ) );
                $term = $data->data->translation;
            }
        }

        return View::make( 'adminview' )
                ->with( 'title', 'Organic Lingua' )
                ->with( 'lang', $lang );
    }

    public function langfilessendjs ()
    {
        // Language to translate to
        $to = Input::has( 'to' ) ? Input::get( 'to' ) : 'en';

        // Path to the file that stores the variables
        $file = path('app').'/language/lang/'.$to.'.js';

        // Write the file
        if ( $fp = fopen( $file, 'w+' ) )
        {
            fwrite( $fp, "<?php\n" );
            fwrite( $fp, "return array(\n" );
            foreach ( $_POST as $key=>$value )
                fwrite( $fp, "'$key'=>'". addslashes($value)."',\n" );
            fwrite( $fp, ");" );
            fclose( $fp );
        }

        // Load the language file
        $lang = lang::file( null, $to, 'website' );

        // Request to build the view
        return View::make( 'admin.langfiles' )
                ->with( 'title', 'Organic Lingua' )
                ->with( 'lang', $lang );
    }
}