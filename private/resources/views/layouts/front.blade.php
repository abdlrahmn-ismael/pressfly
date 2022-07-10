<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">


    @if(Request::is('/'))
        <title> اكتشف العالم اول باول مع مجلة النهاردة </title>
        <meta name="description" content="مجلة النهاردة هي عبارة عن منصة تضم مقالات في جميع المجالات ، بما في ذلك الأخبار والرياضة والتكنولوجيا والصحة والجمال ، بكل مصداقية في الكتابة ونقل المعلومات ، نسعى جاهدين لنيل ثقة القارئ">
        <meta name="keywords" content="مجلة النهاردة هي عبارة عن منصة تتضمن مقالات في جميع المجالات ، بيتكوين  ، تشفير ، أزياء ، فوركس ، ألعاب ، صحة ، هواتف محمولة ، أخبار ، أخرى ، حيوانات أليفة ، برامج ، رياضة ، قصص ، تكنولوجيا">
    @else
        <title>@yield('title', e(get_option('site_meta_title', get_option('site_name'))))</title>
        <meta name="description" content="@yield('description', e(get_option('site_description')))">
        <meta name="keywords" content="@yield('keywords', e(get_option('site_keywords')))">
    @endif




    <link rel="canonical" href="{{ url()->current() }}" />

    <link rel="alternate" type="application/rss+xml" title="{{ get_option('site_name') }} {{ __('Feed') }}"
        href="{{ route('feed') }}" />
    @if (request()->route()->getName() === 'category.show')
        <link href="{{ request()->route()->parameter('category')->feed() }}" rel="alternate"
            type="application/rss+xml"
            title="{{ __(':category-name Category Feed', ['category-name' => request()->route()->parameter('category')->name]) }}" />
    @endif
    @if (request()->route()->getName() === 'tag.show')
        <link href="{{ request()->route()->parameter('tag')->feed() }}" rel="alternate" type="application/rss+xml"
            title="{{ __(':tag-name Tag Feed', ['tag-name' => request()->route()->parameter('tag')->name]) }}" />
    @endif
    @if (request()->route()->getName() === 'author.show')
        <link href="{{ route('author.feed', ['username' => request()->route()->parameter('username')]) }}"
            rel="alternate" type="application/rss+xml"
            title="{{ __(':author Author Feed', ['author' => request()->route()->parameter('username')]) }}" />
    @endif

    <!----- Favicon ----->
    <link href="https://i.ibb.co/kGpy1cH/alnhrdh-favicon.png" type="image/x-icon" rel="icon">
    <link href="https://i.ibb.co/kGpy1cH/alnhrdh-favicon.png" type="image/x-icon" rel="shortcut icon">


    <!------ add arabic rtl style ------->
    <link href="https://cdn.jsdelivr.net/gh/RTLCSS/bootstrap@4.2.1-rtl/dist/css/rtl/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.11.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/owl.carousel@2.3.4/dist/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/owl.carousel@2.3.4/dist/assets/owl.theme.default.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/selection-sharer@1.1.0/dist/selection-sharer.css">
    <link
        href="https://fonts.googleapis.com/css?family=Roboto+Slab:100,300,400,700|Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('assets/css/app.css?v=' . APP_VERSION) }}" rel="stylesheet">

    <!------ add arabic rtl style ------->
    <link href="{{ asset('assets/css/rtl.css?v=' . APP_VERSION) }}" rel="stylesheet">

    <link href="{{ asset('assets/css/custom_style.css') }}" rel="stylesheet">

    @include('_partials.header_css')

    {!! get_option('frontend_head_code') !!}

    @stack('header')
</head>

