<?php

namespace App\Http\Transporters\Services\UPS\Track;

use App\Http\Transporters\Requests\TransporterRequestInterface;
use App\Http\Transporters\Responses\TransporterResponseAbstract;

class Response extends TransporterResponseAbstract
{

    public $types = ['picked', 'delivered', 'created'];
    public $status_codes = [
        'error' => ["01","02","11","13","14","29","2B","2X","3N","48","49","4P","4R","4S","4Z","51","52","5D","5T","8K","8L","99","AX","C4","C8","03","04","05","06","07","08","15","16","17","18","19","22","23","24","25","26","27","2A","2Y","2Z","31","34","3A","\r\n\t 3B","3C","45","46","47","60","67","6E","71","7H","7M","7N","7P","7R","7S","7T","7V","7W","7X","7Y","7Z","87","8A","8R","90","A6","A8","AA","AC","AD","AE","AF","AJ","AK","AO","AW","B3","B4","B5","B8","B9","BB","BD","BE","BF","BG","BH","BJ","BK","BQ","BR","BT","\r\n\t BW","BX","C3","C5","C6","C7","C9","CC","CF","CM","CN","CP","CQ","CV","CX","CY","CZ","D1","D4","DB","DC","DD","DF","DG","DH","DJ","DQ","DR","DT","DU","DY","E1","E3","E4","E8","E9","ED","EH","EN","ER","ES","EU","EX","FA","FW","G6","G8","G9","GH","GI","H1","H2","\r\n\t H3","H4","H5","H6","HA","HK","HO","HQ","I2","K1","K2","LE","LF","LQ","LV","MI","MT","O3","OM","OQ","OS","OT","R5","RB","RC","RD","RE","RI","RJ","RP","RY","RZ","S1","S5","S8","S9","SI","SJ","SK","SN","SR","SS","TD","TF","TJ","TN","TU","UF","UM","UP","VI","\r\n\t VJ","VL","X2","X3","X4","X8","XB","XN","XQ","XR","XS","XU","XY","XZ","Y2","YI","YV","AG","AT","CA","CD","CK","CL","DS"],
        'picked' => ['HF','PU','OF',"OR", "DP", "SR", "1C", "7F", "51", "AZ", "DS", "AR", "IP", "G9", "WH"],
        'delivered' => ["DL", 'KB','2Q', '9E', 'F4', 'HC', 'LG', 'LK', 'ZP', '40', '5E', '7L', 'D', 'FS', 'KD'],
        'created' => ['MP']
    ];

    /**
     * @var TransporterRequestInterface
     */
    public $request;

    /**
     * @var array|null
     */
    protected $data;

    /**
     * Response constructor.
     * @param $data
     * @param TransporterRequestInterface $request
     */
    public function __construct($data, TransporterRequestInterface $request) {
        $this->data = $data;
        $this->request = $request;
    }

    /**
     * @return bool
     */
    public function isSuccess(): bool {
        if(isset($this->data->Response->ResponseStatus->Code) && $this->data->Response->ResponseStatus->Code) {
            return true;
        }

        return false;
    }


	public function getStatusCode(){
    	return 0;
	}

    /**
     * @return string
     */
    public function getMessage(): string {
        return '';
    }

    /**
     * @return array
     */
    public function getData(): array {
        if(!is_array($this->data)) {
            return (array) $this->data;
        }

        return $this->data;
    }

    public function getStatus($extended = false){
    	$activity = $this->data->Shipment->Package->Activity;

    	if (is_array($activity)){
            $activity =  $activity[0];
	    }

        $status = $activity->Status ?? '';

    	if (isset($status->Type) && $status->Description == 'Delivered'){
			return 'delivered';
	    }

    	$code = $status->Code;

    	echo 'UPS CODE RESPONSE e:' . $code . '<br />';

        if (!$extended) {
            if (in_array($code, $this->status_codes['delivered'])) return 'delivered';
            if (in_array($code, $this->status_codes['picked'])) return 'picked';
            if (in_array($code, $this->status_codes['error'])) return 'error';
            return 'none';
        }
    }

    public function getStatusses() {
        $statusses = [];
        $activities = $this->data->Shipment->Package->Activity;

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

        foreach ($activities as $key => $activity) {
            $datetime = \Carbon\Carbon::parse($activity->Date . ' ' . $activity->Time);
            
            // determine if the last status is an error
            if ($key == 0) {
                if (in_array($activity->Status->Code, $this->status_codes['error'])) {
                    $response['error'] = true;
                    $response['message'] = $activity->Status->Description;
                }
            }

            foreach ($this->types as $type) {
                if (in_array($activity->Status->Code, $this->status_codes[$type])) {
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
                    'type' => $activity->Status->Type,
                    'code' => $activity->Status->Code,
                    'description' => $activity->Status->Description,
                ],
                'date' => [
                    'date' => $datetime->toDateString(),
                    'time' => $datetime->toTimeString(),
                    'datetime' => $datetime->toDateTimeString(),
                ],
                'location' => [
                    'addressline' => $activity->ActivityLocation->AddressLine ?? '',
                    'city' => $activity->ActivityLocation->City ?? '',
                    'postalcode' => $activity->ActivityLocation->PostalCode ?? '',
                    'countrycode' => $activity->ActivityLocation->CountryCode ?? '',
                ]
            ];

           
            if (isset($activity->Document)) {
                $documents = $activity->Document;
                if (!is_array($documents)) {
                    $documents = array($documents);
                }
                foreach ($documents as $key => $document) {
                    $response['documents'][] = [
                        'type' => $document->Type->Description ?? '',
                        'format' => $document->Format->Description ?? '',
                        'encoding' => 'base64' ?? '', 
                        'content' => $activity->Document->Content ?? ''
                    ];
                }
            }

            $statusses[$key] = $status;
            
        }

        $response['statusses'] = $statusses;
        if ($response['error'] == false) {
            $response['message'] = r('De tracking informatie is bijgewerkt.');
        }
        return $response;
    }

}
