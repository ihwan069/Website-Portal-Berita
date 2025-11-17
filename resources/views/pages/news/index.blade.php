@extends('layouts.app')

@section('title', 'Semua Berita')

@section('content')
  <div class="w-full mb-16 bg-[#F6F6F6]">
      <h1 class="text-center font-bold text-2xl p-24">Semua Berita</h1>
  </div>

  <!-- Berita -->
  <div class=" flex flex-col gap-5 px-4 lg:px-14">
    <div class="grid sm:grid-cols-1 gap-5 lg:grid-cols-4">
      @foreach ($news as $item_author)
      <a href="{{ route('news.show', $item_author->slug) }}">
        <div
          class="border border-slate-200 p-3 rounded-xl hover:border-primary hover:cursor-pointer transition duration-300 ease-in-out">
          <div class="bg-primary text-white rounded-full w-fit px-5 py-1 font-normal ml-2 mt-2 text-sm absolute" >
            {{ $item_author->newsCategory->title }}</div>
          <img src="{{ asset('storage/'. $item_author->thumbnail) }}" alt="gambar-artikel" class="w-full rounded-xl mb-3" style="width: 450px; object-fit: cover;">
          <p class="font-bold text-base mb-1">{{ \Str::limit($item_author->title, 30) }}</p>
          <p class="text-slate-400">{{ \Carbon\Carbon::parse($item_author->created_at)->format('d F Y') }}</p>
        </div>
      </a>
        @endforeach
      </div>
      {{ $news->links('vendor.pagination.custom') }}
    </div>
@endsection