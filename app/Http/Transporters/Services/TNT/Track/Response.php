<?php

namespace App\Http\Transporters\Services\TNT\Track;

use App\Http\Transporters\Requests\TransporterRequestInterface;
use App\Http\Transporters\Responses\TransporterResponseAbstract;

class Response extends TransporterResponseAbstract
{

    public $types = ['picked', 'delivered'];
    public $status_codes = [
        'error' => ['WA','AR','LP','WAH','AP','WAS','CD','WAT','WAN','AP','WAP','WAD','WAI','PWN','PR','WAM','NR','OS','WD','AN','EO','BW',
        'DG','CX','WL','CA','RU','RWA','ENA','MC','CO','DC','LAI','WE','LXA','HO','LXC','LXW','LEI','DPU','NH','DW','C1D','C2D','MRI','LM',
        'LMP','MT','DPC','AA','CP','HMF','CR','HOT','CS','UD','RO','RTS','UP','CV','RH','LXB','UC','LXI','LXL','LXN','LXO','LXT','NHM','CRI',
        'OKC','MR','CRP','CRE','CRL','CRC','LC','CRN','OI','CRO','CRS','NT','NTT','DQ','WR','CIM','VB','RDH','PNR','BSH','UPR','LPD','DB','HD',
        'IC','HI','IG','C1P','C1M','C2P','C2M','CRT','CRD','LCP','ORD','PUC','UA','UE','UNF','CRF','UVC','CRA'
        ],
        'picked' => ['ADM','MP','CI','BSN','C1N','CM','MOP','C2N','TR','HW','TUL','DH','SH','CZ','CAR','DNR','HPR','LUR','PAC','DIT','LAW','DPH','RC',
        'RCO','LEW','ECC','HW','MTI','MOR','FB','MOB','BM','BF','PC','NHG','HH','C1A','C1C','OD','C2A','C2C','PAM','DLM','TUC','MRC','FDB','WDB',
        'FR','IR','IS','LAB','LAO','LEB','LEO','MCA','MCB','MLA','MLH','MLL','MLO','MLX','MNA','MOC','MOD','MOI','MOO','MOU','MRA','MTB','MTC',
        'MTL','MTO','MTU','NBM','ODM','OF','PL','PU','DPA','RDM','CCI','PCB','FDC','WDC','CDC','PCC','PLC','CNC','CNB','BSA','BSC','NPD','RDR',
        'AS','CDB','ID','HP','ITC', 'DS'
        ],
        'delivered' => ['OK','RES','CMD','CDD','DN','ATL','PA','DM','DPN','HBD','PM','RGC','VC','HB'],
    ];

    /**
     * @var TransporterRequestInterface
     */
    public $request;

    /**
     * @var object|null
     */
    protected $data;

    /**
     * Response constructor.
     * @param $data
     * @param TransporterRequestInterface $request
     */
    public function __construct($data, TransporterRequestInterface $request) {
        $this->data = $this->xmlToObject($data);
        $this->request = $request;
    }

    /**
     * @return bool
     */
    public function isSuccess(): bool {
        if(!isset($this->data->Consignment) || !isset($this->data->Consignment->CollectionDate)) {
            return false;
        }
        return true;
    }

    /**
     * @return string
     */
    public function getMessage(): string {
        return 'Tracking number not found?';
    }

    /**
     * @return int
     */
    public function getStatusCode(): int {
        return 200;
    }

    /**
     * @return int
     */
    public function getData() {
        return $this->data;
    }

	public function getStatus(){

		$status = (is_array($this->data->Consignment->StatusData) ? $this->data->Consignment->StatusData[0] : $this->data->Consignment->StatusData);
		$code = $status->StatusCode;

		if (in_array($code, $this->status_codes['delivered'])) return 'delivered';
		if (in_array($code, $this->status_codes['picked'])) return 'picked';
		if (in_array($code, $this->status_codes['error'])) return 'error';
		return 'none';

	}

    public function getStatusses() {
        $statusses = [];

        try {
        if (is_array($this->data->Consignment)) {
            $activities = $this->data->Consignment[0]->StatusData;
        } else {
            $activities = $this->data->Consignment->StatusData;
        }
        } catch (\Exception $e) {
            return [
                'error' => false,
                'message' => r('Deze zending beschikt (nog) niet over tracking informatie.')
            ];
        }

        $response = [
            'created' => null,
            'picked' => null,
            'delivered' => null,
            'error' => false,
        ];

    	if (!is_array($activities)){
            $activities = array($activities);
	    }

        if (!isset($activities[0])) {
            return [
                'error' => true,
                'message' => r('De opgegeven tracking code is niet (meer) geldig.')
            ];
        }

        foreach ($activities as $key => $event) {
            $datetime = \Carbon\Carbon::parse($event->LocalEventDate . ' ' . $event->LocalEventTime);
            
            // determine if the last status is an error
            if ($key == 0) {
                if (in_array($event->StatusCode, $this->status_codes['error'])) {
                    $response['error'] = true;
                    $response['message'] = $event->StatusDescription;
                }
            }

            foreach ($this->types as $type) {

                if (in_array($event->StatusCode, $this->status_codes[$type])) {
                    if ($response[$type] !== null) {
                        if ($response[$type] > $datetime->toDateTimeString()) {
                            $response[$type] = $datetime->toDateTimeString();
                        }
                    } else {
                        $response[$type] = $datetime->toDateTimeString();
                    }
                }
                
            }
            
            $status = [
                'status' => [
                    'code' => $event->StatusCode ?? '',
                    'description' => $event->StatusDescription ?? '',
                ],
                'date' => [
                    'date' => $datetime->toDateString(),
                    'time' => $datetime->toTimeString(),
                    'datetime' => $datetime->toDateTimeString(),
                ],
                'location' => [
                    'depot' => $event->Depot ?? '',
                    'depotname' => $event->DepotName ?? '',
                ]
            ];

            $statusses[$key] = $status;
            
        }

        $response['statusses'] = $statusses;
        if ($response['error'] == false) {
            $response['message'] = r('De tracking informatie is bijgewerkt.');
        }
        return $response;
    }

}