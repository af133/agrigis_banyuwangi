@extends('layout.app')
@section('content')
<div class="bg-white shadow-lg rounded-lg w-90% ml-8 mr-8  p-8">
    <h2 class="text-2xl font-semibold text-gray-700 text-center mb-6">Tambah Akun</h2>
    @php
        $dataUser=session('dataUser')
    @endphp
    @if(session('success'))
    <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
        {{ session('success') }}
    </div>
    @endif
    {{-- action="{{ route('users.store') }}" --}}
    <form id="akunForm"  method="POST" class="space-y-5">
        @csrf
        
        <div>
            <label class="block text-sm text-gray-600 mb-1">Nama</label>
            <input type="text" name="name" id="name" readonly
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-400"
            value="{{ $dataUser['nama'] }}">
        </div>

        <div>
            <label class="block text-sm text-gray-600 mb-1">Email</label>
            <input type="email" name="email" id="email" readonly
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-400"
            value="{{ $dataUser['email'] }}">
        </div>

        <div>
            <label class="block text-sm text-gray-600 mb-1">Password</label>
            <input type="password" name="password" id="password" readonly
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-400"
            value="{{ $dataUser['password ']}}">
        </div>
        
        <div>
            <label class="block text-sm text-gray-600 mb-1">Status</label>
            <input type="text" name="status" id="status" readonly
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-400"
            value="{{ $dataUser['status'] }}">
        </div>
        
        <div class="flex justify-end space-x-3">
            <button type="button" id="editBtn"
                    class="bg-gray-700 hover:bg-gray-800 text-white px-5 py-2 rounded-lg transition duration-200">
                Edit
            </button>
            <button type="submit" id="saveBtn"
                    class="hidden bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg transition duration-200">
                Save
            </button>
            <button type="button" id="cancelBtn"
                    class="hidden bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded-lg transition duration-200">
                Cancel
            </button>
        </div>
    </form>
</div>
@endsection