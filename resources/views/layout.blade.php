<!DOCTYPE html>
<html>
<head>

  <title>Fusion -HOSTEL COMPLAINTS</title>

  <!--Import Google Icon Font-->
  <!--      <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">-->
  <!--Import materialize.css-->
  {!! MaterializeCSS::include_full() !!}

  <script src="https://use.fontawesome.com/5fd0aa1ca7.js"></script>
  <!-- <link rel="stylesheet" href="{{ asset ('fonts/font-awesome-4.6.3/css/font-awesome.min.css') }}"> -->

  <!-- <link type="text/css" rel="stylesheet" href="{{ asset('css/materialize.min.css') }}"  media="screen,projection"/> -->

  <link href="{{ asset('css/fusion_style.css') }}" type="text/css" rel="stylesheet">

  <link href="{{ asset('css/hostel_complaint_style.css') }}" type="text/css" rel="stylesheet">

  <!--Let browser know website is optimized for mobile-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>

<body>
   <header>
            <nav>
                <div class="nav-wrapper">
                  <a href="#!" class="brand-logo">Fusion</a>
                  <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
                  <ul class="right hide-on-med-and-down">
                    <li><a href="#">Link</a></li>
                    <li><a href="#">Link</a></li>
                    <li><a href="/logout">Logout</a></li>
                  </ul>
                  <ul class="side-nav" id="mobile-demo">
                    <li><a href="#">Link</a></li>
                    <li><a href="#">Link</a></li>
                    <li><a href="#">Link</a></li>
                  </ul>
                </div>
            </nav>
        </header>
        
        <div class="sidebar">
            <ul id="slide-out" class="side-nav fixed">
                <li><a href="#!" class="waves-effect">First Link</a></li>
                <li><a href="#!" class="waves-effect">Second Link</a></li>
                <li><div class="divider"></div></li>
                <li><a class="subheader">Subheader</a></li>
                <li><a class="waves-effect" href="#!">Third Link</a></li>
            </ul>
        </div>

  @yield('content')
  
</body>
</html>