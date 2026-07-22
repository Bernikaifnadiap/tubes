<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <a href="{{ route('transactions.index') }}" class="text-slate-400 hover:text-slate-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-semibold text-2xl text-slate-800 leading-tight">
                {{ $type === 'masuk' ? 'Catat Barang Masuk' : 'Catat Barang Keluar' }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-8">
                    @if ($errors->any())
                        <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-xl">
                            <ul class="list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('transactions.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="type" value="{{ $type }}">

                        <div class="space-y-6">
                            <div>
                                <label for="product_id" class="block text-sm font-medium text-slate-700 mb-1">Pilih Produk <span class="text-rose-500">*</span></label>
                                <select id="product_id" name="product_id" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 text-slate-900 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors" required>
                                    <option value="">-- Pilih Produk --</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" {{ (old('product_id') == $product->id || $selectedProductId == $product->id) ? 'selected' : '' }}>
                                            {{ $product->nama_barang }} (Stok saat ini: {{ $product->stok }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="quantity" class="block text-sm font-medium text-slate-700 mb-1">Jumlah <span class="text-rose-500">*</span></label>
                                <div class="relative">
                                    <input type="number" id="quantity" name="quantity" value="{{ old('quantity') }}" min="1" placeholder="Contoh: 10" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 text-slate-900 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors" required>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-slate-400 sm:text-sm">Unit</span>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label for="keterangan" class="block text-sm font-medium text-slate-700 mb-1">Keterangan / Catatan</label>
                                <textarea id="keterangan" name="keterangan" rows="3" placeholder="Contoh: Restock bulanan dari supplier..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 text-slate-900 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">{{ old('keterangan') }}</textarea>
                            </div>

                            <div class="pt-4 flex items-center space-x-4">
                                <button type="submit" class="flex-1 bg-{{ $type === 'masuk' ? 'emerald' : 'rose' }}-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-{{ $type === 'masuk' ? 'emerald' : 'rose' }}-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-{{ $type === 'masuk' ? 'emerald' : 'rose' }}-500 transition-colors">
                                    Simpan Transaksi
                                </button>
                                <a href="{{ route('transactions.index') }}" class="px-6 py-3 text-slate-600 bg-white border border-slate-300 rounded-lg font-medium hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-200 transition-colors">
                                    Batal
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
