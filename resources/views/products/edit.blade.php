<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <a href="{{ route('products.index') }}" class="text-slate-400 hover:text-slate-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-semibold text-2xl text-slate-800 leading-tight">
                {{ __('Edit Produk: ') }} <span class="text-emerald-600">{{ $product->nama_barang }}</span>
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-8">
                    
                    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Validation Errors -->
                        @if ($errors->any())
                            <div class="mb-8 bg-rose-50 border-l-4 border-rose-500 p-4 rounded-r-lg">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-rose-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-rose-800">Terdapat kesalahan pada isian Anda:</h3>
                                        <ul class="mt-2 text-sm text-rose-700 list-disc list-inside">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Left Column -->
                            <div class="space-y-6">
                                <div>
                                    <label for="nama_barang" class="block text-sm font-medium text-slate-700 mb-1">Nama Barang <span class="text-rose-500">*</span></label>
                                    <input type="text" id="nama_barang" name="nama_barang" value="{{ old('nama_barang', $product->nama_barang) }}" placeholder="Contoh: Laptop Asus ROG" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 text-slate-900 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors" required>
                                </div>
                                
                                <div>
                                    <div class="flex justify-between items-center mb-1">
                                        <label for="category_id" class="block text-sm font-medium text-slate-700">Kategori <span class="text-rose-500">*</span></label>
                                        <button type="button" onclick="addCategory()" class="text-xs text-emerald-600 hover:text-emerald-700 font-medium flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                            Tambah Baru
                                        </button>
                                    </div>
                                    <select id="category_id" name="category_id" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 text-slate-900 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->nama_kategori }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div>
                                    <div class="flex justify-between items-center mb-1">
                                        <label for="supplier_id" class="block text-sm font-medium text-slate-700">Supplier <span class="text-rose-500">*</span></label>
                                        <button type="button" onclick="addSupplier()" class="text-xs text-amber-600 hover:text-amber-700 font-medium flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                            Tambah Baru
                                        </button>
                                    </div>
                                    <select id="supplier_id" name="supplier_id" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 text-slate-900 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors" required>
                                        @foreach($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}" {{ old('supplier_id', $product->supplier_id) == $supplier->id ? 'selected' : '' }}>
                                                {{ $supplier->nama_supplier }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="space-y-6">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="harga" class="block text-sm font-medium text-slate-700 mb-1">Harga (Rp) <span class="text-rose-500">*</span></label>
                                        <input type="text" id="harga_display" value="{{ old('harga', $product->harga) }}" placeholder="0" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 text-slate-900 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors" required>
                                        <input type="hidden" id="harga" name="harga" value="{{ old('harga', $product->harga) }}">
                                    </div>
                                    <div>
                                        <label for="stok" class="block text-sm font-medium text-slate-700 mb-1">Jumlah Stok</label>
                                        <input type="number" id="stok" name="stok" value="{{ old('stok', $product->stok) }}" class="w-full px-4 py-2.5 bg-slate-100 border border-slate-200 text-slate-500 rounded-lg cursor-not-allowed" readonly>
                                        <p class="mt-1 text-xs text-slate-500">Stok hanya dapat diubah melalui menu Transaksi.</p>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Foto Produk <span class="text-slate-400 font-normal">(Opsional)</span></label>
                                    @if($product->foto)
                                        <div class="mb-3 relative w-32 h-32 rounded-lg border border-slate-200 overflow-hidden group">
                                            <img src="{{ Storage::url($product->foto) }}" alt="{{ $product->nama_barang }}" class="w-full h-full object-cover">
                                            <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                                <span class="text-white text-xs font-medium">Foto Saat Ini</span>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-200 border-dashed rounded-lg hover:bg-slate-50 transition-colors">
                                        <div class="space-y-1 text-center">
                                            <svg class="mx-auto h-12 w-12 text-slate-300" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <div class="flex text-sm text-slate-600 justify-center">
                                                <label for="foto" class="relative cursor-pointer bg-white rounded-md font-medium text-emerald-600 hover:text-emerald-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-emerald-500">
                                                    <span id="file-name">Pilih file gambar baru (opsional)</span>
                                                    <input id="foto" name="foto" type="file" class="sr-only" accept="image/jpeg,image/png,image/jpg,image/gif" onchange="document.getElementById('file-name').textContent = this.files[0] ? this.files[0].name : 'Pilih file gambar baru (opsional)'">
                                                </label>
                                            </div>
                                            <p class="text-xs text-slate-500">PNG, JPG, GIF up to 2MB</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 pt-6 border-t border-slate-100 flex items-center justify-end space-x-3">
                            <a href="{{ route('products.index') }}" class="px-5 py-2.5 text-sm font-medium text-slate-600 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 hover:text-slate-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-200 transition-colors">
                                Batal
                            </a>
                            <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors shadow-sm">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const hargaDisplay = document.getElementById('harga_display');
    const hargaInput = document.getElementById('harga');

    function formatRupiah(value) {
        // Since original price might be a decimal string from database like "1000000.00", 
        // we should take only the integer part before formatting if it has .00
        if(value.includes('.') && value.split('.')[1] == '00') {
            value = value.split('.')[0];
        }
        let number_string = value.replace(/[^,\d]/g, '').toString();
        let split = number_string.split(',');
        let sisa = split[0].length % 3;
        let rupiah = split[0].substr(0, sisa);
        let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            let separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
        return rupiah;
    }

    hargaDisplay.addEventListener('keyup', function(e) {
        this.value = formatRupiah(this.value);
        hargaInput.value = this.value.replace(/\./g, '');
    });
    
    // Initialize if there is old value
    if (hargaDisplay.value) {
        hargaDisplay.value = formatRupiah(hargaDisplay.value);
    }
});

