<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>GraphDashboard</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#eef6f2] font-sans text-[#142824] antialiased">
        <main class="min-h-screen">
            <section class="mx-auto flex min-h-screen max-w-6xl flex-col justify-center gap-10 px-6 py-10 lg:flex-row lg:items-center lg:justify-between">
                <div class="max-w-2xl">
                    <p class="text-sm font-bold uppercase text-[#ff6b4a]">Sales analytics dashboard</p>
                    <h1 class="mt-4 text-4xl font-bold sm:text-5xl">GraphDashboard</h1>
                    <p class="mt-5 max-w-xl text-base leading-7 text-[#55706b]">
                        Monitor revenue momentum, order volume, channel mix, and regional contribution for the 2026 sales cycle.
                    </p>

                    @if (Route::has('login'))
                        <div class="mt-8 flex flex-wrap gap-3">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="rounded-lg bg-[#12343b] px-5 py-3 text-sm font-bold text-white transition hover:bg-[#1a4c45]">
                                    Open dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="rounded-lg bg-[#12343b] px-5 py-3 text-sm font-bold text-white transition hover:bg-[#1a4c45]">
                                    Log in
                                </a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="rounded-lg border border-[#b9d1c7] bg-white px-5 py-3 text-sm font-bold text-[#12343b] transition hover:border-[#ff6b4a]">
                                        Register
                                    </a>
                                @endif
                            @endauth
                        </div>
                    @endif

                    <div class="mt-5 grid max-w-md grid-cols-2 gap-3 text-sm">
                        <div class="rounded-lg border border-[#d9e7e0] bg-white px-4 py-3">
                            <p class="font-semibold text-[#55706b]">Demo email</p>
                            <p class="mt-1 font-bold">test@example.com</p>
                        </div>
                        <div class="rounded-lg border border-[#d9e7e0] bg-white px-4 py-3">
                            <p class="font-semibold text-[#55706b]">Password</p>
                            <p class="mt-1 font-bold">password</p>
                        </div>
                    </div>
                </div>

                <div class="w-full max-w-md rounded-lg border border-[#d9e7e0] bg-white p-5 shadow-sm">
                    <div class="mb-5 flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-[#55706b]">Preview</p>
                            <h2 class="text-xl font-bold">Revenue rhythm</h2>
                        </div>
                        <span class="rounded-full bg-[#fff3d1] px-3 py-1 text-sm font-bold text-[#765400]">Live app</span>
                    </div>

                    <div class="flex h-56 items-end gap-3 rounded-lg bg-[#f6faf8] p-4">
                        @foreach ([38, 48, 54, 52, 67, 72, 70, 79, 76, 88, 92, 100] as $height)
                            <div class="flex h-full flex-1 items-end">
                                <div class="w-full rounded-t-md bg-[#31b889]" style="height: {{ $height }}%"></div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-5 grid grid-cols-3 gap-3 text-center">
                        <div class="rounded-lg bg-[#eef6f2] p-3">
                            <p class="text-xs font-semibold uppercase text-[#55706b]">Stack</p>
                            <p class="mt-1 font-bold">Blade</p>
                        </div>
                        <div class="rounded-lg bg-[#fff3d1] p-3">
                            <p class="text-xs font-semibold uppercase text-[#765400]">Graph</p>
                            <p class="mt-1 font-bold">Chart.js</p>
                        </div>
                        <div class="rounded-lg bg-[#ffe9e2] p-3">
                            <p class="text-xs font-semibold uppercase text-[#8d301e]">Auth</p>
                            <p class="mt-1 font-bold">Auth</p>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </body>
</html>
