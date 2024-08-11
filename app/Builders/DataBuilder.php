<?php

namespace App\Builders;

use App\Models\Data;

class DataBuilder implements DataBuilderInterface
{
    protected $data;
    public function __construct()
    {
        $this->data = [];
    }
    public function setTimestamp($timestamp)
    {
        $this->data['timestamp_bawaan'] = $timestamp;
        return $this;
    }
    public function setWitel($witel)
    {
        $this->data['witel'] = $witel;
        return $this;
    }
    public function setIdValins($idValins)
    {
        $this->data['id_valins'] = $idValins;
        return $this;
    }
    public function setEviden1($eviden1)
    {
        $this->data['eviden1'] = $eviden1;
        return $this;
    }
    public function setEviden2($eviden2)
    {
        $this->data['eviden2'] = $eviden2;
        return $this;
    }
    public function setEviden3($eviden3)
    {
        $this->data['eviden3'] = $eviden3;
        return $this;
    }
    public function setIdValinsLama($idValinsLama)
    {
        $this->data['id_valins_lama'] = $idValinsLama;
        return $this;
    }
    public function setApproveAso($approveAso)
    {
        $this->data['approve_aso'] = $approveAso;
        return $this;
    }

    public function setKeteranganAso($keteranganAso)
    {
        $this->data['keterangan_aso'] = $keteranganAso;
        return $this;
    }

    public function setRam3($ram3)
    {
        $this->data['ram3'] = $ram3;
        return $this;
    }

    public function setKeteranganRam3($keteranganRam3)
    {
        $this->data['keterangan_ram3'] = $keteranganRam3;
        return $this;
    }

    public function setRekon($rekon)
    {
        $this->data['rekon'] = $rekon;
        return $this;
    }

    public function setIdEviden1($id1)
    {
        $this->data['id_eviden1'] = $id1;
        return $this;
    }

    public function setIdEviden2($id2)
    {
        $this->data['id_eviden2'] = $id2;
        return $this;
    }

    public function setIdEviden3($id3)
    {
        $this->data['id_eviden3'] = $id3;
        return $this;
    }

    public function build()
    {
        return Data::create($this->data);
    }
}
