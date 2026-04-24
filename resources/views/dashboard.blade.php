<x-app-layout>
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <div class="lg:col-span-4">
                <div class="bg-white/5 border border-white/10 p-8 rounded-3xl backdrop-blur-sm sticky top-24">
                    <h2 class="text-xl font-bold text-white mb-6">Tambah Reservasi</h2>
                    
                    <form action="{{ route('bookings.store') }}" method="POST" class="space-y-5">
                        @csrf
                        <div>
                            <label class="text-sm text-gray-400 block mb-2">Nama Pelanggan</label>
                            <input type="text" name="customer_name" required 
                                class="w-full bg-slate-900 border-slate-700 rounded-xl focus:ring-blue-500 text-white p-3">
                        </div>

                        <div>
                            <label class="text-sm text-gray-400 block mb-2">Pilih Lapangan</label>
                            <select name="field_id" class="w-full bg-slate-900 border-slate-700 rounded-xl focus:ring-blue-500 text-white p-3">
                                @foreach($fields as $field)
                                    <option value="{{ $field->id }}">{{ $field->name }} (Rp {{ number_format($field->price_per_hour) }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm text-gray-400 block mb-2">Mulai</label>
                                <input type="datetime-local" name="start_time" required class="w-full bg-slate-900 border-slate-700 rounded-xl text-white p-3 text-sm">
                            </div>
                            <div>
                                <label class="text-sm text-gray-400 block mb-2">Durasi (Jam)</label>
                                <input type="number" name="duration" min="1" required class="w-full bg-slate-900 border-slate-700 rounded-xl text-white p-3">
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-2xl shadow-lg shadow-blue-600/20 transition-all active:scale-95">
                            Konfirmasi Booking
                        </button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-8">
                <div class="bg-white/5 border border-white/10 rounded-3xl overflow-hidden">
                    <div class="p-6 border-b border-white/10 flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-white">Jadwal Aktif</h3>
                        <div class="flex gap-2">
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
                                    <th class="px-6 py-4"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5">
                                @foreach($bookings as $book)
                                <tr class="hover:bg-white/5 transition">
                                    <td class="px-6 py-5">
                                        <div class="font-bold text-white">{{ $book->customer_name }}</div>
                                        <div class="text-xs text-gray-500 italic">ID: #00{{ $book->id }}</div>
                                    </td>
                                    <td class="px-6 py-5 text-gray-300">{{ $book->field->name }}</td>
                                    <td class="px-6 py-5">
                                        <div class="text-sm text-gray-300">{{ \Carbon\Carbon::parse($book->start_time)->format('d M, H:i') }}</div>
                                        <div class="text-xs text-blue-500">{{ $book->duration }} Jam</div>
                                    </td>
                                    <td class="px-6 py-5 font-mono text-green-400 font-bold">
                                        Rp{{ number_format($book->total_price) }}
                                    </td>
                                    <td class="px-6 py-5">
                                        <form action="{{ route('bookings.destroy', $book->id) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button class="p-2 hover:bg-red-500/20 rounded-lg text-red-500 transition">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>