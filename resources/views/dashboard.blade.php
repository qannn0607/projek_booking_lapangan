<x-app-layout>
    <div class="max-w-7xl mx-auto px-6">

        {{-- Flash Message --}}
        @if(session('status'))
        <div id="flash-msg" class="mb-6 px-5 py-4 rounded-2xl bg-green-500/10 border border-green-500/20 text-green-400 text-sm flex items-center justify-between">
            <span>✓ {{ session('status') }}</span>
            <button onclick="document.getElementById('flash-msg').remove()" class="text-green-600 hover:text-green-400">✕</button>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            {{-- ===== FORM TAMBAH BOOKING ===== --}}
            <div class="lg:col-span-4">
                <div class="bg-white/5 border border-white/10 p-8 rounded-3xl backdrop-blur-sm sticky top-24">
                    <h2 class="text-xl font-bold text-white mb-6">Tambah Reservasi</h2>

                    <form action="{{ route('bookings.store') }}" method="POST" class="space-y-5">
                        @csrf

                        <div>
                            <label class="text-sm text-gray-400 block mb-2">Nama Pelanggan</label>
                            <input
                                type="text"
                                name="customer_name"
                                required
                                value="{{ old('customer_name') }}"
                                placeholder="Contoh: Budi Santoso"
                                class="w-full bg-slate-900 border border-slate-700 rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none text-white p-3 transition"
                            />
                            @error('customer_name')
                                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="text-sm text-gray-400 block mb-2">Pilih Lapangan</label>
                            <select
                                name="field_id"
                                class="w-full bg-slate-900 border border-slate-700 rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none text-white p-3 transition"
                            >
                                @foreach($fields as $field)
                                    <option value="{{ $field->id }}" {{ old('field_id') == $field->id ? 'selected' : '' }}>
                                        {{ $field->name }} (Rp {{ number_format($field->price_per_hour) }}/jam)
                                    </option>
                                @endforeach
                            </select>
                            @error('field_id')
                                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm text-gray-400 block mb-2">Mulai</label>
                                <input
                                    type="datetime-local"
                                    name="start_time"
                                    required
                                    value="{{ old('start_time') }}"
                                    class="w-full bg-slate-900 border border-slate-700 rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none text-white p-3 text-sm transition"
                                />
                                @error('start_time')
                                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="text-sm text-gray-400 block mb-2">Durasi (Jam)</label>
                                <input
                                    type="number"
                                    name="duration"
                                    min="1"
                                    max="24"
                                    required
                                    value="{{ old('duration') }}"
                                    placeholder="1"
                                    class="w-full bg-slate-900 border border-slate-700 rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none text-white p-3 transition"
                                />
                                @error('duration')
                                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <button
                            type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-2xl shadow-lg shadow-blue-600/20 transition-all active:scale-95"
                        >
                            Konfirmasi Booking
                        </button>
                    </form>
                </div>
            </div>

            {{-- ===== TABEL BOOKING ===== --}}
            <div class="lg:col-span-8">
                <div class="bg-white/5 border border-white/10 rounded-3xl overflow-hidden">
                    <div class="p-6 border-b border-white/10 flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-white">Jadwal Aktif</h3>
                        <div class="flex gap-2 items-center">
                            <span class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></span>
                            <span class="text-xs text-gray-400 uppercase tracking-widest">Realtime Update</span>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-white/5 text-gray-400 text-xs uppercase tracking-wider">
                                <tr>
                                    <th class="px-6 py-4">Customer</th>
                                    <th class="px-6 py-4">Lapangan</th>
                                    <th class="px-6 py-4">Jadwal</th>
                                    <th class="px-6 py-4">Total</th>
                                    <th class="px-6 py-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5">
                                @forelse($bookings as $book)
                                <tr class="hover:bg-white/5 transition">
                                    <td class="px-6 py-5">
                                        <div class="font-bold text-white">{{ $book->customer_name }}</div>
                                        <div class="text-xs text-gray-500 italic">ID: #00{{ $book->id }}</div>
                                    </td>
                                    <td class="px-6 py-5 text-gray-300">{{ $book->field->name }}</td>
                                    <td class="px-6 py-5">
                                        <div class="text-sm text-gray-300">
                                            {{ \Carbon\Carbon::parse($book->start_time)->format('d M, H:i') }}
                                        </div>
                                        <div class="text-xs text-blue-500">{{ $book->duration }} Jam</div>
                                    </td>
                                    <td class="px-6 py-5 font-mono text-green-400 font-bold">
                                        Rp{{ number_format($book->total_price) }}
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="flex gap-2">
                                            {{-- Tombol Edit --}}
                                            <button
                                                onclick="openEditModal(
                                                    {{ $book->id }},
                                                    '{{ addslashes($book->customer_name) }}',
                                                    '{{ $book->field_id }}',
                                                    '{{ \Carbon\Carbon::parse($book->start_time)->format('Y-m-d\TH:i') }}',
                                                    {{ $book->duration }}
                                                )"
                                                class="p-2 hover:bg-blue-500/20 rounded-lg text-blue-400 transition"
                                                title="Edit Booking"
                                            >
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </button>

                                            {{-- Tombol Delete --}}
                                            <form action="{{ route('bookings.destroy', $book->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    type="submit"
                                                    class="p-2 hover:bg-red-500/20 rounded-lg text-red-500 transition"
                                                    title="Hapus Booking"
                                                    onclick="return confirm('Yakin ingin menghapus booking #00{{ $book->id }}?')"
                                                >
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-16 text-center">
                                        <div class="text-gray-600 text-4xl mb-3">📋</div>
                                        <div class="text-gray-500 italic text-sm">Belum ada booking aktif.</div>
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

    {{-- ===== MODAL EDIT ===== --}}
    <div id="editModal" class="fixed inset-0 z-50 hidden items-center justify-center px-4">
        {{-- Backdrop --}}
        <div class="absolute inset-0 bg-black/70 backdrop-blur-sm" onclick="closeEditModal()"></div>

        {{-- Card --}}
        <div id="editModalCard" class="relative z-10 w-full max-w-md bg-gray-900 border border-white/10 rounded-3xl p-8 shadow-2xl opacity-0 scale-95 transition-all duration-200">

            <div class="flex justify-between items-center mb-6">
                <div>
                    <h3 class="text-lg font-semibold text-white">Edit Booking</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Perbarui data booking di bawah ini</p>
                </div>
                <button onclick="closeEditModal()" class="p-2 hover:bg-white/10 rounded-xl text-gray-400 hover:text-white transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M6 18L18 6M6 6l12 12" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </button>
            </div>

            <form id="editForm" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs text-gray-400 uppercase tracking-widest mb-1.5">Nama Customer</label>
                    <input
                        type="text"
                        name="customer_name"
                        id="edit_customer_name"
                        required
                        placeholder="Masukkan nama customer"
                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:border-blue-500 focus:bg-white/8 transition"
                    />
                </div>

                <div>
                    <label class="block text-xs text-gray-400 uppercase tracking-widest mb-1.5">Lapangan</label>
                    <select
                        name="field_id"
                        id="edit_field_id"
                        required
                        class="w-full bg-gray-800 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500 transition appearance-none cursor-pointer"
                    >
                        @foreach($fields as $field)
                            <option value="{{ $field->id }}" class="bg-gray-800">
                                {{ $field->name }} — Rp{{ number_format($field->price_per_hour) }}/jam
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs text-gray-400 uppercase tracking-widest mb-1.5">Waktu Mulai</label>
                    <input
                        type="datetime-local"
                        name="start_time"
                        id="edit_start_time"
                        required
                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500 transition"
                    />
                </div>

                <div>
                    <label class="block text-xs text-gray-400 uppercase tracking-widest mb-1.5">Durasi (Jam)</label>
                    <input
                        type="number"
                        name="duration"
                        id="edit_duration"
                        min="1"
                        max="24"
                        required
                        placeholder="Contoh: 2"
                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:border-blue-500 transition"
                    />
                </div>

                <div class="flex gap-3 pt-2">
                    <button
                        type="button"
                        onclick="closeEditModal()"
                        class="flex-1 py-3 rounded-xl border border-white/10 text-gray-400 hover:bg-white/5 hover:text-white transition text-sm font-medium"
                    >
                        Batal
                    </button>
                    <button
                        type="submit"
                        class="flex-1 py-3 rounded-xl bg-blue-600 hover:bg-blue-500 active:bg-blue-700 text-white font-semibold transition text-sm"
                    >
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ===== SCRIPT ===== --}}
    <script>
        const modal = document.getElementById('editModal');
        const card  = document.getElementById('editModalCard');

        function openEditModal(id, customerName, fieldId, startTime, duration) {
            document.getElementById('edit_customer_name').value = customerName;
            document.getElementById('edit_field_id').value      = fieldId;
            document.getElementById('edit_start_time').value    = startTime;
            document.getElementById('edit_duration').value      = duration;
            document.getElementById('editForm').action          = `/bookings/${id}`;

            modal.classList.remove('hidden');
            modal.classList.add('flex');

            // Animasi masuk
            requestAnimationFrame(() => {
                card.classList.remove('opacity-0', 'scale-95');
                card.classList.add('opacity-100', 'scale-100');
            });
        }

        function closeEditModal() {
            card.classList.remove('opacity-100', 'scale-100');
            card.classList.add('opacity-0', 'scale-95');

            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 200);
        }

        // Tutup dengan tombol Escape
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') closeEditModal();
        });
    </script>
</x-app-layout>