<?php
class AdminController extends BaseController 
{
    /**
     * @var layout controller
     */
    protected $layout = 'layouts.admin';

    /** 
     * @var Logged user information 
     */
    public static $_user = null;

    /**
     * Constructor
     */
    public function __construct ()
    {
        // Permissions
        define( 'PERMISSION_ACCESS_ADMIN_ZONE',   100 );
        define( 'PERMISSION_ACCESS_LANG_FILES',   200 );
        define( 'PERMISSION_ACCESS_AGINFRA_DATA', 300 );

        // Constants
        define( 'API_SERVER', 'organic-edunet.eu' );

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
            static::$_user = User::join( 'tokens', 'users.user_id', '=', 'tokens.user_id')
                               ->where( 'tokens.token_chars', '=', $_COOKIE['usertoken'] )
                               ->where( 'tokens.token_active', '=', 1 )
                               ->first();

            if ( !static::$_user->check_permission( PERMISSION_ACCESS_ADMIN_ZONE ) )
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
     * @return void
     */
    public function home ()
    {
        $this->layout->content = View::make('admin.home');
    }

    /**
     * Administration of language file stored in a website.php file
     *
     * @param   string  to      The ISO code of the language file to be edited
     * @return void
     */
    public function langfiles ()
    {
        if ( !static::$_user->check_permission( PERMISSION_ACCESS_LANG_FILES ) )
            die( '403 Unauthorized Access' );

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

        // Make view
        $this->layout->content = View::make('admin.langfile')
             ->with( 'lang', $lang )
             ->with( 'helpers', $helpers );
    }

    public function langfilessend ()
    {
        if ( !static::$_user->check_permission( PERMISSION_ACCESS_LANG_FILES ) )
            die( '403 Unauthorized Access' );

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
     * Edit javascript language files
     *
     * @param   string  to      The ISO code of the language file to be edited
     * @return void
     */
    public function langfilesjs ()
    {
        if ( !static::$_user->check_permission( PERMISSION_ACCESS_LANG_FILES ) )
            die( '403 Unauthorized Access' );

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
        if ( !static::$_user->check_permission( PERMISSION_ACCESS_LANG_FILES ) )
            die( '403 Unauthorized Access' );

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
     * Edit language files of error thrown by the interface
     *
     * @param   string  to      The ISO code of the language file to be edited
     * @return View
     */
    public function langerror ()
    {
        if ( !static::$_user->check_permission( PERMISSION_ACCESS_LANG_FILES ) )
            die( '403 Unauthorized Access' );

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

    public function langerrorsend ()
    {
        if ( !static::$_user->check_permission( PERMISSION_ACCESS_LANG_FILES ) )
            die( '403 Unauthorized Access' );

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
     * Edit suggest resources language files
     *
     * @param   string  to      The ISO code of the language file to be edited
     * @return View
     */
    public function langfilessuggest ()
    {
        if ( !static::$_user->check_permission( PERMISSION_ACCESS_LANG_FILES ) )
            die( '403 Unauthorized Access' );

        $to = Input::has( 'to' ) ? Input::get( 'to' ) : 'en';

        $lang = require( app_path().'/lang/'.$to.'/suggest.php' );
        $helpers = require( app_path().'/lang/en/suggest.php' );

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

        return View::make( 'adminviewtextarea' )
                ->with( 'title', 'Organic Lingua' )
                ->with( 'lang', $lang )
                ->with( 'helpers', $helpers );
    }

    public function langfilessuggestsend ()
    {
        if ( !static::$_user->check_permission( PERMISSION_ACCESS_LANG_FILES ) )
            die( '403 Unauthorized Access' );
            
        // Language to translate to
        $to = Input::has( 'to' ) ? Input::get( 'to' ) : 'en';

        // Path to the file that stores the variables
        $file = app_path().'/lang/'.$to.'/suggest.php';
        $helpers = require( app_path().'/lang/en/suggest.php' );

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
        $lang = require( app_path().'/lang/'.$to.'/suggest.php' );

        // Request to build the view
        return View::make( 'adminviewtextarea' )
                ->with( 'title', 'Organic Lingua' )
                ->with( 'lang', $lang )
                ->with( 'helpers', $helpers );
    }

    /**
     * Connects with the remote services. Sets a timeout for connecting the 
     * service and a timeout for receiving the data.
     *
     * @param   String  $url        The url to retrieve, it must return a json.
     * @return  String  json returned by remote service
     */
    private function & _curl_get_data ( $url ) 
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
     *
     */
    public function termtrends ()
    {
        $this->layout->content = View::make('admin.termtrends');
    }

    /**
     *
     */
    public function metadatastatistics ()
    {
        $this->layout->content = View::make('admin.metadatastatistics');
    }

    /**
     *
     */
    public function otherservices ()
    {
        $this->layout->content = View::make('admin.otherservices');
    }
}