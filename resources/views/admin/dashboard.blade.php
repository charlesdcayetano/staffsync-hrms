@extends('layouts.admin')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="max-w-7xl mx-auto space-y-10">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-gray-900 tracking-tighter">Dashboard</h1>
            <p class="text-gray-400 font-medium mt-1">Real-time overview of organization's performance</p>
        </div>
        <div class="flex gap-2">
            <button class="bg-white border border-gray-100 px-5 py-2.5 rounded-2xl text-[10px] font-black uppercase tracking-widest text-gray-500 hover:bg-gray-50 transition">Download Report</button>
            <button class="bg-gray-900 text-white px-5 py-2.5 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:shadow-xl hover:shadow-gray-200 transition">System Health</button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        @foreach($stats as $key => $value)
        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-50 group hover:border-gray-900 transition-all">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ str_replace('_', ' ', $key) }}</p>
            <p class="text-3xl font-bold text-gray-900 mt-2 tracking-tight">
                {{ is_numeric($value) && $key == 'total_payroll' ? '₱' . number_format($value, 0) : $value }}
            </p>
        </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 bg-white rounded-[2.5rem] p-8 border border-gray-50 shadow-sm">
            <div class="flex items-center justify-between mb-8">
                <h3 class="font-black text-sm uppercase tracking-widest text-gray-900">Payroll Expenditure</h3>
                <select class="text-xs font-bold border-none bg-gray-50 rounded-lg px-3 py-1 outline-none">
                    <option>Last 6 Months</option>
                    <option>Year to Date</option>
                </select>
            </div>
            <div class="h-[300px]">
                <canvas id="payrollChart"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-[2.5rem] p-8 border border-gray-50 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <h3 class="font-black text-sm uppercase tracking-widest text-gray-900">Attendance</h3>
                <span class="text-xs font-bold text-gray-400">{{ now()->format('F Y') }}</span>
            </div>
            <div class="grid grid-cols-7 gap-2 text-center text-[10px] font-black text-gray-300 uppercase mb-4">
                <span>M</span><span>T</span><span>W</span><span>T</span><span>F</span><span>S</span><span>S</span>
            </div>
            <div class="grid grid-cols-7 gap-2">
                @for($i = 1; $i <= 31; $i++)
                    <div class="aspect-square flex items-center justify-center rounded-xl text-xs font-bold 
                        {{ in_array($i, [5, 12, 19, 26]) ? 'bg-red-50 text-red-400' : 'bg-gray-50 text-gray-400' }}
                        {{ $i == now()->day ? 'ring-2 ring-gray-900 !bg-white !text-gray-900' : '' }}">
                        {{ $i }}
                    </div>
                @endfor
            </div>
            <div class="mt-6 space-y-2">
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 rounded-full bg-red-400"></div>
                    <span class="text-[10px] font-bold text-gray-400 uppercase">Hospital Holidays</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 rounded-full bg-gray-900"></div>
                    <span class="text-[10px] font-bold text-gray-400 uppercase">Today</span>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 pb-10">
        <div class="lg:col-span-2 bg-white rounded-[2.5rem] border border-gray-50 overflow-hidden shadow-sm">
            <div class="px-8 py-6 border-b border-gray-50 flex justify-between items-center">
                <h3 class="font-black text-sm uppercase tracking-widest text-gray-900">Live Activity Feed</h3>
                <span class="text-[10px] font-bold text-blue-500 bg-blue-50 px-3 py-1 rounded-full animate-pulse">Real-time</span>
            </div>
            <div class="p-8 space-y-6 max-h-[400px] overflow-y-auto">
                @foreach($recentLeaves as $leave)
                <div class="flex items-center gap-4">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($leave->employee->first_name) }}&background=f3f4f6&color=111827" class="w-10 h-10 rounded-xl">
                    <div class="flex-1">
                        <p class="text-sm font-bold text-gray-900">{{ $leave->employee->first_name }} <span class="text-gray-400 font-medium">requested leave</span></p>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter">{{ $leave->created_at->diffForHumans() }}</p>
                    </div>
                    <span class="text-[10px] font-black uppercase px-3 py-1 rounded-lg bg-amber-50 text-amber-500">{{ $leave->status }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <div class="bg-gray-900 rounded-[2.5rem] p-8 text-white relative overflow-hidden shadow-2xl">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-white/10 rounded-full blur-2xl"></div>
            <h3 class="font-black text-sm uppercase tracking-widest opacity-50 mb-8">Celebrations</h3>
            <div class="space-y-6">
                @foreach($birthdays as $bday)
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-lg">🎁</div>
                    <div>
                        <p class="text-sm font-bold">{{ $bday->first_name }} {{ $bday->last_name }}</p>
                        <p class="text-[10px] font-black text-gray-400 uppercase">{{ \Carbon\Carbon::parse($bday->date_of_birth)->format('M d') }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
    const ctx = document.getElementById('payrollChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($chartLabels),
            datasets: [{
                label: 'Monthly Payroll',
                data: @json($chartData),
                borderColor: '#111827',
                borderWidth: 4,
                pointBackgroundColor: '#111827',
                pointRadius: 0,
                pointHoverRadius: 6,
                tension: 0.4,
                fill: true,
                backgroundColor: (context) => {
                    const bgColor = ['rgba(17, 24, 39, 0.05)', 'rgba(17, 24, 39, 0)'];
                    const chart = context.chart;
                    const {ctx, chartArea} = chart;
                    if (!chartArea) return null;
                    const gradient = ctx.createLinearGradient(0, chartArea.top, 0, chartArea.bottom);
                    gradient.addColorStop(0, bgColor[0]);
                    gradient.addColorStop(1, bgColor[1]);
                    return gradient;
                }
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { display: false },
                x: { grid: { display: false }, ticks: { font: { weight: 'bold', size: 10 } } }
            }
        }
    });
</script>
@endsection