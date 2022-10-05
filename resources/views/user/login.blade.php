<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <meta name="author" content="David Grzyb">
    <meta name="description" content="">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">

</head>

<body class="bg-white min-h-screen pt-12 md:pt-10 pb-6 px-2 md:px-0" style="font-family:'Lato',sans-serif;">
    <header class="max-w-lg mx-auto">
        <a href="#">
            <h1 class="text-2xl lg:text-4xl font-bold text-blue-800 text-center">DISKOMINFO</h1>
        </a>
    </header>

    <main class=" max-w-lg mx-auto p-8 md:p-12 my-10 rounded-lg shadow-2xl">
        <section>
            <!-- <h3 class="font-bold text-2xl">Halaman Login</h3> -->
            <p class="text-gray-600 pt-2">Silahkan login menggunakan akunmu.</p>
        </section>
        <section class="mt-10">
            <form class="flex flex-col" method="POST" action="{{ route('user.login') }}">
                <div class="mb-6 pt-3 rounded bg-gray-100">
                    <label class="block text-gray-700 text-sm font-bold mb-2 ml-3" for="username">Username</label>
                    <input name="username" type="text" id="username" class="bg-gray-200 rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-300 focus:border-cyan-600 transition duration-500 px-3 pb-3">
                </div>
                <div class="mb-6 pt-3 rounded bg-gray-100">
                    <label class="block text-gray-700 text-sm font-bold mb-2 ml-3" for="password">Password</label>
                    <input name="password" type="password" id="password" class="bg-gray-200 rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-300 focus:border-cyan-600 transition duration-500 px-3 pb-3">
                </div>
                <button class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 rounded shadow-lg hover:shadow-xl transition duration-200" type="submit">LOGIN</button>
            </form>
            <div class="max-w-lg mx-auto text-center mt-6">
                <p>Belum punya akun? <a href="{{ route('user.form.daftar') }}" class="text-blue-700 font-bold hover:underline">Daftar</a>.</p>
            </div>
            <div class="text-gray-700 mt-6 text-center">
                <a class="no-underline text-blue-700 hover:underline" href="{{ route('beranda') }}">
                    Beranda
                </a>
            </div>
        </section>
    </main>



    <!-- <footer class="max-w-lg mx-auto flex justify-center text-white">
        <a href="#" class="hover:underline">Contact</a>
        <span class="mx-3">•</span>
        <a href="#" class="hover:underline">Privacy</a>
    </footer> -->
</body>

</html>