<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.min.js" integrity="sha256-XF29CBwU1MWLaGEnsELogU6Y6rcc5nCkhhx89nFMIDQ=" crossorigin="anonymous"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.js"></script>
    <link href="https://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.css" rel="stylesheet" />

</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    <nav id="header" class="bg-white fixed w-full z-10 top-0 shadow">
        <div class="w-full container mx-auto flex flex-wrap items-center mt-0 pt-3 pb-3 md:pb-0">
            <div class="w-1/2 pl-2 md:pl-0">
                <a class="toggleColour text-blue-800 no-underline hover:no-underline font-bold text-2xl lg:text-2xl" href="#">
                    <img class="h-7 fill-current inline" src="{{ asset('img/logo1.png') }}">
                    DISKOMINFO
                </a>
            </div>
            <div class="w-1/2 pr-0">
                <div class="relative inline-block float-right">

                    <div class="relative text-sm">
                        <button id="userButton" class="flex items-center focus:outline-none mr-3">
                            <span class="fas fa-user w-8 h-8 rounded-full mr-4" alt="Avatar of User"></span> <span class="hidden md:inline-block">Hi, Tamu </span>
                            <svg class="pl-2 h-2" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 129 129" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 129 129">
                                <g>
                                    <path d="m121.3,34.6c-1.6-1.6-4.2-1.6-5.8,0l-51,51.1-51.1-51.1c-1.6-1.6-4.2-1.6-5.8,0-1.6,1.6-1.6,4.2 0,5.8l53.9,53.9c0.8,0.8 1.8,1.2 2.9,1.2 1,0 2.1-0.4 2.9-1.2l53.9-53.9c1.7-1.6 1.7-4.2 0.1-5.8z" />
                                </g>
                            </svg>
                        </button>
                        <div id="userMenu" class="bg-white rounded shadow-md absolute mt-12 top-0 right-0 min-w-full overflow-auto z-30 invisible">
                            <ul class="list-reset">
                                <li><a href="{{ route('tamu.profil') }}" class="px-4 py-2 block text-gray-900 hover:bg-gray-400 no-underline hover:no-underline">Profil</a></li>
                                <li><a href="{{ route('tamu.akun') }}" class="px-4 py-2 block text-gray-900 hover:bg-gray-400 no-underline hover:no-underline">Akun</a></li>
                                <li>
                                    <hr class="border-t mx-2 border-gray-400">
                                </li>
                                <li><a href="{{ route('user.logout') }}" class="px-4 py-2 block text-gray-900 hover:bg-gray-400 no-underline hover:no-underline">Logout</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="block lg:hidden pr-4">
                        <button id="nav-toggle" class="flex items-center px-3 py-2 border rounded text-gray-500 border-gray-600 hover:text-gray-900 hover:border-teal-500 appearance-none focus:outline-none">
                            <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <title>Menu</title>
                                <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div class="w-full flex-grow lg:items-center lg:w-auto hidden lg:block mt-3 lg:mt-1 bg-white z-20" id="nav-content">
                <ul class="list-reset lg:flex flex-1 items-center px-4 md:px-0">
                    <li class="mr-6 my-2 md:my-0">
                        <a href="{{ route('tamu.index') }}" class="block py-1 md:py-3 pl-1 align-middle {{ request()->is('tamu') ? 'text-blue-600 border-blue-600 hover:border-blue-600 hover:text-blue-600 ' : 'text-gray-500 border-white hover:border-blue-600 hover:text-blue-600' }} no-underline border-b-2 ">
                            <i class="fas fa-home fa-fw mr-3 {{ request()->is('tamu') ? 'text-blue-600':'' }}"></i><span class="pb-1 md:pb-0 text-sm">Dasbor</span>
                        </a>
                    </li>
                    <li class="mr-6 my-2 md:my-0">
                        <a href="{{ route('tamu.permintaan.buat') }}" class="block py-1 md:py-3 pl-1 align-middle {{ request()->is('tamu/permintaan/buat') ? 'text-blue-600 border-blue-600 hover:border-blue-600 hover:text-blue-600 ' : 'text-gray-500 border-white hover:border-blue-600 hover:text-blue-600' }} no-underline border-b-2 ">
                            <i class="fas fa-plus fa-fw mr-3 {{ request()->is('tamu/permintaan/buat') ? 'text-blue-600':'' }}"></i><span class="pb-1 md:pb-0 text-sm">Buat Permintaan</span>
                        </a>
                    </li>
                    <li class="mr-6 my-2 md:my-0">
                        <a href="{{ route('tamu.riwayat.permintaan') }}" class="block py-1 md:py-3 pl-1 align-middle {{ request()->is('tamu/riwayat/permintaan') ? 'text-blue-600 border-blue-600 hover:border-blue-600 hover:text-blue-600 ' : 'text-gray-500 border-white hover:border-blue-600 hover:text-blue-600' }} no-underline border-b-2 ">
                            <i class="fas fa-tasks fa-fw mr-3 {{ request()->is('tamu/riwayat/permintaan') ? 'text-blue-600':'' }}"></i><span class="pb-1 md:pb-0 text-sm">Riwayat Permintaan</span>
                        </a>
                    </li>
                    <li class="mr-6 my-2 md:my-0">
                        <a href="{{ route('tamu.riwayat.bertamu') }}" class="block py-1 md:py-3 pl-1 align-middle {{ request()->is('tamu/riwayat/bertamu') ? 'text-blue-600 border-blue-600 hover:border-blue-600 hover:text-blue-600 ' : 'text-gray-500 border-white hover:border-blue-600 hover:text-blue-600' }} no-underline border-b-2 ">
                            <i class="fas fa-book fa-fw mr-3 {{ request()->is('tamu/riwayat/bertamu') ? 'text-blue-600':'' }}"></i><span class="pb-1 md:pb-0 text-sm">Riwayat Bertamu</span>
                        </a>
                    </li>
                </ul>

                <!-- <div class="relative pull-right pl-4 pr-4 md:pr-0">
                    <input type="search" placeholder="Search" class="w-full bg-gray-100 text-sm text-gray-800 transition border focus:outline-none focus:border-gray-700 rounded py-1 px-2 pl-10 appearance-none leading-normal">
                    <div class="absolute search-icon" style="top: 0.375rem;left: 1.75rem;">
                        <svg class="fill-current pointer-events-none text-gray-800 w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M12.9 14.32a8 8 0 1 1 1.41-1.41l5.35 5.33-1.42 1.42-5.33-5.34zM8 14A6 6 0 1 0 8 2a6 6 0 0 0 0 12z"></path>
                        </svg>
                    </div>
                </div> -->

            </div>
        </div>
    </nav>
    <div class="flex flex-col h-screen justify-between">
        @yield('content')

        <footer class="bg-white border-t border-gray-400 shadow text-center py-6 font-bold relative bottom-0">
            Tamu
        </footer>
    </div>
    <script>
        /*Toggle dropdown list*/
        /*https://gist.github.com/slavapas/593e8e50cf4cc16ac972afcbad4f70c8*/

        var userMenuDiv = document.getElementById("userMenu");
        var userMenu = document.getElementById("userButton");

        var navMenuDiv = document.getElementById("nav-content");
        var navMenu = document.getElementById("nav-toggle");

        document.onclick = check;

        function check(e) {
            var target = (e && e.target) || (event && event.srcElement);

            //User Menu
            if (!checkParent(target, userMenuDiv)) {
                // click NOT on the menu
                if (checkParent(target, userMenu)) {
                    // click on the link
                    if (userMenuDiv.classList.contains("invisible")) {
                        userMenuDiv.classList.remove("invisible");
                    } else {
                        userMenuDiv.classList.add("invisible");
                    }
                } else {
                    // click both outside link and outside menu, hide menu
                    userMenuDiv.classList.add("invisible");
                }
            }

            //Nav Menu
            if (!checkParent(target, navMenuDiv)) {
                // click NOT on the menu
                if (checkParent(target, navMenu)) {
                    // click on the link
                    if (navMenuDiv.classList.contains("hidden")) {
                        navMenuDiv.classList.remove("hidden");
                    } else {
                        navMenuDiv.classList.add("hidden");
                    }
                } else {
                    // click both outside link and outside menu, hide menu
                    navMenuDiv.classList.add("hidden");
                }
            }

        }

        function checkParent(t, elm) {
            while (t.parentNode) {
                if (t == elm) {
                    return true;
                }
                t = t.parentNode;
            }
            return false;
        }
    </script>

</body>

</html>