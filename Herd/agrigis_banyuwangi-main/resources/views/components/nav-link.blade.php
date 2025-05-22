@props(['active'=>false])
<a {{ $attributes }} class="{{ $active ? 'bg-[#0D6106] text-white':'text-black hover:bg-[#579251]  hover:text-white' }} text-black font-bold  block px-3 py-2 rounded-md hover:bg-[#579251]  ">{{ $slot }}
</a>