<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CraveBites | Premium Ordering</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        
        /* Custom Slim Scrollbar for the Cart */
        .cart-scrollbar::-webkit-scrollbar { width: 5px; }
        .cart-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; }
        .cart-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
        .cart-scrollbar::-webkit-scrollbar-thumb:hover { background: #cbd5e1; }

        .animate-fade-in { animation: fadeIn 0.4s ease-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body class="bg-[#F8FAFC] text-slate-900 flex h-screen overflow-hidden">

    <!-- LEFT: MENU AREA (Remains largely the same) -->
    <div class="flex-1 flex flex-col h-full overflow-hidden">
        <header class="p-8 flex justify-between items-center bg-white/50 border-b border-slate-100">
            <div class="flex items-center gap-4">
                <div class="bg-orange-500 p-3 rounded-2xl shadow-lg shadow-orange-200">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                </div>
                <div>
                    <h1 class="text-3xl font-extrabold tracking-tight">Crave<span class="text-orange-500">Bites</span></h1>
                    <p class="text-slate-400 text-sm font-medium">Deliciousness delivered to your door.</p>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <form action="{{ route('home') }}" method="GET" class="relative group">
                    <span class="absolute inset-y-0 left-4 flex items-center text-slate-400 group-focus-within:text-orange-500 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search for food..." class="pl-12 pr-6 py-3.5 bg-white border border-slate-200 rounded-2xl focus:ring-4 focus:ring-orange-100 focus:border-orange-500 outline-none w-80 transition-all shadow-sm">
                </form>
                <a href="{{ route('login') }}" class="bg-slate-900 text-white p-3.5 rounded-2xl hover:bg-orange-500 transition-all shadow-xl shadow-slate-200 group">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </a>
            </div>
        </header>

        <div class="px-8 py-6 flex gap-3 overflow-x-auto no-scrollbar">
            @php 
                $categories = [
                    ['name' => 'All Items', 'icon' => '🍽️', 'val' => ''],
                    ['name' => 'Burgers', 'icon' => '🍔', 'val' => 'Burgers'],
                    ['name' => 'Pizza', 'icon' => '🍕', 'val' => 'Pizza'],
                    ['name' => 'Salads', 'icon' => '🥗', 'val' => 'Salads'],
                    ['name' => 'Drinks', 'icon' => '🥤', 'val' => 'Drinks'],
                ];
            @endphp
            @foreach($categories as $cat)
                <a href="{{ route('home', ['category' => $cat['val']]) }}" 
                   class="px-8 py-3.5 rounded-2xl font-bold transition-all active:scale-95 whitespace-nowrap border 
                   {{ request('category') == $cat['val'] ? 'bg-orange-500 text-white border-orange-500 shadow-lg shadow-orange-200' : 'bg-white text-slate-500 border-slate-200 hover:border-orange-200 hover:text-orange-500' }}">
                    {{ $cat['icon'] }} {{ $cat['name'] }}
                </a>
            @endforeach
        </div>

        <main class="flex-1 overflow-y-auto px-8 pb-10 no-scrollbar">
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
                @forelse($menus as $menu)
                <div class="bg-white rounded-[2.5rem] p-4 shadow-sm hover:shadow-2xl transition-all duration-500 border border-slate-100 group relative">
                    <span class="absolute top-8 left-8 z-10 bg-orange-500 text-white px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest shadow-lg shadow-orange-200">
                        {{ $menu->category ?? 'New' }}
                    </span>
                    <div class="h-56 rounded-[2rem] overflow-hidden mb-6 relative">
                        <img src="{{ $menu->image ? asset('storage/' . $menu->image) : 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=600' }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    </div>
                    <div class="px-4 pb-4">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-xl font-bold text-slate-800 leading-tight group-hover:text-orange-500 transition-colors">{{ $menu->name }}</h3>
                            <span class="text-xl font-black text-emerald-600">₱{{ number_format($menu->price, 0) }}</span>
                        </div>
                        <p class="text-slate-400 text-sm mb-6 line-clamp-2 font-medium">{{ $menu->description ?? 'Chef recommended and freshly prepared.' }}</p>
                        <a href="{{ route('cart.add', $menu->id) }}" class="w-full bg-slate-50 text-slate-900 group-hover:bg-orange-500 group-hover:text-white py-4 rounded-2xl font-bold flex items-center justify-center gap-3 transition-all duration-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            Add to Order
                        </a>
                    </div>
                </div>
                @empty
                <div class="col-span-full py-20 text-center text-slate-400 font-bold">No food found here.</div>
                @endforelse
            </div>
        </main>
    </div>

    <!-- RIGHT: CART SIDEBAR (Fixed Height Squeezing) -->
    <aside class="w-[450px] bg-white border-l border-slate-100 flex flex-col h-full shadow-2xl relative z-30">
        <!-- Header -->
        <div class="p-6 flex justify-between items-center border-b border-slate-50 shrink-0">
            <h2 class="text-xl font-extrabold flex items-center gap-3 text-slate-800">
                <div class="w-10 h-10 bg-orange-500 rounded-xl flex items-center justify-center shadow-lg shadow-orange-100">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
                My Order
            </h2>
            <span class="bg-orange-100 text-orange-600 px-4 py-1.5 rounded-full text-xs font-black uppercase">{{ count($cart) }} Items</span>
        </div>

        <!-- Scrollable Items List (Now with more space) -->
        <div class="flex-1 overflow-y-auto p-6 space-y-5 cart-scrollbar">
            @forelse($cart as $id => $details)
            <div class="flex items-center gap-4 group animate-fade-in">
                <!-- Sizing reduced from 20 to 16 to save space -->
                <div class="w-16 h-16 rounded-2xl overflow-hidden border border-slate-100 shadow-sm shrink-0">
                    <img src="{{ !empty($details['image']) ? asset('storage/' . $details['image']) : 'https://ui-avatars.com/api/?name='.urlencode($details['name']).'&background=random' }}" class="w-full h-full object-cover">
                </div>
                <div class="flex-1 min-w-0">
                    <h4 class="font-bold text-slate-800 truncate text-base leading-tight">{{ $details['name'] }}</h4>
                    <p class="text-emerald-500 font-black text-sm mb-1">₱{{ number_format($details['price'], 0) }}</p>
                    
                    <form action="{{ route('cart.update', $id) }}" method="POST" class="inline-flex items-center bg-slate-50 rounded-lg p-0.5 border border-slate-100">
                        @csrf
                        <button name="action" value="minus" class="w-7 h-7 flex items-center justify-center hover:bg-white rounded text-slate-400">-</button>
                        <span class="w-7 text-center font-black text-slate-700 text-xs">{{ $details['quantity'] }}</span>
                        <button name="action" value="plus" class="w-7 h-7 flex items-center justify-center hover:bg-white rounded text-slate-400">+</button>
                    </form>
                </div>
                <div class="text-right flex flex-col items-end gap-1">
                    <a href="{{ route('cart.remove', $id) }}" class="text-slate-300 hover:text-red-500 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </a>
                    <span class="font-black text-slate-900 text-sm">₱{{ number_format($details['price'] * $details['quantity'], 0) }}</span>
                </div>
            </div>
            @empty
            <div class="h-full flex flex-col items-center justify-center text-center py-10 opacity-30">
                <svg class="w-12 h-12 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                <p class="text-lg font-bold">Tray is empty</p>
            </div>
            @endforelse
        </div>

        <!-- TOTALS & COMPACT CHECKOUT FORM -->
        @if(count($cart) > 0)
        <div class="p-6 bg-white border-t border-slate-100 shadow-[0_-15px_40px_rgba(0,0,0,0.03)] shrink-0">
            @php $total = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart)); @endphp
            
            <div class="flex justify-between items-center mb-4">
                <span class="text-sm font-black text-slate-400 uppercase">Total Amount</span>
                <span class="text-3xl font-black text-slate-900 tracking-tighter">₱{{ number_format($total, 0) }}</span>
            </div>

            <!-- Optimized Grid Layout for Form -->
            <form action="{{ route('order.place') }}" method="POST" class="space-y-3">
                @csrf
                <div class="grid grid-cols-2 gap-2">
                    <input type="text" name="customer_name" placeholder="Name" required 
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl outline-none focus:ring-2 focus:ring-orange-100 focus:bg-white transition-all font-bold text-sm text-slate-700">
                    
                    <input type="tel" name="phone" placeholder="Phone" required 
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl outline-none focus:ring-2 focus:ring-orange-100 focus:bg-white transition-all font-bold text-sm text-slate-700">
                </div>
                
                <textarea name="address" placeholder="Delivery Address" required rows="2"
                          class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl outline-none focus:ring-2 focus:ring-orange-100 focus:bg-white transition-all font-bold text-sm text-slate-700 resize-none"></textarea>

                <button type="submit" class="w-full bg-slate-900 hover:bg-orange-500 text-white py-4 rounded-2xl font-black text-lg shadow-xl transition-all active:scale-95 flex items-center justify-center gap-3">
                    Place My Order
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </form>

            <div class="mt-4 text-center">
                <a href="{{ route('cart.clear') }}" class="text-slate-400 hover:text-red-500 text-[10px] font-black uppercase tracking-widest">
                    Clear Order
                </a>
            </div>
        </div>
        @endif
    </aside>

    <!-- TOAST (Unchanged) -->
    @if(session('success'))
    <div id="toast" class="fixed bottom-10 left-10 z-[100] bg-slate-900 text-white px-8 py-6 rounded-[2.5rem] shadow-2xl font-bold flex items-center gap-4 animate-slide-up">
        <div class="bg-emerald-500 p-2 rounded-full ring-4 ring-emerald-500/20">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
        </div>
        {{ session('success') }}
    </div>
    <script>
        setTimeout(() => {
            const toast = document.getElementById('toast');
            if(toast) {
                toast.style.opacity = '0';
                toast.style.transform = 'translateY(20px)';
                toast.style.transition = 'all 0.5s ease-out';
                setTimeout(() => toast.remove(), 500);
            }
        }, 4000);
    </script>
    @endif

</body>
</html>