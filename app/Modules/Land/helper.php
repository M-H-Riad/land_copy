<?php

function landCurrentStatusDropdown()
{
    $status = \App\Modules\Land\Models\Land::groupBy('current_status')->pluck('current_status', 'current_status');
    return $status ? $status->toArray() : [];
}

function landKhajnaDropdown()
{
    $khajna = \App\Modules\Land\Models\Land::groupBy('khajna')->pluck('khajna', 'khajna');
    return $khajna ? $khajna->toArray() : [];
}

function landNamjariDropdown()
{
    $namjari = \App\Modules\Land\Models\Land::groupBy('namjari')->pluck('namjari', 'namjari');
    return $namjari ? $namjari->toArray() : [];
}