<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>
        @if(!empty($page_title))
            {{ remove_junk($page_title) }}
        @elseif(!empty($user))
            {{ ucfirst($user->name) }}
        @else
            Inventory Management System
        @endif
    </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>
<body>
    @if(auth()->check())
        @php $user = auth()->user(); @endphp
        <header id="header">
            <div class="logo pull-left">
                <img src="{{ asset('lib/images/whitelogo.png') }}" alt="Francheska's IMS Logo" />
            </div>
            <div class="header-content">
            <div class="header-date pull-left">
    <strong>{{ now()->timezone('Asia/Manila')->format('F j, Y, g:i a') }}</strong></div>
                <div class="pull-right clearfix">
                    <ul class="info-menu list-inline list-unstyled">
                        <li class="profile">
                            <a href="#" data-toggle="dropdown" class="toggle" aria-expanded="false">
                          <img src="{{ $user->image ? asset('lib/images/' . $user->image) : asset('lib/images/whitelogo.png') }}" alt="user-image" class="img-circle img-inline" style="width: 40px; height: 40px;">

                                <span>{{ ucfirst($user->name) }} <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="last">
                                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="glyphicon glyphicon-off"></i> Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </header>
        <div class="sidebar">
            @if($user->user_level === 1)
                <!-- admin menu -->
                @include('admin.admin_menu')
            @elseif($user->user_level === 2)
                <!-- Special user -->
                @include('special_menu')
            @elseif($user->user_level === 3)
                <!-- User menu -->
                @include('user_menu')
            @endif
        </div>
    @endif

    <div class="page">
        <div class="container-fluid">
            <!-- Content goes here -->
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
</body>
</html>
