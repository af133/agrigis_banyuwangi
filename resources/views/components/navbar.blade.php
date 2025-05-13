
<x-nav-desktop>
    <x-slot:img>
      {{ $dataUser['path_img'] }}
    </x-slot:img>
    <x-slot:status>
      {{ $dataUser['status'] }}
    </x-slot:status>
    <x-slot:name>{{ $dataUser['nama'] }}</x-slot:name>
    <x-slot:email>{{ $dataUser['email'] }}</x-slot:email>
  </x-nav-desktop>
  
  
  <x-nav-phone>
    <x-slot:status>
      <x-slot:img>
        {{ $dataUser['path_img'] }}
      </x-slot:img>
      {{ $dataUser['status'] }}
    </x-slot:status>
    <x-slot:name>{{ $dataUser['nama'] }}</x-slot:name>
    <x-slot:email>{{ $dataUser['email'] }}</x-slot:email>
</x-nav-phone>