@extends('layouts.app')

@section('title', 'IhwNews | Baca Berita')
    
@section('content')
    <!-- swiper -->
    <div class="swiper mySwiper mt-9">
      <div class="swiper-wrapper">

        @foreach ($banners as $banner)
        <div class="swiper-slide">
          <a href="{{ route('news.show', $banner->news->slug) }}" class="block">
            <div
              class="relative flex flex-col gap-1 justify-end p-3 h-72 rounded-xl bg-cover bg-center overflow-hidden" 
              style="background-image: url('{{ asset('storage/' . $banner->news->thumbnail ) }}')"
              >
              <div
                class="absolute inset-x-0 bottom-0 h-full bg-gradient-to-t from-[rgba(0,0,0,0.4)] to-[rgba(0,0,0,0)] rounded-b-xl">
              </div>
              <div class="relative z-10 mb-3" style="padding-left: 10px;">
                <div class="bg-primary text-white text-xs rounded-lg w-fit px-3 py-1 font-normal mt-3">{{ $banner->news->newsCategory->title }}</div>
                <p class="text-3xl font-semibold text-white mt-1">{{ $banner->news->title }}</p>
                <div class="flex items-center gap-1 mt-1">

                @if ($banner->news->author->avatar === null)
                    {{-- SVG default jika avatar kosong --}}
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" 
                        class="w-5 h-5 rounded-full text-gray-400">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M17.982 18.725A7.488 7.488 0 0 0 12 
                                15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 
                                0a9 9 0 1 0-11.963 0m11.963 
                                0A8.966 8.966 0 0 1 12 
                                21a8.966 8.966 0 0 1-5.982-2.275M15 
                                9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                @else
                    {{-- Tampilkan foto avatar --}}
                    <img src="{{ asset('storage/' . $banner->news->author->avatar) }}" 
                        alt="User_img" 
                        class="w-5 h-5 rounded-full object-cover">
                @endif

                  <p class="text-white text-xs">{{ $banner->news->author->user->name }}</p>
                </div>
              </div>
            </div>
          </a>
        </div>
        @endforeach

      </div>
    </div>

    <!-- Berita Unggulan -->
    <div class="flex flex-col px-14 mt-10 ">
      <div class="flex flex-col md:flex-row justify-between items-center w-full mb-6">
        <div class="font-bold text-2xl text-center md:text-left">
          <p>Berita Unggulan</p>
          <p>Untuk Kamu</p>
        </div>
        <a href="{{ route('news.index')}}"
          class="bg-primary px-5 py-2 rounded-full text-white font-semibold mt-4 md:mt-0 h-fit">
          Lihat Semua
        </a>
      </div>
      <div class="grid sm:grid-cols-1 gap-5 lg:grid-cols-4">
        {{-- ini untuk perulangan berita --}}
        @foreach ($featureds as $featured)
        <a href="{{route('news.show', $featured->slug)}}">
          <div
          class="border border-slate-200 p-3 rounded-xl hover:border-primary hover:cursor-pointer transition duration-300 ease-in-out">
          <div class="bg-primary text-white rounded-full w-fit px-5 py-1 font-normal ml-2 mt-2 text-sm absolute">
            {{ $featured->newsCategory->title }}</div>
            <img src="{{ asset('storage/' . $featured->thumbnail) }}" alt="Berita-Liburan" class="w-full rounded-xl mb-3">
            <p class="font-bold text-base mb-1">{{ \Str::limit($featured->title, 30) }}</p>
            <p class="text-slate-400">{{ \Carbon\Carbon::parse($featured->created_at)->format('d F Y') }}</p>
          </div>
        </a>
        @endforeach

      </div>
    </div>

    <!-- Berita Terbaru -->
    <div class="flex flex-col px-4 md:px-10 lg:px-14 mt-10">
      <div class="flex flex-col md:flex-row w-full mb-6">
        <div class="font-bold text-2xl text-center md:text-left">
          <p>Berita Terbaru</p>
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-12 gap-5">
        <!-- Berita Utama -->
        <div
          class="relative col-span-7 lg:row-span-3 border border-slate-200 p-3 rounded-xl hover:border-primary hover:cursor-pointer">
          <a href="{{ route('news.show', $news[0]->slug) }}">
            <div class="bg-primary text-white rounded-full w-fit px-4 py-1 font-normal ml-5 mt-5 absolute">{{ $news[0]->newsCategory->title }}
            </div>
            <img src="{{ asset('storage/' . $news[0]->thumbnail) }}" alt="berita1" class="rounded-2xl">
            <p class="font-bold text-xl my-4">{{ $news[0]->title }}</p>
            <p class="text-slate-400 text-base mt-1">{!! 
            \Str::limit($news[0]->content, 150) !!}</p>
            <p class="text-slate-400 text-base mt-1">{{ \Carbon\Carbon::parse($news[0]->created_at)->format('d F Y') }}</p>
          </a>
        </div>

        <!-- Berita kecil -->
        @foreach ($news->skip(1) as $news_item)
        <a href="{{ route('news.show',  $news_item->slug)}}"
          class="relative col-span-5 flex flex-col h-fit md:flex-row gap-3 border border-slate-200 p-3 rounded-xl hover:border-primary hover:cursor-pointer">
          <div class="bg-primary text-white rounded-full w-fit px-4 py-1 font-normal ml-2 mt-2 absolute text-sm">
            {{ $news_item->newsCategory->title }}</div>
          <img src="{{ asset('storage/' . $news_item->thumbnail)}}" alt="thumbnail" class="rounded-xl w-full md:max-h-48" style="width: 255px; object-fit: cover;">
          <div class="mt-2 md:mt-0">
            <p class="font-semibold text-lg">{{ $news_item->title }}</p>
            <p class="text-slate-400 mt-3 text-sm font-normal">{!! \Str::limit($news_item->meta_description, 50) !!}</p>
          </div>
        </a>
        @endforeach
      </div>
    </div>

    <!-- Author -->
    <div class="flex flex-col px-4 md:px-10 lg:px-14 mt-10">
      <div class="flex flex-col md:flex-row justify-between items-center w-full mb-6">
        <div class="font-bold text-2xl text-center md:text-left">
          <p>Kenali Author Terbaik Kami</p>
        </div>
        <a href="admin/register" class="bg-primary px-5 py-2 rounded-full text-white font-semibold mt-4 md:mt-0 h-fit">
          Gabung Menjadi Author
        </a>
      </div>
      <div class="grid grid-cols-1  sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">

        <!-- Authors -->
        @foreach ($authors as $author)
        <a href="{{ route('author.show', $author->username)}}">
          <div
            class="flex flex-col items-center border border-slate-200 px-4 py-8 rounded-2xl hover:border-primary hover:cursor-pointer">

            @if ($author->avatar === null)
                {{-- Tampilkan SVG default --}}
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" class="w-24 h-24 text-gray-400">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 
                            0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 
                            21a8.966 8.966 0 0 1-5.982-2.275M15 
                            9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
            @else
                {{-- Jika ada avatar --}}
                <img src="{{ asset('storage/' . $author->avatar) }}" 
                    alt="profile-author" 
                    class="rounded-full w-24 h-24 object-cover">
            @endif
            
            <p class="font-bold text-xl mt-4">{{ $author->user->name }}</p>
            <p class="text-slate-400">{{ $author->news->count() . ' Berita' }}</p>
          </div>
        </a>
        @endforeach
      </div>
    </div>

    <!-- Pilihan Author -->
    <div class="flex flex-col px-14 mt-10 mb-10">
      <div class="flex flex-col md:flex-row justify-between items-center w-full mb-6">
        <div class="font-bold text-2xl text-center md:text-left">
          <p>Pilihan Author</p>
        </div>
      </div>
      <div class="grid sm:grid-cols-1 gap-5 lg:grid-cols-4">
        @foreach ($news as $item)
        <a href="{{ route('news.show', $item->slug) }}">
          <div
            class="border border-slate-200 p-3 rounded-xl hover:border-primary hover:cursor-pointer transition duration-300 ease-in-out">
            <div class="bg-primary text-white rounded-full w-fit px-5 py-1 font-normal ml-2 mt-2 text-sm absolute">
              {{ $item->newsCategory->title }}</div>
            <img src="{{ 'storage/'. $item->thumbnail }}" alt="gambar-pilihan-author" class="w-full rounded-xl mb-3">
            <p class="font-bold text-base mb-1">{{ \Str::limit($item->title, 30) }}</p>
            <p class="text-slate-400"> {{ \Carbon\Carbon::parse($item->created_at)->format('d F Y') }}</p>
          </div>
        </a>
        @endforeach
        
      </div>
    </div>
@endsection
    