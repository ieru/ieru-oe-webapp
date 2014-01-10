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
        define( 'PERMISSION_ACCESS_ADMIN_ZONE',    100 );

        define( 'PERMISSION_ACCESS_LANG_FILES',    200 );
        define( 'PERMISSION_ACCESS_LANG_FILES_EN', 201 );
        define( 'PERMISSION_ACCESS_LANG_FILES_ES', 202 );
        define( 'PERMISSION_ACCESS_LANG_FILES_FR', 203 );
        define( 'PERMISSION_ACCESS_LANG_FILES_DE', 204 );
        define( 'PERMISSION_ACCESS_LANG_FILES_LV', 205 );
        define( 'PERMISSION_ACCESS_LANG_FILES_ET', 206 );
        define( 'PERMISSION_ACCESS_LANG_FILES_EL', 207 );
        define( 'PERMISSION_ACCESS_LANG_FILES_TR', 208 );
        define( 'PERMISSION_ACCESS_LANG_FILES_IT', 209 );
        define( 'PERMISSION_ACCESS_LANG_FILES_PL', 210 );
        define( 'PERMISSION_ACCESS_LANG_FILES_AR', 211 );
        define( 'PERMISSION_ACCESS_LANG_FILES_RU', 212 );

        define( 'PERMISSION_ACCESS_AGINFRA_DATA',  300 );

        // Constants
        define( 'API_SERVER', 'organic-edunet.eu' );

        // Check if the user is trying to change the website language
        $route = explode( '/', $_SERVER['REQUEST_URI'] );
        if ( !isset( $route[1] ) OR $route[1] == '' OR strlen( $route[1] ) != 2 )
            header( 'Location: /en' );           

        // Define language as constant and change locale
        define( 'LANG', $route[1] );
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
     * Translate filters to new languages
     *
     * @return void
     */
    public function filters ()
    {
        $file = public_path().'/filters.php';
        $filters = require( $file );

        // Check to translate empty tags
        foreach ( $filters as $filter=>&$langs )
        {
            foreach ( $langs as $lang=>&$translation )
            {
                if ( $translation == '' )
                {
                    $url = 'http://'.API_SERVER.'/api/analytics/translate?text='.urlencode( $filter ).'&service=microsoft&to='.$lang;
                    $data = json_decode( $this->_curl_get_data( $url ) );
                    $translation = @$data->data->translation;
                }
            }
        }
        
        // Write the file
        if ( $fp = fopen( $file, 'w+' ) )
        {
            fwrite( $fp, "<?php\n" );
            fwrite( $fp, 'return ' );
            fwrite( $fp, var_export( $filters, true ) );
            fwrite( $fp, ';' );
            fclose( $fp );
        }

        var_dump( $filters ); die();

        // Make view
        $this->layout->content = View::make('admin.filters')
             ->with( 'lang', $lang );
    }

    /**
     * Administration of language file stored in a website.php file
     *
     * @return void
     */
    public function langfiles ()
    {
        $to = $this->_check_language_moderation();

        $lang = require( app_path().'/lang/'.$to.'/website.php' );
        $helpers = require( app_path().'/lang/en/website.php' );

        // Check to translate empty tags
        foreach ( $lang as $key=>&$term )
        {
            if ( $term == '' )
            {
                $url = 'http://'.API_SERVER.'/api/analytics/translate?text='.urlencode( $helpers[$key] ).'&service=microsoft&to='.$to;
                $data = json_decode( $this->_curl_get_data( $url ) );
                $term = @$data->data->translation;
            }
        }

        // Make view
        $this->layout->content = View::make('admin.langfile')
             ->with( 'lang', $lang )
             ->with( 'helpers', $helpers );
    }

    public function langfilessend ()
    {
        $to = $this->_check_language_moderation();

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
        $this->layout->content = View::make('admin.langfile')
                ->with( 'lang', $lang )
                ->with( 'helpers', $helpers );
    }

    /**
     * Edit javascript language files
     *
     * @return void
     */
    public function langfilesjs ()
    {
        $to = $this->_check_language_moderation();

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
                $term = @$data->data->translation;
            }
        }

        $this->layout->content = View::make('admin.langfile')
                ->with( 'lang', $lang )
                ->with( 'helpers', $helpers );
    }

    public function langfilessendjs ()
    {
        $to = $this->_check_language_moderation();

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
        $this->layout->content = View::make('admin.langfile')
                ->with( 'lang', $_POST )
                ->with( 'helpers', $helpers );
    }

    /**
     * Edit language files of error thrown by the interface
     *
     * @return View
     */
    public function langerror ()
    {
        $to = $this->_check_language_moderation();

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
                $term = @$data->data->translation;
            }
        }

        $this->layout->content = View::make('admin.langfileerrorjs')
                ->with( 'lang', $lang )
                ->with( 'helpers', $helpers );
    }

    public function langerrorsend ()
    {
        $to = $this->_check_language_moderation();

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
        $this->layout->content = View::make('admin.langfileerrorjs')
                ->with( 'lang', $_POST )
                ->with( 'helpers', $helpers );
    }

    /**
     * Edit suggest resources language files
     *
     * @return View
     */
    public function langfilessuggest ()
    {
        $to = $this->_check_language_moderation();

        $lang = require( app_path().'/lang/'.$to.'/suggest.php' );
        $helpers = require( app_path().'/lang/en/suggest.php' );

        // Check to translate empty tags
        foreach ( $lang as $key=>&$term )
        {
            if ( $term == '' )
            {
                $url = 'http://'.API_SERVER.'/api/analytics/translate?text='.urlencode( $helpers[$key] ).'&service=microsoft&to='.$to;
                $data = json_decode( $this->_curl_get_data( $url ) );
                $term = @$data->data->translation;
            }
        }

        $this->layout->content = View::make('admin.viewtextarea')
                ->with( 'lang', $lang )
                ->with( 'helpers', $helpers );
    }

    public function langfilessuggestsend ()
    {
        $to = $this->_check_language_moderation();

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
        $this->layout->content = View::make('admin.viewtextarea')
                ->with( 'title', 'Organic Lingua' )
                ->with( 'lang', $lang )
                ->with( 'helpers', $helpers );
    }

    /**
     * Edit about text language files
     *
     * @return View
     */
    public function about ()
    {
        $to = $this->_check_language_moderation();

        $lang = require( app_path().'/lang/'.$to.'/about.php' );
        $helpers = require( app_path().'/lang/en/about.php' );

        // Check to translate empty tags
        foreach ( $lang as $key=>&$term )
        {
            if ( $term == '' )
            {
                $url = 'http://'.API_SERVER.'/api/analytics/translate?text='.urlencode( $helpers[$key] ).'&service=microsoft&to='.$to;
                $data = json_decode( $this->_curl_get_data( $url ) );
                $term = @$data->data->translation;
            }
        }

        $this->layout->content = View::make('admin.viewtextarea')
                ->with( 'lang', $lang )
                ->with( 'helpers', $helpers );
    }

    public function aboutsend ()
    {
        $to = $this->_check_language_moderation();

        // Path to the file that stores the variables
        $file = app_path().'/lang/'.$to.'/about.php';
        $helpers = require( app_path().'/lang/en/about.php' );

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
        $lang = require( app_path().'/lang/'.$to.'/about.php' );

        // Request to build the view
        $this->layout->content = View::make('admin.viewtextarea')
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
     * Check if the user can change a language file.
     *
     * @return string
     */
    private function _check_language_moderation ()
    {
        if ( !static::$_user->check_permission( PERMISSION_ACCESS_LANG_FILES ) )
            die( '403 Unauthorized Access' );
        $to = Input::has( 'to' ) ? Input::get( 'to' ) : 'en';
        $langs = array( 'es', 'en', 'fr', 'el', 'et', 'lv', 'it', 'tr', 'pl', 'de', 'ar' );

        if ( $to == 'en' AND !static::$_user->check_permission( PERMISSION_ACCESS_LANG_FILES_EN ) )
            foreach ( $langs as $lang )
                if ( static::$_user->check_permission( constant( 'PERMISSION_ACCESS_LANG_FILES_'.strtoupper( $lang ) ) ) )
                    header( 'Location: '.$_SERVER['REDIRECT_URL'].'?to='.$lang, true, 301 );

        if ( !static::$_user->check_permission( constant( 'PERMISSION_ACCESS_LANG_FILES_'.strtoupper( $to ) ) ) )
            die( '403 Unauthorized Access' );

        return $to;
    }

    /**
     * @return void
     */
    public function termtrends ()
    {
        if ( !static::$_user->check_permission( PERMISSION_ACCESS_AGINFRA_DATA ) )
            die( '403 Unauthorized Access' );
        
        $this->layout->content = View::make('admin.termtrends');
    }

    /**
     * @return void
     */
    public function metadatastatistics ()
    {
        if ( !static::$_user->check_permission( PERMISSION_ACCESS_AGINFRA_DATA ) )
            die( '403 Unauthorized Access' );

        $this->layout->content = View::make('admin.metadatastatistics');
    }

    /**
     * @return void
     */
    public function otherservices ()
    {
        if ( !static::$_user->check_permission( PERMISSION_ACCESS_AGINFRA_DATA ) )
            die( '403 Unauthorized Access' );

        $this->layout->content = View::make('admin.otherservices');
    }
}