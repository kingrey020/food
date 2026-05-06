<x-app-layout>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #F8FAFC; }
        .order-card:hover { transform: translateY(-5px); transition: all 0.3s ease; }
    </style>

    <div class="py-10">
        <div class="max-w-[1600px] mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- HEADER SECTION -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 px-4">
                <div>
                    <h2 class="text-3xl font-black text-slate-800 tracking-tight">Orders Command Center</h2>
                    <p class="text-slate-500 font-medium">Manage live deliveries and restaurant performance.</p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="bg-white p-2 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-3 px-4">
                        <span class="flex h-3 w-3 relative">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                        </span>
                        <span class="text-sm font-bold text-slate-600 uppercase tracking-widest">System Live</span>
                    </div>
                </div>
            </div>

            <!-- STATS GRID -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 px-4">
                <!-- Total Revenue -->
                <div class="bg-slate-900 p-8 rounded-[2rem] shadow-2xl relative overflow-hidden group">
                    <div class="absolute right-0 top-0 p-4 opacity-10">
                        <svg class="w-20 h-20 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2"></path></svg>
                    </div>
                    <p class="text-slate-400 text-xs font-black uppercase tracking-[0.2em] mb-2">Total Revenue</p>
                    <h3 class="text-4xl font-black text-white tracking-tighter">₱{{ number_format($totalSales, 0) }}</h3>
                    <p class="mt-4 text-emerald-400 text-xs font-bold flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 10l7-7m0 0l7 7m-7-7v18" stroke-width="3"></path></svg>
                        +12.5% Performance
                    </p>
                </div>

                <!-- Pending -->
                <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100 order-card">
                    <p class="text-slate-400 text-xs font-black uppercase tracking-[0.2em] mb-2">Active Orders</p>
                    <h3 class="text-4xl font-black text-orange-500 tracking-tighter">{{ $pendingOrders }}</h3>
                    <div class="mt-4 flex -space-x-2">
                        <div class="w-8 h-8 rounded-full bg-orange-100 border-2 border-white flex items-center justify-center text-[10px] font-bold text-orange-600">REQ</div>
                        <div class="w-8 h-8 rounded-full bg-slate-100 border-2 border-white"></div>
                    </div>
                </div>

                <!-- Fulfilled -->
                <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100 order-card">
                    <p class="text-slate-400 text-xs font-black uppercase tracking-[0.2em] mb-2">Fulfilled</p>
                    <h3 class="text-4xl font-black text-emerald-500 tracking-tighter">{{ $completedOrders }}</h3>
                    <p class="mt-4 text-slate-400 text-xs font-bold">Successfully Delivered</p>
                </div>

                <!-- Menu Items -->
                <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100 order-card">
                    <p class="text-slate-400 text-xs font-black uppercase tracking-[0.2em] mb-2">Menu Catalog</p>
                    <h3 class="text-4xl font-black text-slate-800 tracking-tighter">{{ $menuCount }}</h3>
                    <a href="{{ route('admin.menu') }}" class="mt-4 text-orange-500 text-xs font-bold hover:underline flex items-center gap-1">
                        Edit Menu Items →
                    </a>
                </div>
            </div>

            <!-- LIVE ORDERS STREAM -->
            <div class="px-4">
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
                    <div class="p-8 border-b border-slate-50 flex justify-between items-center">
                        <h3 class="text-xl font-black text-slate-800 uppercase tracking-tighter">Live Order Stream</h3>
                        <span class="bg-slate-100 text-slate-500 px-4 py-1 rounded-full text-[10px] font-black">REAL-TIME DATA</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50/50 text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">
                                    <th class="p-6">ID & Date</th>
                                    <th class="p-6">Customer Logistics</th>
                                    <th class="p-6">Delivery Address</th>
                                    <th class="p-6">Items Ordered</th>
                                    <th class="p-6 text-center">Amount</th>
                                    <th class="p-6">Status</th>
                                    <th class="p-6 text-right">Fulfillment</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @forelse($orders as $order)
                                <tr class="hover:bg-slate-50/80 transition-all group">
                                    <!-- ID -->
                                    <td class="p-6">
                                        <span class="block font-black text-slate-900">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                                        <span class="text-[10px] font-bold text-slate-400 tracking-tighter uppercase">{{ $order->created_at->format('M d • h:i A') }}</span>
                                    </td>

                                    <!-- Customer Details -->
                                    <td class="p-6">
                                        <p class="font-bold text-slate-800 leading-tight">{{ $order->customer_name }}</p>
                                        <a href="tel:{{ $order->phone }}" class="inline-flex items-center gap-1 text-orange-500 font-bold text-xs hover:underline mt-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" stroke-width="2"></path></svg>
                                            {{ $order->phone }}
                                        </a>
                                    </td>

                                    <!-- Address -->
                                    <td class="p-6">
                                        <div class="flex items-start gap-2 max-w-[220px]">
                                            <svg class="w-4 h-4 text-slate-300 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" stroke-width="2"></path></svg>
                                            <span class="text-xs font-bold text-slate-500 leading-relaxed">{{ $order->address }}</span>
                                        </div>
                                    </td>

                                    <!-- Items Breakdown -->
                                    <td class="p-6">
                                        <div class="space-y-1">
                                            @foreach($order->items as $item)
                                                <div class="flex items-center gap-2">
                                                    <span class="bg-slate-100 text-slate-600 px-1.5 py-0.5 rounded text-[10px] font-black uppercase">{{ $item->quantity }}x</span>
                                                    <span class="text-xs font-bold text-slate-600 truncate max-w-[120px]">{{ $item->item_name }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </td>

                                    <!-- Amount -->
                                    <td class="p-6 text-center">
                                        <span class="text-lg font-black text-slate-900 tracking-tighter">₱{{ number_format($order->total_amount, 0) }}</span>
                                    </td>

                                    <!-- Status -->
                                    <td class="p-6">
                                        @if($order->status == 'Pending')
                                            <span class="bg-orange-100 text-orange-600 px-3 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest flex items-center gap-2 w-fit">
                                                <span class="w-1.5 h-1.5 rounded-full bg-orange-500 animate-pulse"></span>
                                                Pending
                                            </span>
                                        @else
                                            <span class="bg-emerald-100 text-emerald-600 px-3 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest flex items-center gap-2 w-fit">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                                                Delivered
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Action -->
                                    <td class="p-6 text-right">
                                        @if($order->status == 'Pending')
                                        <form action="{{ route('admin.order.complete', $order->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="bg-slate-900 hover:bg-emerald-500 text-white px-5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all active:scale-95 shadow-xl shadow-slate-200">
                                                Mark Fulfilled
                                            </button>
                                        </form>
                                        @else
                                            <div class="pr-6">
                                                <svg class="w-6 h-6 text-emerald-500 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2"></path></svg>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="p-20 text-center">
                                        <div class="flex flex-col items-center opacity-20 grayscale">
                                            <svg class="w-20 h-20 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" stroke-width="1.5"></path></svg>
                                            <p class="text-xl font-black uppercase tracking-widest">No active orders</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
