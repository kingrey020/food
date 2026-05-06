<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Command Center | CraveBites</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Courier+Prime&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #0f172a; }
        .glass { background: rgba(255, 255, 255, 0.03); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.05); }
        .card-glow:hover { box-shadow: 0 0 30px rgba(249, 115, 22, 0.15); transition: all 0.4s ease; }
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-thumb { background: #334155; border-radius: 10px; }
        
        #receipt-canvas { display: none; }

        @media print {
            body > *:not(#receipt-canvas) { display: none !important; }
            #receipt-canvas {
                display: block !important;
                position: absolute;
                left: 0;
                top: 0;
                width: 80mm;
                padding: 4mm;
                background: white !important;
                color: black !important;
                font-family: 'Courier Prime', monospace !important;
                line-height: 1.2;
            }
            body { background: white !important; }
            @page { size: auto; margin: 0mm; }
        }
    </style>
</head>
<body class="text-slate-200 flex h-screen overflow-hidden">

    <!-- SIDEBAR -->
    <aside class="w-72 bg-slate-950 border-r border-slate-800 flex flex-col h-full z-20 no-print">
        <div class="p-8">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-orange-500 rounded-xl flex items-center justify-center shadow-lg shadow-orange-500/40">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <h1 class="text-xl font-extrabold tracking-tighter text-white">CRAVE<span class="text-orange-500">BITES</span></h1>
            </div>
        </div>
        
        <nav class="flex-1 px-4 space-y-2 mt-4">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-4 {{ !request('status') ? 'bg-orange-500/10 text-orange-500 border-orange-500/20' : 'text-slate-400' }} px-6 py-4 rounded-2xl font-bold transition-all border border-transparent">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                Insights
            </a>
            <a href="{{ route('admin.menu') }}" class="flex items-center gap-4 text-slate-400 hover:text-white hover:bg-white/5 px-6 py-4 rounded-2xl font-bold transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                Menu Lab
            </a>
        </nav>

        <div class="p-6">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-4 text-slate-500 hover:text-red-400 px-6 py-4 font-bold transition-all rounded-2xl text-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    End Session
                </button>
            </form>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 flex flex-col h-full overflow-y-auto relative no-print">
        <header class="p-10 flex justify-between items-end">
            <div>
                <p class="text-orange-500 font-black text-xs uppercase tracking-[0.3em] mb-2">Live Control</p>
                <h2 class="text-4xl font-black text-white tracking-tighter">Command Center</h2>
            </div>
            <div class="flex items-center gap-4 glass px-6 py-3 rounded-2xl">
                <span class="flex h-3 w-3 relative">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                </span>
                <p class="text-sm font-bold text-slate-300">Live Traffic: Online</p>
            </div>
        </header>

        <div class="px-10 pb-10 space-y-10">
            <!-- STAT CARDS -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="glass p-8 rounded-[2.5rem] card-glow relative overflow-hidden">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-3">Gross Volume</p>
                    <h3 class="text-3xl font-black text-white">₱{{ number_format($totalSales, 2) }}</h3>
                </div>
                <div class="glass p-8 rounded-[2.5rem] card-glow">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-3">Total Fleet</p>
                    <h3 class="text-3xl font-black text-white">{{ $totalOrders }}</h3>
                </div>
                <div class="glass p-8 rounded-[2.5rem] card-glow border-orange-500/20 bg-orange-500/[0.02]">
                    <p class="text-xs font-bold text-orange-500 uppercase tracking-widest mb-3">In Queue</p>
                    <h3 class="text-3xl font-black text-orange-500">{{ $pendingOrders }}</h3>
                </div>
                <div class="glass p-8 rounded-[2.5rem] card-glow">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-3">Fulfilled</p>
                    <h3 class="text-3xl font-black text-emerald-400">{{ $completedOrders }}</h3>
                </div>
            </div>

            <!-- ORDER STREAM -->
            <div class="space-y-6">
                <div class="flex items-center justify-between px-4">
                    <div class="flex items-center gap-6">
                        <h3 class="text-xl font-bold text-white tracking-tight">Incoming Stream</h3>
                        <div class="flex bg-slate-900 p-1 rounded-xl border border-slate-800 text-[10px] font-black uppercase tracking-widest">
                            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded-lg transition-all {{ !request('status') ? 'bg-orange-500 text-white' : 'text-slate-500' }}">All</a>
                            <a href="{{ route('admin.dashboard', ['status' => 'Pending']) }}" class="px-4 py-2 rounded-lg transition-all {{ request('status') == 'Pending' ? 'bg-orange-500 text-white' : 'text-slate-500' }}">Pending</a>
                            <a href="{{ route('admin.dashboard', ['status' => 'Done']) }}" class="px-4 py-2 rounded-lg transition-all {{ request('status') == 'Done' ? 'bg-orange-500 text-white' : 'text-slate-500' }}">Done</a>
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    @forelse($orders as $order)
                    <div class="glass p-6 rounded-[2.5rem] flex flex-wrap lg:flex-nowrap items-center justify-between gap-8 hover:bg-white/[0.04] transition-all group relative">
                        
                        <!-- Log ID -->
                        <div class="w-32">
                            <p class="text-[10px] font-black text-slate-500 uppercase mb-1">Log ID</p>
                            <p class="font-black text-white text-lg">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</p>
                            <p class="text-[10px] font-bold text-orange-500 uppercase">{{ $order->created_at->diffForHumans() }}</p>
                        </div>

                        <!-- Intelligence -->
                        <div class="flex-1">
                            <p class="text-[10px] font-black text-slate-500 uppercase mb-1">Customer</p>
                            <p class="font-black text-white text-xl truncate">{{ $order->customer_name }}</p>
                        </div>

                        <!-- Payload -->
                        <div class="w-72">
                            <p class="text-[10px] font-black text-slate-500 uppercase mb-1">Payload</p>
                            <div class="flex flex-wrap gap-1">
                                @foreach($order->items as $item)
                                    <span class="bg-slate-800 text-slate-300 px-2 py-1 rounded-lg text-[10px] font-bold border border-white/5">
                                        {{ $item->quantity }}x {{ $item->item_name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        <!-- Price -->
                        <div class="w-28 text-center border-l border-white/5">
                            <p class="text-[10px] font-black text-slate-500 uppercase mb-1">Total</p>
                            <p class="text-xl font-black text-white">₱{{ number_format($order->total_amount, 0) }}</p>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center gap-2">
                            @if($order->status == 'Pending')
                                <form action="{{ route('admin.order.complete', $order->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-emerald-500 text-white px-5 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-emerald-400 transition-all shadow-lg shadow-emerald-500/20 active:scale-95">
                                        Fulfill
                                    </button>
                                </form>
                            @else
                                <div class="px-4 text-emerald-400 font-black text-[10px] uppercase tracking-widest flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                    Deployed
                                </div>
                            @endif

                            <button onclick='generateThermalReceipt({!! json_encode($order) !!}, {!! json_encode($order->items) !!})' class="p-3 glass rounded-xl text-slate-500 hover:text-white transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                            </button>

                            <form action="{{ route('admin.order.delete', $order->id) }}" method="POST" onsubmit="return confirm('Erase permanently?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-3 glass rounded-xl text-slate-600 hover:text-red-500 hover:bg-red-500/10 transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    @empty
                        <div class="glass p-20 rounded-[3rem] text-center opacity-30">
                            <p class="font-black uppercase tracking-widest text-sm text-slate-500">Silence in the stream</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </main>

    <!-- HIDDEN RECEIPT CANVAS -->
    <div id="receipt-canvas"></div>

    <!-- INJECTED RECEIPT SCRIPT -->
    <script>
        function generateThermalReceipt(order, items) {
            const canvas = document.getElementById('receipt-canvas');
            
            let itemsHtml = '';
            items.forEach(i => {
                itemsHtml += `
                <div style="display: flex; justify-content: space-between; margin-bottom: 2px; font-size: 12px;">
                    <span>${i.quantity}x ${i.item_name}</span>
                    <span>₱${(i.price * i.quantity).toLocaleString()}</span>
                </div>`;
            });

            canvas.innerHTML = `
                <div style="text-align: center; border-bottom: 1px dashed #000; padding-bottom: 8px; margin-bottom: 8px;">
                    <h2 style="margin: 0; font-size: 20px;">CRAVEBITES</h2>
                    <p style="margin: 0; font-size: 10px; font-weight: bold; text-transform: uppercase;">Command Center Order</p>
                </div>
                <div style="font-size: 11px; margin-bottom: 8px; border-bottom: 1px dashed #000; padding-bottom: 5px;">
                    <div>ORD: #${String(order.id).padStart(5, '0')}</div>
                    <div>DATE: ${new Date().toLocaleString()}</div>
                    <div>STAT: ${order.status.toUpperCase()}</div>
                </div>
                <div style="margin-bottom: 8px;">
                    ${itemsHtml}
                </div>
                <div style="border-top: 1px solid #000; padding-top: 5px; display: flex; justify-content: space-between; font-weight: bold; font-size: 16px; border-bottom: 1px dashed #000; padding-bottom: 5px; margin-bottom: 10px;">
                    <span>TOTAL</span>
                    <span>₱${parseFloat(order.total_amount).toLocaleString()}</span>
                </div>
                <div style="font-size: 11px; border: 1px solid #000; padding: 8px; text-align: center;">
                    <div style="font-weight: bold; font-size: 14px; margin-bottom: 2px;">${order.customer_name}</div>
                    <div style="font-size: 10px;">PICK-UP / DINE-IN</div>
                </div>
                <div style="text-align: center; margin-top: 20px; font-size: 11px; font-weight: bold;">
                    --- THANK YOU! ---
                </div>
            `;

            window.print();
        }
    </script>
</body>
</html>
