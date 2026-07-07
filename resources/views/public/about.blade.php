{{-- resources/views/public/about.blade.php --}}

@extends('layouts.public')

@section('title', 'Tentang Posyandu - Sistem Informasi Posyandu Digital')
@section('description', 'Mengenal Posyandu sebagai pusat pelayanan kesehatan ibu dan anak yang berperan dalam meningkatkan kualitas kesehatan masyarakat.')

@section('content')
    {{-- Hero --}}
    <x-public.about.hero :about="$about" />

    {{-- Profil --}}
    <x-public.about.profile :about="$about" />

    {{-- Sejarah --}}
    <x-public.about.history :about="$about" />

    {{-- Visi --}}
    <x-public.about.vision :about="$about" />

    {{-- Misi --}}
    <x-public.about.mission :about="$about" />

    {{-- Tujuan --}}
    <x-public.about.goals :about="$about" />

    {{-- Nilai-nilai --}}
    <x-public.about.values :nilai="$nilai" />

    {{-- Layanan --}}
    <x-public.about.services :services="$services" />

    {{-- Struktur Organisasi --}}
    <x-public.about.organization :struktur="$struktur" />

    {{-- Statistik --}}
    <x-public.about.stats :stats="$stats" />

    {{-- Galeri --}}
    <x-public.about.gallery :galeri="$galeri" />

    {{-- Lokasi --}}
    <x-public.about.location :about="$about" />

    {{-- Call to Action --}}
    <x-public.about.cta />
@endsection