<body
    class="{{ str_replace('.','-',request()->route()->getName()) }} {{ get_option('language_direction', 'ltr') }} @stack('body_class')">

    @include('_partials.flash_message_toast')

    <div class="top-nav">
        <div class="container">
            <div class="wrap-inner">
                <div class="top-social">

                </div>
                <div class="top-menu">
                    <ul class="list-inline">
                        @if (Auth::check())
                            <div class="dropdown">
                                <button class="btn dropdown-toggle list-inline-item" type="button"
                                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <li class="list-inline-item"> <i class="fas fa-user"></i>
                                        {{ ucfirst(Auth::user()->username) }} </li>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    @if (Auth::user()->role == 'admin')
                                        <a class="dropdown-item" href="{{ url('/admin') }}"> <i
                                                class="fas fa-tachometer-alt"></i> {{ __('Dashboard') }} </a>
                                    @endif
                                    <a class="dropdown-item" href="{{ url('/logout') }}"> <i
                                            class="fas fa-sign-out-alt"></i> {{ __('Logout') }} </a>
                                </div>
                            </div>
                        @else
                            <li class="list-inline-item"> <a href="{{ url('/login') }}"> <i class="fas fa-user"></i>
                                {{ __('Login') }} </a> </li>
                            <li class="list-inline-item" style="color: #fff ; font-size:20px "> | </li>
                            <li class="list-inline-item"> <a href="{{ url('/register') }}"> <i
                                        class="fas fa-sign-in-alt"></i> {{ __('Register') }} </a> </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="header">
        <div class="container">
            <div class="wrap-inner">
                <div class="logo">
                    <a href="{{ url('/') }}" class="navbar-brand">
                        <img src="https://i.ibb.co/zhvZFy5/alnhrdh-logo.jpg" alt="alnhrdh.com" height="120"
                            style="border-radius: 10px">
                    </a>
                </div>
                <div class="top-banner">
                    <?= applyShortCodes('[ads id="' . get_style('header_ad') . '"]') ?>
                </div>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-light navbar-main sticky-top">
        <div class="container">
            <a href="{{ url('/') }}" class="navbar-brand">
                <img src="https://i.ibb.co/zhvZFy5/alnhrdh-logo.jpg" alt="alnhrdh.com" >
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse"
                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                {!! menu_display(get_style('main_menu'), ['ul_class' => 'navbar-nav mr-auto', 'a_class' => 'nav-link']) !!}

                <ul class="navbar-nav my-2 my-lg-0">

                    <li class="nav-item mini-search-menu-item">
                        <form method="get" action="{{ route('search') }}" class="d-flex justify-content-center">
                            <input name="q" class="form-control" type="search" required
                                placeholder="{{ __('Search keywords') }}" value="{{ request()->get('q', '') }}">
                            <button class="btn btn-outline-success" type="submit"><i
                                    class="fas fa-search"></i></button>
                        </form>
                    </li>
                    <li class="nav-item search-menu-item">
                        <a class="nav-link" href="#"><i class="fas fa-search fa-fw"></i></a>
                        <div class="menu-search">
                            <form method="get" action="{{ route('search') }}"
                                class="d-flex justify-content-center">
                                <input name="q" class="form-control" type="search" required
                                    placeholder="{{ __('Search keywords') }}"
                                    value="{{ request()->get('q', '') }}">
                                <button class="btn btn-outline-success" type="submit">
                                    <i class="fas fa-search"></i></button>
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <footer class="footer mt-3">
        <div class="container">
            <div class="row">

                <div class="col-lg-4 logo-box">
                    <div class="col-inner">

                        <a href="{{ url('/') }}" class="navbar-brand">
                            <img src="https://i.ibb.co/zhvZFy5/alnhrdh-logo.jpg" alt="alnhrdh.com" height="120"
                                style="border-radius: 10px">
                        </a>

                        <p class="site-info">
                            مجلة النهاردة أفضل المقالات والأخبار في جميع المجالات وفقًا للقواعد المهنية الأصلية لمهنة الصحافة ، والتي تعطي الأولوية في صناعة الصحافة لإنتاج الأخبار والمعلومات بمصداقية مطلقة وعمق تحليل وشفافية في المعلومات
                        </p>

                        <div class="top-social social-icons">
                            <ul class="list-inline">
                                @if (get_option('facebook_url'))
                                    <li class="list-inline-item">
                                        <a href="{{ get_option('facebook_url') }}" class="fab fa-facebook-square"
                                            target="_blank"></a>
                                    </li>
                                @endif
                                @if (get_option('twitter_url'))
                                    <li class="list-inline-item">
                                        <a href="{{ get_option('twitter_url') }}" class="fab fa-twitter-square"
                                            target="_blank"></a>
                                    </li>
                                @endif
                                @if (get_option('google_plus_url'))
                                    <li class="list-inline-item">
                                        <a href="{{ get_option('google_plus_url') }}"
                                            class="fab fa-google-plus-square" target="_blank"></a>
                                    </li>
                                @endif
                                @if (get_option('youtube_url'))
                                    <li class="list-inline-item">
                                        <a href="{{ get_option('youtube_url') }}" class="fab fa-youtube fa-fw"
                                            target="_blank"></a>
                                    </li>
                                @endif
                                @if (get_option('pinterest_url'))
                                    <li class="list-inline-item">
                                        <a href="{{ get_option('pinterest_url') }}" class="fab fa-pinterest fa-fw"
                                            target="_blank"></a>
                                    </li>
                                @endif
                                @if (get_option('instagram_url'))
                                    <li class="list-inline-item">
                                        <a href="{{ get_option('instagram_url') }}" class="fab fa-instagram fa-fw"
                                            target="_blank"></a>
                                    </li>
                                @endif
                                @if (get_option('vk_url'))
                                    <li class="list-inline-item">
                                        <a href="{{ get_option('vk_url') }}" class="fab fa-vk fa-fw"
                                            target="_blank"></a>
                                    </li>
                                @endif
                            </ul>
                        </div>

                    </div>
                </div>

                <div class="col-lg-4 offset-lg-4">
                    <div class="col-inner">
                        {!! \App\Sidebar::sidebarDisplay(get_style('footer1_sidebar')) !!}
                    </div>
                </div>

            </div>
        </div>


        <div class="copyright">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 text-left">
                        <div class="footer-menu">
                            <ul class="list-inline mb-0">
                                <li class="list-inline-item">
                                    <a href="{{ url('our_privacy') }}">
                                        <span> الخصوصية</span>
                                    </a>
                                </li>
                                <li class="list-inline-item ">
                                    <a href="{{ url('our_terms') }}">
                                        <span>شروط الاستخدام</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-8 text-right">
                            
                            جميع الحقوق محفوظة 
                            <script>
                                document.write(new Date().getFullYear());
                            </script>
                            &copy;
                            | هذا الموقع انشي بواسطة <i class="fas fa-heart"
                                style="color: #f00;"></i>  <a href="https://www.facebook.com/PovamiSoftware"
                                target="_blank" style="text-decoration: underline">Povami Software</a>

                    </div>
                </div>
            </div>
        </div>
    </footer>

    @include('_partials.js_vars')

    <script data-cfasync="false" src="{{ asset('assets/js/ads.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.4.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/owl.carousel@2.3.4/dist/owl.carousel.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/selection-sharer@1.1.0/dist/selection-sharer.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/ppowalowski/stickUp2@2.3.2/build/js/stickUp.min.js"></script>

    <script src="{{ asset('assets/js/app.js?v=' . APP_VERSION) }}"></script>

    {!! get_option('frontend_footer_code') !!}

    @stack('footer')

</body>

</html>
