<?php

namespace App\Notifications;

use App\Models\PemeriksaanBalita;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class HasilPemeriksaanNotification extends Notification
{
    use Queueable;

    protected $pemeriksaan;

    public function __construct(PemeriksaanBalita $pemeriksaan)
    {
        $this->pemeriksaan = $pemeriksaan;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        $balita = $this->pemeriksaan->balita;
        return [
            'type' => 'pemeriksaan_balita',
            'title' => 'Hasil Pemeriksaan Baru: ' . $balita->nama,
            'message' => 'Hasil pemeriksaan tanggal ' . $this->pemeriksaan->tanggal_pemeriksaan->format('d M Y') . ' telah diinput. Status gizi: ' . ucfirst($this->pemeriksaan->status_gizi),
            'url' => route('warga.balita.show', $balita->id),
            'pemeriksaan_id' => $this->pemeriksaan->id,
            'balita_id' => $balita->id,
        ];
    }
}
