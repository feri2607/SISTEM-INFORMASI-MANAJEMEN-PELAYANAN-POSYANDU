<?php
// app/Http/Controllers/ScheduleController.php

namespace App\Http\Controllers;

use App\Models\KegiatanPosyandu;
use App\Models\KehadiranKegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $query = KegiatanPosyandu::with(['user', 'kehadiran'])
            ->where('status', '!=', 'dibatalkan');

        // Filter berdasarkan bulan
        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        }

        // Filter berdasarkan tahun
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        }

        // Filter berdasarkan lokasi
        if ($request->filled('lokasi')) {
            $query->where('lokasi', 'like', '%' . $request->lokasi . '%');
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_kegiatan', 'like', '%' . $search . '%')
                  ->orWhere('lokasi', 'like', '%' . $search . '%')
                  ->orWhere('penanggung_jawab', 'like', '%' . $search . '%');
            });
        }

        // Urutkan berdasarkan tanggal terdekat
        $query->orderBy('tanggal', 'asc')
              ->orderBy('jam_mulai', 'asc');

        // Pagination
        $kegiatan = $query->paginate(9);

        // Data untuk filter
        $months = [];
        for ($m = 1; $m <= 12; $m++) {
            $months[$m] = date('F', mktime(0, 0, 0, $m, 1));
        }

        $years = KegiatanPosyandu::selectRaw('DISTINCT YEAR(tanggal) as year')
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();

        $lokasiList = KegiatanPosyandu::select('lokasi')
            ->distinct()
            ->pluck('lokasi')
            ->toArray();

        // Data untuk kalender - ambil dari request atau default
        $month = $request->bulan ?? date('m');
        $year = $request->tahun ?? date('Y');
        $calendarData = $this->getCalendarData($month, $year);

        return view('public.schedule', compact(
            'kegiatan',
            'months',
            'years',
            'lokasiList',
            'calendarData'
        ));
    }

    public function show($id)
    {
        $kegiatan = KegiatanPosyandu::with(['user', 'kehadiran.user'])
            ->findOrFail($id);

        $isTerdaftar = $kegiatan->is_user_terdaftar;
        $isHadir = $kegiatan->is_user_hadir;

        return view('public.schedule-detail', compact('kegiatan', 'isTerdaftar', 'isHadir'));
    }

    public function konfirmasiKehadiran(Request $request, $id)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Silakan login terlebih dahulu.',
            ], 401);
        }

        $kegiatan = KegiatanPosyandu::findOrFail($id);

        // Cek kuota
        if ($kegiatan->kuota && $kegiatan->is_penuh) {
            return response()->json([
                'success' => false,
                'message' => 'Maaf, kuota kegiatan sudah penuh.',
            ], 400);
        }

        // Cek apakah sudah terdaftar
        $kehadiran = KehadiranKegiatan::where('kegiatan_id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if ($kehadiran) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah terdaftar untuk kegiatan ini.',
            ], 400);
        }

        // Simpan konfirmasi
        KehadiranKegiatan::create([
            'kegiatan_id' => $id,
            'user_id' => Auth::id(),
            'konfirmasi_at' => now(),
            'status' => 'terdaftar',
        ]);

        // Clear cache
        Cache::forget('schedule_stats');

        return response()->json([
            'success' => true,
            'message' => 'Berhasil konfirmasi kehadiran!',
        ]);
    }

    public function batalKonfirmasi(Request $request, $id)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Silakan login terlebih dahulu.',
            ], 401);
        }

        $kehadiran = KehadiranKegiatan::where('kegiatan_id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$kehadiran) {
            return response()->json([
                'success' => false,
                'message' => 'Anda belum terdaftar untuk kegiatan ini.',
            ], 400);
        }

        $kehadiran->delete();

        // Clear cache
        Cache::forget('schedule_stats');

        return response()->json([
            'success' => true,
            'message' => 'Berhasil membatalkan konfirmasi.',
        ]);
    }

    private function getCalendarData($month, $year)
    {
        $startDate = date('Y-m-01', strtotime("$year-$month-01"));
        $endDate = date('Y-m-t', strtotime("$year-$month-01"));

        $events = KegiatanPosyandu::where('status', '!=', 'dibatalkan')
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->get(['tanggal', 'nama_kegiatan', 'status', 'lokasi', 'id'])
            ->groupBy(function ($item) {
                return $item->tanggal->format('Y-m-d');
            });

        // Format untuk kalender
        $formattedEvents = [];
        foreach ($events as $date => $items) {
            $formattedEvents[$date] = $items->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nama_kegiatan' => $item->nama_kegiatan,
                    'status' => $item->status,
                    'lokasi' => $item->lokasi,
                ];
            })->toArray();
        }

        return [
            'month' => (int)$month,
            'year' => (int)$year,
            'events' => $formattedEvents,
        ];
    }

    public function getEvents(Request $request)
    {
        $month = $request->month ?? date('m');
        $year = $request->year ?? date('Y');

        $calendarData = $this->getCalendarData($month, $year);

        return response()->json($calendarData);
    }
}