<?php

namespace App\Builders;

interface DataBuilderInterface
{
    public function setTimestamp($timestamp);
    public function setWitel($witel);
    public function setIdValins($idValins);
    public function setEviden1($eviden1);
    public function setEviden2($eviden2);
    public function setEviden3($eviden3);
    public function setIdValinsLama($idValinsLama);
    public function setApproveAso($approveAso);
    public function setKeteranganAso($keteranganAso);
    public function setRam3($ram3);
    public function setKeteranganRam3($keteranganRam3);
    public function setRekon($rekon);
    public function setIdEviden1($id1);
    public function setIdEviden2($id2);
    public function setIdEviden3($id3);
    public function build();
}
