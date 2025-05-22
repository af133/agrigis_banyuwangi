<nav class="bg-[#DDFFAC]  md:hidden" x-data="{ isOpen: false }">
  <div class="flex items-center justify-between px-4 py-3">
    <span class="text-black font-bold">Menu</span>
    <button @click="isOpen = !isOpen" class="text-black hover:text-white focus:outline-none">
      <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M4 6h16M4 12h16M4 18h16"/>
      </svg>
    </button>
  </div>

  <div x-show="isOpen" x-cloak x-transition.duration.200ms>
    <div class="px-4 py-2 space-y-1">
      <div class="flex items-center space-x-3">
        <img src="{{ asset($img) }}" alt="User" class="w-13 h-13 rounded-full" />
        <div>
          <div class="block rounded-md px-3 py-2 text-black">{{ $name }}</div>
          <div class="block rounded-md px-3 py-1 text-black">
            @if($status == 'Kepala Dinas')
              Kepala Staf
            @elseif($status == 'Staf')
              Staf Lapangan
            @elseif($status == 'Admin')
              Admin
            @endif
          </div>
        </div>
      </div>

      <div class="mt-3 space-y-2 text-sm">
        <x-nav-link href="{{ route('profile') }}" :active="request()->is('profile')">Akun Saya</x-nav-link>
      </div>

      @if($status == 'Kepala Dinas' || $status == 'Staf')
        <?php
          $laporan = $status == "Kepala Dinas" ? "Laporan" : "Riwayat Pekerjaan";
        ?>
        <x-nav-link :href="route('laporan',['status'=>$status])" :active="request()->is('laporan')">
          {{ $laporan }}
        </x-nav-link>
      @endif

      @if($status == "Admin")
        <x-nav-link :href="route('users.create')" :active="request()->is('tambahAkun')">Tambah Akun</x-nav-link>
      @endif
              @if ($status == 'Kepala Dinas')
            <x-nav-link href="{{ route('notifications') }}" :active="request()->is('notifications')">Notifikasi</x-nav-link>
        @endif

      <x-nav-link href="{{ route('mapping') }}" :active="request()->is('mapping')">Mapping</x-nav-link>
      <form method="POST" action="{{ route('logout') }}" id="logout-form">
    @csrf
    <button type="submit" class="w-full text-left">
        <x-nav-link :active="request()->is('logout')">
            Keluar
        </x-nav-link>
    </button>
</form>
    </div>
  </div>
</nav>