function addCategory() {
    Swal.fire({
        title: 'Kategori Baru',
        input: 'text',
        text: 'Masukkan nama kategori baru:',
        showCancelButton: true,
        confirmButtonText: 'Simpan',
        cancelButtonText: 'Batal',
        inputValidator: (value) => {
            if (!value) {
                return 'Nama kategori tidak boleh kosong!'
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            let name = result.value;
            fetch('{{ route('api.categories.store') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ nama_kategori: name })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    let select = document.getElementById('category_id');
                    let option = document.createElement("option");
                    option.text = data.category.nama_kategori;
                    option.value = data.category.id;
                    select.add(option);
                    select.value = data.category.id;
                    Swal.fire('Berhasil!', 'Kategori berhasil ditambahkan.', 'success');
                } else {
                    Swal.fire('Gagal!', 'Gagal menambahkan kategori.', 'error');
                }
            })
            .catch(error => {
                Swal.fire('Error!', 'Terjadi kesalahan sistem.', 'error');
            });
        }
    });
}

function addSupplier() {
    Swal.fire({
        title: 'Supplier Baru',
        input: 'text',
        text: 'Masukkan nama supplier baru (Sistem akan mengisi info lainnya secara default):',
        showCancelButton: true,
        confirmButtonText: 'Simpan',
        cancelButtonText: 'Batal',
        inputValidator: (value) => {
            if (!value) {
                return 'Nama supplier tidak boleh kosong!'
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            let name = result.value;
            fetch('{{ route('api.suppliers.store') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ nama_supplier: name })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    let select = document.getElementById('supplier_id');
                    let option = document.createElement("option");
                    option.text = data.supplier.nama_supplier;
                    option.value = data.supplier.id;
                    select.add(option);
                    select.value = data.supplier.id;
                    Swal.fire('Berhasil!', 'Supplier berhasil ditambahkan.', 'success');
                } else {
                    Swal.fire('Gagal!', 'Gagal menambahkan supplier.', 'error');
                }
            })
            .catch(error => {
                Swal.fire('Error!', 'Terjadi kesalahan sistem.', 'error');
            });
        }
    });
}
</script>