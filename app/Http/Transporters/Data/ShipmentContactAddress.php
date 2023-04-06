<?php

namespace App\Http\Transporters\Data;

use App\Models\CountryCodeTransporter;
use App\Models\PlaceCodeTransporter;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;

class ShipmentContactAddress
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $company;

    /**
     * @var string
     */
    private $phone;

    /**
     * @var array
     */
    private $streetLines;

    /**
     * @var string
     */
    private $city;

    /**
     * @var string
     */
    private $stateOrProvinceCode;

    /**
     * @var string
     */
    private $zip;

    /**
     * @var string
     */
    private $countryCode;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $private;

    /**
     * @return string
     */
    public function getName(): string
    {
        if(!$this->name) {
            return '';
        }

        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getCompany(): string
    {
        if(!$this->company) {
            return '.';
        }

        return $this->company;
    }

    /**
     * @param string $company
     */
    public function setCompany(string $company): void
    {
        $this->company = $company;
    }

    /**
     * @return string
     */
    public function getPhone($international = false): string
    {
        if(!$this->phone) {
            return '';
        }

		if ($international) {
			$phoneUtil = PhoneNumberUtil::getInstance();
			$phoneInfo = $phoneUtil->parse($this->phone, "NL");
			$number = $phoneUtil->format($phoneInfo, PhoneNumberFormat::E164);
			if (!$phoneUtil->isPossibleNumber($number)) {
				return $this->phone;
			}
			return $number;

		}

        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return array
     */
    public function getStreetLines( $get = 0 ): string
    {
        if(!$this->streetLines) {
            return '';
        }

        return (isset($this->streetLines[$get]) ? $this->streetLines[$get] : '');
    }

    /**
     * @param array $streetLines
     */
    public function setStreetLines(array $streetLines): void
    {
        $this->streetLines = $streetLines;
    }

    /**
     * @return string
     */
    public function getCity($transporter = null): string
    {
        if(!$this->city) {
            return '';
        }

        /*
	    if (!empty($transporter) && $this->countryCode) {
		    $place =  PlaceCodeTransporter::where('country', $this->countryCode)
			    ->where('name', $this->city)
			    ->where('transporter','=', strtolower($transporter))
			    ->pluck("place");

		    if (!empty($place[0])) {
			    return $place[0];
		    }
	    }
        */

        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getStateOrProvinceCode(): string
    {
        if(!$this->stateOrProvinceCode) {
            return '';
        }

        return $this->stateOrProvinceCode;
    }

    /**
     * @param string $stateOrProvinceCode
     */
    public function setStateOrProvinceCode(string $stateOrProvinceCode): void
    {
        $this->stateOrProvinceCode = $stateOrProvinceCode;
    }

    /**
     * @return string
     */
    public function getZip( $transporter = null ): string
    {
        if(!$this->zip) {
            return '';
        }

        if ($transporter == 'tnt' && strtolower($this->getCountryCode( $transporter)) == 'nl'){
        	$zip = trim($this->zip);
        	$zip = str_replace([' ',',','.','-','_'],'',$zip);
        	return substr($zip,0,4) . ' ' . strtoupper(substr($zip,4,2));
        }

        return $this->zip;
    }

    /**
     * @param string $zip
     */
    public function setZip(string $zip): void
    {
        $this->zip = $zip;
    }

	/**
	 * @param string $transporter
	 * @return string
	 */
    public function getCountryCode( $transporter = '' ): string
    {

    	if (in_array(strtolower($transporter),['tnt','fedex'])){

    		switch(strtoupper($this->countryCode)){
		    case 'XB': return 'BQ';
    		} 

	    }

        if(!$this->countryCode) {
            return '';
        }
        
        /*
		if (!empty($transporter) && $this->countryCode) {
			$code =  CountryCodeTransporter::where('country', $this->countryCode)
				->where('transporter','=', strtolower($transporter))
				->pluck("code");

			if (!empty($code[0])) {
				return $code[0];
			}
		}
        */

        return $this->countryCode;
    }

    /**
     * @param string $countryCode
     */
    public function setCountryCode(string $countryCode): void
    {
        $this->countryCode = $countryCode;
    }

    /**
     * @param string $streetLine
     */
    public function addStreetLine(string $streetLine): void
    {
        $this->streetLines[] = $streetLine;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        if(!$this->email) {
            return '';
        }

        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return bool
     */
    public function getIsPrivate(): bool
    {
        if ($this->private){
            return true;
        }
        return false;
    }

    /**
     * @param string $email
     */
    public function setIsPrivate(bool $private): void
    {
        $this->private = $private;
    }

}
