{{-- resources/views/public/home.blade.php --}}

@extends('layouts.public')

@section('title', 'Sistem Informasi Posyandu Digital - Beranda')
@section('description', 'Sistem Informasi Posyandu Digital - Mendukung pelayanan kesehatan ibu dan anak yang lebih cepat, mudah, transparan, dan terintegrasi.')

@section('content')
    {{-- Hero Section --}}
    <x-public.hero />

    {{-- Statistik --}}
    <x-public.stats :stats="$stats" />

    {{-- Tentang Posyandu --}}
    <x-public.about />

    {{-- Layanan Posyandu --}}
    <x-public.services />

    {{-- Jadwal Posyandu --}}
    <x-public.schedules :activities="$upcomingActivities" />

    {{-- Artikel Edukasi --}}
    <x-public.articles :artikels="$artikels" />

    {{-- Berita --}}
    <x-public.news :beritas="$beritas" />

    {{-- Pengumuman --}}
    <x-public.announcements :pengumumans="$pengumumans" />

    {{-- Call To Action --}}
    <x-public.cta />
@endsection