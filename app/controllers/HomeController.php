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
        // Get a featured resource
        $f = Lom::with('General', 'General.Identifier')
                ->join('generals', 'generals.lom_id','=','loms.lom_id')
                ->join('generals_languages',    'generals_languages.general_id',    '=', 'generals.general_id')
                ->join('generals_titles',       'generals_titles.general_id',       '=', 'generals.general_id')
                ->join('generals_descriptions', 'generals_descriptions.general_id', '=', 'generals.general_id')
                //->orderBy(DB::raw('RAND()'))
                ->where('generals_languages.generals_language_lang','=',LANG)
                ->where('generals_titles.generals_title_lang','=',LANG)
                ->where('generals_descriptions.generals_description_lang','=',LANG)
                ->take(10)
                ->orderBy('generals.lom_id')
                ->get();
        // If no resources in that language, use default language (en)
        if ( !$f->count() )
        {
            $f = Lom::with('General', 'General.Identifier')
                    ->join('generals', 'generals.lom_id','=','loms.lom_id')
                    ->join('generals_languages',    'generals_languages.general_id',    '=', 'generals.general_id')
                    ->join('generals_titles',       'generals_titles.general_id',       '=', 'generals.general_id')
                    ->join('generals_descriptions', 'generals_descriptions.general_id', '=', 'generals.general_id')
                    //->orderBy(DB::raw('RAND()'))
                    ->where('generals_languages.generals_language_lang','=','en')
                    ->where('generals_titles.generals_title_lang','=','en')
                    ->where('generals_descriptions.generals_description_lang','=','en')
                    ->take(10)
                    ->orderBy('generals.lom_id')
                    ->get();
        }
        $featured = $f[rand( 0, 9 )];

        // Get the required information for showing the resources at the home page
        $carousel = Lom::with('General', 'General.Identifier')
                        ->join('generals', 'generals.lom_id','=','loms.lom_id')
                        ->join('generals_languages',    'generals_languages.general_id',    '=', 'generals.general_id')
                        ->join('generals_titles',       'generals_titles.general_id',       '=', 'generals.general_id')
                        ->join('generals_descriptions', 'generals_descriptions.general_id', '=', 'generals.general_id')
                        ->orderBy('loms.lom_id', 'DESC')
                        ->where('generals_languages.generals_language_lang','=',LANG)
                        ->where('generals_titles.generals_title_lang','=',LANG)
                        ->where('generals_descriptions.generals_description_lang','=',LANG)
                        ->take(5)
                        ->get();
        if ( !$carousel->count() )
        {
            $carousel = Lom::with('General', 'General.Identifier')
                            ->join('generals', 'generals.lom_id','=','loms.lom_id')
                            ->join('generals_languages',    'generals_languages.general_id',    '=', 'generals.general_id')
                            ->join('generals_titles',       'generals_titles.general_id',       '=', 'generals.general_id')
                            ->join('generals_descriptions', 'generals_descriptions.general_id', '=', 'generals.general_id')
                            ->orderBy('loms.lom_id', 'DESC')
                            ->where('generals_languages.generals_language_lang','=','en')
                            ->where('generals_titles.generals_title_lang','=','en')
                            ->where('generals_descriptions.generals_description_lang','=','en')
                            ->take(5)
                            ->get();
        }

        return View::make('appview')
                ->with( 'carousel', $carousel )
                ->with( 'featured', $featured )
                ->with( '_user', $this->_user );
    }
}