<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="Sistem Manajemen Inventaris Telkom - Platform premium untuk pengelolaan data barang dan transaksi peminjaman.">
        <meta name="author" content="Telkom Indonesia">

        <title>{{ isset($title) ? $title . ' - Si Inventaris Telkom' : 'Si Inventaris Telkom' }}</title>

        
        <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

        
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet" />

        
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        

        <style>
            .guest-grid-pattern {
                background-image:
                    linear-gradient(rgba(255,255,255,0.05) 1px, transparent 1px),
                    linear-gradient(90deg, rgba(255,255,255,0.05) 1px, transparent 1px);
                background-size: 40px 40px;
            }
            
            .guest-glow-orb {
                filter: blur(60px);
            }
            .guest-card-glass {
                backdrop-filter: blur(20px) saturate(180%);
                -webkit-backdrop-filter: blur(20px) saturate(180%);
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased" data-role="admin">
        <div class="min-h-screen flex flex-col lg:flex-row">

            
            <div class="relative hidden lg:flex lg:w-[48%] xl:w-[45%] flex-col justify-between overflow-hidden bg-gradient-to-br from-telkomsel-500 via-telkomsel-600 to-telkomsel-700">

                
                <div class="absolute inset-0 guest-grid-pattern"></div>

                
                <div class="absolute top-20 left-10 w-64 h-64 rounded-full bg-telkomsel-gold-500/20 guest-glow-orb animate-float"></div>
                <div class="absolute bottom-32 right-16 w-48 h-48 rounded-full bg-telkomsel-400/30 guest-glow-orb animate-float-delayed"></div>
                <div class="absolute top-1/2 left-1/3 w-32 h-32 rounded-full bg-white/10 guest-glow-orb animate-pulse-glow"></div>

                
                <div class="relative z-10 flex flex-col justify-center flex-1 px-12 xl:px-16">
                    
                    <div class="animate-slide-in-left">
                        <div class="flex items-center gap-4 mb-8">
                            <div class="p-3 bg-white/15 rounded-2xl backdrop-blur-sm border border-white/20">
                                <x-application-logo class="w-12 h-12" />
                            </div>
                            <div>
                                <h1 class="text-2xl xl:text-3xl font-extrabold text-white tracking-tight">Si Inventaris</h1>
                                <p class="text-sm font-semibold text-telkomsel-gold-300 tracking-wider uppercase">Telkom Indonesia</p>
                            </div>
                        </div>

                        
                        <div class="guest-card-glass bg-white/10 border border-white/20 rounded-3xl p-8 max-w-md">
                            <h2 class="text-xl xl:text-2xl font-bold text-white leading-snug mb-3">
                                Sistem Inventaris Modern
                                <span class="block text-telkomsel-gold-300">untuk Telkomsel</span>
                            </h2>
                            <p class="text-white/70 text-sm leading-relaxed">
                                Platform premium untuk pengelolaan data barang, peminjaman aset, dan monitoring inventaris secara real-time.
                            </p>
                        </div>

                        
                        <div class="mt-8 space-y-3">
                            <div class="flex items-center gap-3 text-white/80">
                                <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-telkomsel-gold-500/20 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-telkomsel-gold-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <span class="text-sm font-medium">Manajemen barang & kategori</span>
                            </div>
                            <div class="flex items-center gap-3 text-white/80">
                                <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-telkomsel-gold-500/20 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-telkomsel-gold-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <span class="text-sm font-medium">Tracking peminjaman real-time</span>
                            </div>
                            <div class="flex items-center gap-3 text-white/80">
                                <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-telkomsel-gold-500/20 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-telkomsel-gold-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <span class="text-sm font-medium">Laporan & export data</span>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="relative z-10 px-12 xl:px-16 pb-8">
                    <div class="flex items-center gap-2 text-white/40 text-xs">
                        <span>© {{ date('Y') }} Telkomsel</span>
                        <span>·</span>
                        <span>Si Inventaris Telkom</span>
                    </div>
                </div>
            </div>

            
            <div class="flex-1 flex flex-col justify-center items-center px-6 py-12 sm:px-12 bg-gray-50 relative overflow-hidden">

                
                <div class="absolute top-0 right-0 w-96 h-96 bg-telkomsel-500/5 rounded-full -translate-y-1/2 translate-x-1/2 blur-3xl"></div>
                <div class="absolute bottom-0 left-0 w-72 h-72 bg-telkomsel-gold-500/5 rounded-full translate-y-1/2 -translate-x-1/2 blur-3xl"></div>

                
                <div class="lg:hidden mb-8 text-center animate-fade-in-up">
                    <div class="inline-flex items-center gap-3 mb-4 px-5 py-3 bg-gradient-to-r from-telkomsel-500 to-telkomsel-600 rounded-2xl shadow-lg shadow-telkomsel-500/25">
                        <x-application-logo class="w-8 h-8" />
                        <span class="text-lg font-bold text-white">Si Inventaris Telkom</span>
                    </div>
                </div>

                
                <div class="relative z-10 w-full sm:max-w-md animate-fade-in-up">
                    <div class="bg-white guest-card-glass shadow-2xl shadow-gray-200/50 border border-gray-100 rounded-3xl px-8 py-10 sm:px-10">
                        {{ $slot }}
                    </div>

                    
                    <div class="lg:hidden mt-8 text-center text-xs text-gray-400">
                        <span>© {{ date('Y') }} Telkomsel · Si Inventaris Telkom</span>
                    </div>
                </div>
            </div>
        </div>

        
        <script>
            document.addEventListener('submit', (e) => {
                const form = e.target;
                if (form.checkValidity && !form.checkValidity()) return;
                
                const buttons = form.querySelectorAll('button[type="submit"]');
                buttons.forEach(button => {
                    button.disabled = true;
                    button.classList.add('opacity-75', 'cursor-not-allowed');
                    
                    const hasSpinner = !button.querySelector('.animate-spin');
                    if (hasSpinner && button.innerText.trim().length > 0) {
                        button.innerHTML = `
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-current inline-block align-text-bottom" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span>${button.innerText}</span>
                        `;
                    }
                });
            });
        </script>
    </body>
</html>
