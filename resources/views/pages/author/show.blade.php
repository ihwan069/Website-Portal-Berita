@extends('layouts.app')

@section('title', $author->user->name)
    
@section('content')
    <!-- Author -->
    <div class="flex gap-4 items-center mb-10 text-white p-10 bg-cover" style="background-image: url('{{ asset('assets/img/bg-profile.png') }}')">
      @if ($author->avatar === null)
          {{-- SVG default kalau avatar kosong --}}
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
              stroke-width="1.5" stroke="currentColor" 
              class="rounded-full max-w-28 text-gray-400">
              <path stroke-linecap="round" stroke-linejoin="round"
                    d="M17.982 18.725A7.488 7.488 0 0 0 12 
                      15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 
                      0a9 9 0 1 0-11.963 0m11.963 
                      0A8.966 8.966 0 0 1 12 
                      21a8.966 8.966 0 0 1-5.982-2.275M15 
                      9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
          </svg>
      @else
          {{-- Tampilkan foto dari storage kalau ada --}}
          <img src="{{ asset('storage/' . $author->avatar) }}" 
              alt="profile" 
              class="rounded-full max-w-28 object-cover">
      @endif

      <div class="">
        <p class="font-bold text-lg">{{ $author->user->name }}</p>
        <p>{{ $author->bio }}</p>
      </div>
    </div>

    <!-- Berita -->
    <div class=" flex flex-col gap-5 px-4 lg:px-14">
      <div class="grid sm:grid-cols-1 gap-5 lg:grid-cols-4">
        @foreach ($author->news as $item_author)
        <a href="{{ route('news.show', $item_author->slug) }}">
          <div
            class="border border-slate-200 p-3 rounded-xl hover:border-primary hover:cursor-pointer transition duration-300 ease-in-out">
            <div class="bg-primary text-white rounded-full w-fit px-5 py-1 font-normal ml-2 mt-2 text-sm absolute" >
              {{ $item_author->newsCategory->title }}</div>
            <img src="{{ asset('storage/'. $item_author->thumbnail) }}" alt="" class="w-full rounded-xl mb-3" style="width: 450px; object-fit: cover;">
            <p class="font-bold text-base mb-1">{{ \Str::limit($item_author->title, 30) }}</p>
            <p class="text-slate-400">{{ \Carbon\Carbon::parse($item_author->created_at)->format('d F Y') }}</p>
          </div>
        </a>
          @endforeach
      </div>

      </div>
    </div>
@endsection