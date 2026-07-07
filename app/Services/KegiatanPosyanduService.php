<?php

namespace App\Services;

use App\Repositories\KegiatanPosyanduRepository;
use Illuminate\Support\Facades\DB;

class KegiatanPosyanduService
{
    protected $repository;

    public function __construct(KegiatanPosyanduRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllKegiatan($perPage = 10)
    {
        return $this->repository->getAllPaginated($perPage);
    }

    public function getKegiatanById($id)
    {
        return $this->repository->findById($id);
    }

    public function createKegiatan(array $data)
    {
        return DB::transaction(function () use ($data) {
            if (isset($data['jenis_pelayanan']) && is_string($data['jenis_pelayanan'])) {
                // Since it's cast as array, it will be handled by model, but we ensure it's in array format if it comes from checkbox as array
            }
            if (!isset($data['status'])) {
                $data['status'] = 'Draft';
            }
            if (!isset($data['user_id'])) {
                $data['user_id'] = auth()->id();
            }
            if (!isset($data['penanggung_jawab'])) {
                $data['penanggung_jawab'] = auth()->user() ? auth()->user()->name : 'Sistem';
            }
            
            return $this->repository->create($data);
        });
    }

    public function updateKegiatan($id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            return $this->repository->update($id, $data);
        });
    }

    public function deleteKegiatan($id)
    {
        return $this->repository->delete($id);
    }
    
    public function updateStatus($id, $newStatus)
    {
        $allowedStatuses = ['Draft', 'Terjadwal', 'Berlangsung', 'Selesai', 'Dibatalkan'];
        if (in_array($newStatus, $allowedStatuses)) {
            return $this->repository->update($id, ['status' => $newStatus]);
        }
        throw new \Exception('Invalid status');
    }
}
