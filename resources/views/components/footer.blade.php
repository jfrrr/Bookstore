{{-- BookStore Footer --}}
<footer class="bg-[#342f2b] text-[#f9efe8] mt-16">
    <div class="max-w-7xl mx-auto px-4 lg:px-8 py-14">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-10">

            {{-- Brand --}}
            <div class="md:col-span-2">
                <div class="flex items-center gap-2 mb-4">
                    <span class="material-symbols-outlined text-[#ffb77d] text-2xl" style="font-variation-settings: 'FILL' 1;">menu_book</span>
                    <span class="font-['Playfair_Display'] font-bold text-xl text-[#ffb77d]">BookStore</span>
                </div>
                <p class="text-[#dbc2b0] text-sm leading-relaxed max-w-sm">
                    Toko buku online terpercaya dengan koleksi ribuan judul dari berbagai genre. Bayar di tempat, pengiriman ke seluruh Indonesia.
                </p>
                <div class="flex items-center gap-4 mt-5">
                    <a href="#" class="w-9 h-9 rounded-full bg-[#554336] hover:bg-[#ffb77d]/20 flex items-center justify-center text-[#dbc2b0] hover:text-[#ffb77d] transition-colors">
                        <span class="material-symbols-outlined text-lg">facebook</span>
                    </a>
                    <a href="#" class="w-9 h-9 rounded-full bg-[#554336] hover:bg-[#ffb77d]/20 flex items-center justify-center text-[#dbc2b0] hover:text-[#ffb77d] transition-colors">
                        <span class="material-symbols-outlined text-lg">share</span>
                    </a>
                    <a href="{{ route('contact') }}" class="w-9 h-9 rounded-full bg-[#554336] hover:bg-[#ffb77d]/20 flex items-center justify-center text-[#dbc2b0] hover:text-[#ffb77d] transition-colors">
                        <span class="material-symbols-outlined text-lg">mail</span>
                    </a>
                </div>
            </div>

            {{-- Navigation --}}
            <div>
                <h3 class="font-semibold text-[#ffb77d] mb-4 text-sm uppercase tracking-wider">Navigasi</h3>
                <ul class="space-y-2.5">
                    <li><a href="{{ route('home') }}" class="text-sm text-[#dbc2b0] hover:text-[#ffb77d] transition-colors">Beranda</a></li>
                    <li><a href="{{ route('books.index') }}" class="text-sm text-[#dbc2b0] hover:text-[#ffb77d] transition-colors">Katalog Buku</a></li>
                    <li><a href="{{ route('about') }}" class="text-sm text-[#dbc2b0] hover:text-[#ffb77d] transition-colors">Tentang Kami</a></li>
                    <li><a href="{{ route('contact') }}" class="text-sm text-[#dbc2b0] hover:text-[#ffb77d] transition-colors">Kontak</a></li>
                </ul>
            </div>

            {{-- Contact --}}
            <div>
                <h3 class="font-semibold text-[#ffb77d] mb-4 text-sm uppercase tracking-wider">Informasi</h3>
                <ul class="space-y-3">
                    <li class="flex items-start gap-2.5 text-[#dbc2b0]">
                        <span class="material-symbols-outlined text-base text-[#ffb77d] mt-0.5">location_on</span>
                        <span class="text-sm">Jakarta, Indonesia</span>
                    </li>
                    <li class="flex items-center gap-2.5 text-[#dbc2b0]">
                        <span class="material-symbols-outlined text-base text-[#ffb77d]">mail</span>
                        <span class="text-sm">hello@bookstore.id</span>
                    </li>
                    <li class="flex items-center gap-2.5 text-[#dbc2b0]">
                        <span class="material-symbols-outlined text-base text-[#ffb77d]">payments</span>
                        <span class="text-sm">Bayar di Tempat (COD)</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Bottom bar --}}
    <div class="border-t border-[#554336] py-5">
        <div class="max-w-7xl mx-auto px-4 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-3">
            <p class="text-sm text-[#887364]">&copy; {{ date('Y') }} BookStore. Semua hak cipta dilindungi.</p>
            <p class="text-sm text-[#887364]">Dibuat dengan <span class="text-[#ffb77d]">♥</span> untuk para pecinta buku</p>
        </div>
    </div>
</footer>
