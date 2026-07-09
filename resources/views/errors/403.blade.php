<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Akses Ditolak - 403</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])

    </head>
    <body class="font-sans antialiased bg-gray-50 text-gray-900">
        <div class="min-h-screen flex flex-col items-center justify-center p-6 text-center">
            <div class="max-w-md w-full space-y-6">
                
                <div class="mx-auto w-24 h-24 mb-2 relative">
                    <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16 3 L2 10 L16 17 L30 10 Z" fill="#F97316" />
                        <path d="M2 10 V22 L16 29 V17 Z" fill="#EA580C" opacity="0.9" />
                        <path d="M16 17 L30 10 V22 L16 29 Z" fill="#C2410C" opacity="0.85" />
                    </svg>
                    
                    <div class="absolute -bottom-1 -right-1 w-8 h-8 rounded-full bg-rose-500 border-2 border-white flex items-center justify-center text-white shadow-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </div>
                </div>

                
                <h1 class="text-8xl font-black tracking-widest text-transparent bg-clip-text bg-gradient-to-r from-orange-500 to-rose-600">403</h1>

                
                <div class="space-y-2">
                    <h2 class="text-2xl font-bold tracking-tight">Akses Ditolak</h2>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        Anda tidak memiliki hak akses (izin) yang diperlukan untuk membuka halaman atau memproses aksi ini.
                    </p>
                </div>

                
                <div class="pt-4">
                    <a href="/dashboard" class="inline-flex items-center justify-center px-6 py-3 bg-accent-600 hover:bg-accent-700 text-white text-sm font-semibold rounded-xl shadow-lg shadow-accent-500/20 hover:shadow-accent-500/30 transition duration-150">
                        Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </div>
    </body>
</html>
