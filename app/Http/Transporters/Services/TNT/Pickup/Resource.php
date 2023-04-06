<?php

namespace App\Http\Transporters\Services\TNT\Pickup;

use App\Http\Transporters\Services\TNT\TNTBaseResource;

class Resource extends TNTBaseResource
{
    /**
     * @return array
     */
    public function transform(): array
    {
        $data = [
            'date' => date('d-m-Y', strtotime($this->data->getShipmentDate()))
        ];

        $start = '01:00';
        $end = '23:30';

        $start = strtotime($start);
        $end = strtotime($end);
        $now = $start;

        $list = [];
        while ($now <= $end) {
            $time = date("H:i", $now);
            $list[$time] = $time;
            $now = strtotime('+15 minutes', $now);
        }

        $list['23:59'] = '23:59';

        $data['from'] = $list;

        $h = date('H');
        $m = date('i');

        if ($m > 30) {
            $m = 0;
            $h++;
        } else {
            $m = 30;
        }

        if ($h > 23)
            $h = 8;

        $m = (strlen($m) < 2) ? $m = '0' . $m : $m;
        for ($i = 1; $i <= 2 - strlen($m); $i++) {
            $m .= "0";
        }

        $data['from_selected'] = $h . ':' . $m;

        $start = '01:00';
        $end = '23:45';

        $start = strtotime($start);
        $end = strtotime($end);
        $now = $start;

        $list = [];

        while ($now <= $end) {
            $time = date("H:i", $now);
            $list[$time] = $time;
            $now = strtotime('+15 minutes', $now);
        }

        $list['23:59'] = '23:59';

        $data['until'] = $list;
        $data['until_selected'] = '17:00';

        return $data;
    }
}