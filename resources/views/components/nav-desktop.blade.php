<aside class="w-66 h-[100vh] bg-[#DDFFAC] z-20 fixed flex-shrink-0 hidden rounded-tr-3xl md:block">
  <div class="h-16 flex items-center justify-center  border-b-[6px] border-[#F1FFDE] font-bold text-xl text-[#0D6106]">
      MENU
  </div>

  <div class="px-4 py-6 space-y-4"> 
    <div class="flex items-center space-x-3">
        <img src="{{ $img }}" alt="User" class="w-10 h-10 rounded-full" />

              <div>
                  <div class="block rounded-md px-3 py-2 text-black">{{ $name }}</div>

                  <div class="block rounded-md px-3 py-1 text-black">
                      @if ($status == 'Kepala Dinas')
                          {{ "Kepala Dinas" }}
                      @elseif ($status == 'Staf')
                          {{ "Staf Lapangan" }}
                      @elseif ($status == 'Admin')
                          {{ "Admin" }}
                      @endif
                  </div>
              </div>
    </div>
    <x-nav-link href="{{ route('mapping') }}" :active="request()->is('mapping')">Mapping</x-nav-link>
      @if ($status == 'Kepala Dinas' || $status == 'Staf')
          <?php
          $laporan = "Riwayat Pekerjaan";
          if ($status == "Kepala Dinas") {
              $laporan = "Laporan";
          }
          ?>
          <x-nav-link :href="route('laporan', ['status' => $status])" :active="request()->is('laporan')">
              {{ $laporan }}
          </x-nav-link>
      @endif

      @if ($status == "Admin")
          <x-nav-link href="{{ route('users.create') }}" :active="request()->is('tambahAkun')">Tambah Akun</x-nav-link>
      @endif
        @if ($status == 'Kepala Dinas')
            <x-nav-link href="{{ route('notifications') }}" :active="request()->is('notifications')">Notifikasi</x-nav-link>
        @endif


      <div >
          <div class="mt-3 space-y-2 text-sm">
              <x-nav-link href="{{route('profile')  }}" :active="request()->is('profile')">Akun Profil</x-nav-link>
              <x-nav-link href="#" :active="request()->is('#')">Keluar</x-nav-link>
          </div>
      </div>
  </div>
</aside>
