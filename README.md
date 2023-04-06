<br><h1 align="center">ShipItEasy Transporters Package</h1>

## About
This repository is used to communicate with the API's of different transporters. It is used to universally implement the following methods;
- retrieve rates
- schedule pickups
- create shipments
- retrieve tracking info
- upload documents

## Adding Transporters
The transporter services are located in the App/Http/Transporters/Services folder. It currently includes two transporters to serve as examples of how to create a transporter service both with REST and SOAP.

The two transporters are:
- Fedex (REST)
- TNT (SOAP)

## Rules and Interfaces
The interfaces for the universal transporter methods are located in the App/Http/Transporters/Rules folder. These are used to ensure that all transporter services return the same response format.

## Retrieve Tracking Information
### Response Interface
The response interface ensures the following methods are available on the response object:
- getTrackingNumber()
- getTrackingStatus()
- getTrackingStatusDescription()

## Schedule Pickup
### Response Interface
The response interface ensures the following methods are available on the response object:
- getPickupNumber()
- getPickupStatus()
- getPickupStatusDescription()

## Create Shipment
### Response Interface
The response interface ensures the following methods are available on the response object:
- getShipmentNumber()
- getShipmentStatus()
- getShipmentStatusDescription()

## Create FreightRate
### Response Interface
The response interface ensures the following methods are available on the response object:
- getFreightNumber()
- getFreightStatus()
- getFreightStatusDescription()

## Retrieve Rates
### Response Interface
The response interface ensures the following methods are available on the response object:
- getRates()
- getRateStatus()
- getRateStatusDescription()

## Retrieve Freight-Rates
### Response Interface
The response interface ensures the following methods are available on the response object:
- getRates()
- getRateStatus()
- getRateStatusDescription()

## Upload Documents
### Response Interface
The response interface ensures the following methods are available on the response object:
- getDocumentStatus()
- getDocumentStatusDescription()

## Unit Tests
The unit tests are located in the App/Http/Transporters/tests folder. The tests are written using PHPUnit and can be run using the following command:

```bash
vendor/bin/phpunit
```
<br>
<b>For Each transporter, the following results must be returned</b><br><br>
 ✔ The pickup endpoint returns a successful response implementing the pickup response interface<br>
 ✔ The rates endpoint returns a successful response implementing the rates response interface<br>
 ✔ The shipment endpoint returns a successful response implementing the shipment response interface<br>
 ✔ The tracking endpoint returns a successful response implementing the tracking response interface

## Adding Features
To add a feature to the package, you will need to create a new branch named feature/{transporter} and then create a pull request to merge your branch into the master branch. 

## Documentations of Transporters to be implemented
- [DPD](https://api.dpdconnect.nl/swagger/index.html)
- [GLS](https://api-portal.gls.nl/)
- [Kuehne + Nagel](https://api-airfreight.kuehne-nagel.com/apis/overview)
- [DB Schenker](https://api-portal.dbschenker.com/)

