<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Lab | CraveBites</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #0f172a; }
        .glass { background: rgba(255, 255, 255, 0.03); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.05); }
        
        .glass-input { 
            background: rgba(255, 255, 255, 0.05); 
            border: 1px solid rgba(255, 255, 255, 0.1); 
            color: white; 
            transition: all 0.3s; 
            color-scheme: dark; /* Fixes browser default white dropdowns */
        }
        
        .glass-input:focus { background: rgba(255, 255, 255, 0.1); border-color: #f97316; outline: none; ring: 2px; ring-color: #f97316; }
        
        /* Forces dropdown options to stay dark */
        select option {
            background-color: #0f172a;
            color: white;
        }

        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-thumb { background: #334155; border-radius: 10px; }
    </style>
</head>
<body class="text-slate-200 flex h-screen overflow-hidden">

    <!-- SIDEBAR -->
    <aside class="w-72 bg-slate-950 border-r border-slate-800 flex flex-col h-full z-20">
        <div class="p-8">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-orange-500 rounded-xl flex items-center justify-center shadow-lg shadow-orange-500/40">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <h1 class="text-xl font-extrabold tracking-tighter text-white">CRAVE<span class="text-orange-500">BITES</span></h1>
            </div>
        </div>
        
        <nav class="flex-1 px-4 space-y-2 mt-4">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-4 text-slate-400 hover:text-white hover:bg-white/5 px-6 py-4 rounded-2xl font-bold transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                Dashboard
            </a>
            <a href="{{ route('admin.menu') }}" class="flex items-center gap-4 bg-orange-500/10 text-orange-500 px-6 py-4 rounded-2xl font-bold transition-all border border-orange-500/20">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                Menu Lab
            </a>
        </nav>

        <div class="p-6">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-4 text-slate-500 hover:text-red-400 px-6 py-4 font-bold transition-all rounded-2xl text-sm">
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 flex flex-col h-full overflow-y-auto no-scrollbar">
        <header class="p-10 flex justify-between items-end">
            <div>
                <p class="text-orange-500 font-black text-xs uppercase tracking-[0.3em] mb-2">Inventory Management</p>
                <h2 class="text-4xl font-black text-white tracking-tighter">Menu Lab</h2>
            </div>
        </header>

        <div class="px-10 pb-10 grid grid-cols-1 lg:grid-cols-3 gap-10">
            <!-- LEFT: ADD FORM -->
            <div class="lg:col-span-1">
                <div class="glass p-8 rounded-[2.5rem] sticky top-10">
                    <h3 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                        <span class="w-2 h-6 bg-orange-500 rounded-full"></span>
                        Create New Entry
                    </h3>
                    
                    <form action="{{ route('admin.menu.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                        @csrf
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Item Visual</label>
                            <input type="file" name="image" class="w-full text-xs text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-orange-500 file:text-white hover:file:bg-orange-600 cursor-pointer">
                        </div>

                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Designation</label>
                            <input type="text" name="name" required placeholder="e.g. Bacon Beast" class="w-full px-5 py-4 rounded-2xl glass-input font-bold">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Price (₱)</label>
                                <input type="number" step="0.01" name="price" required placeholder="0.00" class="w-full px-5 py-4 rounded-2xl glass-input font-bold">
                            </div>
                            <div>
                                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Class</label>
                                <select name="category" required class="w-full px-5 py-4 rounded-2xl glass-input font-bold appearance-none">
                                    <option value="Burgers">Burgers</option>
                                    <option value="Pizza">Pizza</option>
                                    <option value="Salads">Salads</option>
                                    <option value="Drinks">Drinks</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Specifications</label>
                            <textarea name="description" rows="3" placeholder="Brief description..." class="w-full px-5 py-4 rounded-2xl glass-input font-bold resize-none"></textarea>
                        </div>

                        <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white py-5 rounded-2xl font-black uppercase tracking-widest shadow-lg shadow-orange-500/20 transition-all active:scale-95 flex items-center justify-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 6v6m0 0v6m0-6h6m-6 0H6" stroke-width="3"></path></svg>
                            Deploy to Menu
                        </button>
                    </form>
                </div>
            </div>

            <!-- RIGHT: MENU LIST -->
            <div class="lg:col-span-2">
                <div class="glass rounded-[2.5rem] overflow-hidden">
                    <div class="p-8 border-b border-white/5 flex justify-between items-center bg-white/[0.01]">
                        <h3 class="text-xl font-bold text-white">Active Database</h3>
                        <span class="bg-slate-800 text-slate-400 px-4 py-1.5 rounded-full text-[10px] font-black uppercase">{{ count($menus) }} Units</span>
                    </div>
                    
                    <div class="overflow-x-auto relative z-10">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="text-slate-500 text-[10px] uppercase tracking-[0.2em] font-black">
                                    <th class="p-6">Visual & Identity</th>
                                    <th class="p-6">Classification</th>
                                    <th class="p-6">Valuation</th>
                                    <th class="p-6 text-right">Operations</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5">
                                @forelse($menus as $menu)
                                <tr class="hover:bg-white/[0.02] transition-colors group">
                                    <td class="p-6 flex items-center gap-4">
                                        <div class="w-14 h-14 bg-slate-800 rounded-2xl overflow-hidden shrink-0 border border-white/5 shadow-inner text-orange-500 flex items-center justify-center font-black text-xl">
                                            @if($menu->image)
                                                <img src="{{ asset('storage/' . $menu->image) }}" class="w-full h-full object-cover">
                                            @else
                                                {{ substr($menu->name, 0, 2) }}
                                            @endif
                                        </div>
                                        <div>
                                            <p class="font-black text-white text-base">{{ $menu->name }}</p>
                                            <p class="text-[10px] text-slate-500 font-bold uppercase truncate w-40">{{ $menu->description }}</p>
                                        </div>
                                    </td>
                                    <td class="p-6">
                                        <span class="bg-orange-500/10 text-orange-500 px-3 py-1 rounded-full text-[10px] font-black uppercase border border-orange-500/20">
                                            {{ $menu->category }}
                                        </span>
                                    </td>
                                    <td class="p-6 font-black text-white text-lg">₱{{ number_format($menu->price, 2) }}</td>
                                    <td class="p-6 text-right">
                                        <div class="flex justify-end gap-2 relative z-30">
                                            <!-- STABLE EDIT BUTTON -->
                                            <button type="button" 
                                                onclick="openEditModal(this)"
                                                data-id="{{ $menu->id }}"
                                                data-name="{{ $menu->name }}"
                                                data-price="{{ $menu->price }}"
                                                data-category="{{ $menu->category }}"
                                                data-description="{{ $menu->description }}"
                                                class="p-3 glass hover:bg-orange-500/20 hover:text-orange-500 rounded-xl transition-all cursor-pointer">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" stroke-width="2.5"></path></svg>
                                            </button>
                                            <form action="{{ route('admin.menu.delete', $menu->id) }}" method="POST" onsubmit="return confirm('Confirm deletion?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="p-3 glass hover:bg-red-500/20 hover:text-red-500 rounded-xl transition-all cursor-pointer">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="2.5"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="p-20 text-center text-slate-500 font-bold uppercase tracking-widest text-xs">No active units in database</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- EDIT MODAL -->
    <div id="editModal" class="hidden fixed inset-0 bg-slate-950/80 backdrop-blur-md z-[100] flex items-center justify-center p-4">
        <div class="glass p-10 rounded-[3rem] w-full max-w-lg shadow-2xl animate-fade-in">
            <h3 class="text-2xl font-black text-white mb-8 flex items-center gap-3">
                <span class="w-3 h-8 bg-orange-500 rounded-full"></span>
                Edit Specifications
            </h3>
            
            <form id="editForm" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf @method('PUT')
                
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Update Visual (Optional)</label>
                    <input type="file" name="image" class="w-full text-xs text-slate-400">
                </div>

                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Designation</label>
                    <input type="text" name="name" id="edit_name" required class="w-full px-5 py-4 rounded-2xl glass-input font-bold">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Price (₱)</label>
                        <input type="number" step="0.01" name="price" id="edit_price" required class="w-full px-5 py-4 rounded-2xl glass-input font-bold">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Class</label>
                        <select name="category" id="edit_category" required class="w-full px-5 py-4 rounded-2xl glass-input font-bold appearance-none">
                            <option value="Burgers">Burgers</option>
                            <option value="Pizza">Pizza</option>
                            <option value="Salads">Salads</option>
                            <option value="Drinks">Drinks</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Specifications</label>
                    <textarea name="description" id="edit_description" rows="3" class="w-full px-5 py-4 rounded-2xl glass-input font-bold resize-none"></textarea>
                </div>

                <div class="flex gap-4 pt-4">
                    <button type="button" onclick="closeEditModal()" class="flex-1 bg-white/5 hover:bg-white/10 text-white py-5 rounded-2xl font-black uppercase tracking-widest transition-all">Cancel</button>
                    <button type="submit" class="flex-1 bg-orange-500 hover:bg-orange-600 text-white py-5 rounded-2xl font-black uppercase tracking-widest shadow-lg shadow-orange-500/20 transition-all">Apply Changes</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(button) {
            // Get data from data attributes
            const id = button.getAttribute('data-id');
            const name = button.getAttribute('data-name');
            const price = button.getAttribute('data-price');
            const category = button.getAttribute('data-category');
            const description = button.getAttribute('data-description');

            // Set Form Action
            document.getElementById('editForm').action = '/admin/menu/update/' + id;
            
            // Fill Fields
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_price').value = price;
            document.getElementById('edit_category').value = category;
            document.getElementById('edit_description').value = description;
            
            // Show Modal
            document.getElementById('editModal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        window.onclick = function(event) {
            const modal = document.getElementById('editModal');
            if (event.target == modal) closeEditModal();
        }
    </script>
</body>
</html>