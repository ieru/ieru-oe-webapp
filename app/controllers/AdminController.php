<?php
class AdminController extends BaseController 
{
    /** 
     * @var Logged user information 
     */
    private $_user = null;

    /**
     * Constructor
     */
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
        $helpers = require( app_path().'/lang/en/website.php' );

        // Check to translate empty tags
        foreach ( $lang as $key=>&$term )
        {
            if ( $term == '' )
            {
                $url = 'http://'.API_SERVER.'/api/analytics/translate?text='.urlencode( $helpers[$key] ).'&service=microsoft&to='.$to;
                $data = json_decode( $this->_curl_get_data( $url ) );
                $term = $data->data->translation;
            }
        }

        return View::make( 'adminview' )
                ->with( 'title', 'Organic Lingua' )
                ->with( 'lang', $lang )
                ->with( 'helpers', $helpers );
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
        $helpers = require( app_path().'/lang/en/website.php' );

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
                ->with( 'lang', $lang )
                ->with( 'helpers', $helpers );
    }

    /**
     * Para los archivos JavaScript
     * @return View
     */
    public function langfilesjs ()
    {
        // Fetch the file that the user wants to edit translation
        $to = Input::has( 'to' ) ? Input::get( 'to' ) : 'en';

        // Retrieve file
        $lang = file_get_contents( base_path().'/public/js/lang/'.$to.'.js' );
        $lang = str_replace( 'lang_file = ', '', $lang );
        $lang = json_decode( json_encode( json_decode( $lang ) ), true );

        // Load helpers
        $helpers = file_get_contents( base_path().'/public/js/lang/en.js' );
        $helpers = str_replace( 'lang_file = ', '', $helpers );
        $helpers = json_decode( json_encode( json_decode( $helpers ) ), true );

        // Check to translate empty tags
        foreach ( $lang as $key=>&$term )
        {
            if ( $term == '' and !is_array( $term ) )
            {
                $url = 'http://'.API_SERVER.'/api/analytics/translate?text='.urlencode($helpers[$key]).'&service=microsoft&to='.$to;
                $data = json_decode( $this->_curl_get_data( $url ) );
                $term = $data->data->translation;
            }
        }

        return View::make( 'admin_lang_js' )
                ->with( 'title', 'Organic Lingua' )
                ->with( 'lang', $lang )
                ->with( 'helpers', $helpers );
    }

    public function langfilessendjs ()
    {
        // Language to translate to
        $to = Input::has( 'to' ) ? Input::get( 'to' ) : 'en';

        // Path to the file that stores the variables
        $file = base_path().'/public/js/lang/'.$to.'.js';

        // Write the file
        if ( $fp = fopen( $file, 'w+' ) )
        {
            fwrite( $fp, "lang_file = " );
            fwrite( $fp, json_encode( $_POST ) );
            fclose( $fp );
        }

        // Load helpers
        $helpers = file_get_contents( base_path().'/public/js/lang/en.js' );
        $helpers = str_replace( 'lang_file = ', '', $helpers );
        $helpers = json_decode( json_encode( json_decode( $helpers ) ), true );

        // Request to build the view
        return View::make( 'admin_lang_js' )
                ->with( 'title', 'Organic Lingua' )
                ->with( 'lang', $_POST )
                ->with( 'helpers', $helpers );
    }

    /**
     *
     */
    /**
     * Para los archivos JavaScript
     * @return View
     */
    public function langerror ()
    {
        // Fetch the file that the user wants to edit translation
        $to = Input::has( 'to' ) ? Input::get( 'to' ) : 'en';

        // Retrieve file
        $lang = file_get_contents( base_path().'/public/js/lang/error/'.$to.'.js' );
        $lang = str_replace( 'error_file = ', '', $lang );
        $lang = json_decode( json_encode( json_decode( $lang ) ), true );

        // Load helpers
        $helpers = file_get_contents( base_path().'/public/js/lang/error/en.js' );
        $helpers = str_replace( 'error_file = ', '', $helpers );
        $helpers = json_decode( json_encode( json_decode( $helpers ) ), true );

        // Check to translate empty tags
        foreach ( $lang as $key=>&$term )
        {
            if ( $term == '' and !is_array( $term ) )
            {
                $url = 'http://'.API_SERVER.'/api/analytics/translate?text='.urlencode($helpers[$key]).'&service=microsoft&to='.$to;
                $data = json_decode( $this->_curl_get_data( $url ) );
                $term = $data->data->translation;
            }
        }

        return View::make( 'admin_error_js' )
                ->with( 'title', 'Organic Lingua' )
                ->with( 'lang', $lang )
                ->with( 'helpers', $helpers );
    }

    /**
     * Save the information changed in the language file form
     */
    public function langerrorsend ()
    {
        // Language to translate to
        $to = Input::has( 'to' ) ? Input::get( 'to' ) : 'en';

        // Path to the file that stores the variables
        $file = base_path().'/public/js/lang/error/'.$to.'.js';

        // Write the file
        if ( $fp = fopen( $file, 'w+' ) )
        {
            fwrite( $fp, "error_file = " );
            fwrite( $fp, json_encode( $_POST ) );
            fclose( $fp );
        }

        // Load helpers
        $helpers = file_get_contents( base_path().'/public/js/lang/error/en.js' );
        $helpers = str_replace( 'error_file = ', '', $helpers );
        $helpers = json_decode( json_encode( json_decode( $helpers ) ), true );

        // Request to build the view
        return View::make( 'admin_error_js' )
                ->with( 'title', 'Organic Lingua' )
                ->with( 'lang', $_POST )
                ->with( 'helpers', $helpers );
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
}