<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if($roleName === 'admin')
                @include('dashboard._admin')
            @elseif($roleName === 'staff')
                @include('dashboard._staff')
            @elseif($roleName === 'manager')
                @include('dashboard._manager')
            @else
                @include('dashboard._staff')
            @endif

        </div>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const canvas = document.getElementById('borrowingsChart');
            if (!canvas) return;

            const ctx = canvas.getContext('2d');
            const months = {!! json_encode($months) !!};
            const counts = {!! json_encode($counts) !!};
            const roleName = '{{ $roleName }}';

            const isAllZero = counts.every(val => val === 0);
            if (isAllZero) {
                const container = canvas.parentElement;
                container.style.position = 'relative';
                
                const overlay = document.createElement('div');
                overlay.className = 'absolute inset-0 flex flex-col items-center justify-center bg-gray-50/20 rounded-xl backdrop-blur-[1px]';
                overlay.innerHTML = `
                    <svg class="w-12 h-12 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 002 2h2a2 2 0 002-2" />
                    </svg>
                    <span class="text-sm font-semibold text-gray-400">Belum ada data peminjaman</span>
                `;
                container.appendChild(overlay);
            }

            // Role-based chart gradient colors
            const roleColors = {
                'admin':   { primary: '#6366F1', rgba: 'rgba(99, 102, 241, 0.4)', rgbaEnd: 'rgba(99, 102, 241, 0.0)' },
                'staff':   { primary: '#10B981', rgba: 'rgba(16, 185, 129, 0.4)', rgbaEnd: 'rgba(16, 185, 129, 0.0)' },
                'manager': { primary: '#F59E0B', rgba: 'rgba(245, 158, 11, 0.4)', rgbaEnd: 'rgba(245, 158, 11, 0.0)' },
            };

            const colors = roleColors[roleName] || roleColors['admin'];

            const gradient = ctx.createLinearGradient(0, 0, 0, 300);
            gradient.addColorStop(0, colors.rgba);
            gradient.addColorStop(1, colors.rgbaEnd);

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: months,
                    datasets: [{
                        label: 'Jumlah Transaksi',
                        data: counts,
                        borderColor: colors.primary,
                        borderWidth: 3,
                        backgroundColor: gradient,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: colors.primary,
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 6,
                        pointHoverRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1e1b4b',
                            titleFont: { size: 13, weight: 'bold' },
                            bodyFont: { size: 12 },
                            padding: 12,
                            cornerRadius: 8,
                            displayColors: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(156, 163, 175, 0.1)' },
                            ticks: { color: '#9ca3af', font: { size: 11 }, precision: 0 }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { color: '#9ca3af', font: { size: 11 } }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
