<?php

namespace App\Http\Transporters\Data;

use Illuminate\Database\Eloquent\Factories\HasFactory;
class ShipmentColli
{

    use HasFactory;
    
    /**
     * @var float
     */
    private $length;

    /**
     * @var float
     */
    private $width;

    /**
     * @var float
     */
    private $height;

    /**
     * @var float
     */
    private $weight;

    /**
     * @var int
     */
    private $amount;

    /**
     * @var int
     */
    private $sequenceNumber;

    /**
     * @var string
     */
    private $stackable;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    public $type;

    /**
     * @var float
     */
    public $insurance;

    /**
     * @var integer
     */
    public $boxes;

    /**
     * @return float
     */
    public function getLength(): float
    {
        if(!$this->length) {
            return 0;
        }

        return $this->length;
    }

    /**
     * @param float $length
     */
    public function setLength(float $length): void
    {
        $this->length = $length;
    }

    /**
     * @return float
     */
    public function getWidth(): float
    {
        if(!$this->width) {
            return 0;
        }

        return $this->width;
    }

    /**
     * @param float $width
     */
    public function setWidth(float $width): void
    {
        $this->width = $width;
    }

    /**
     * @return float
     */
    public function getHeight(): float
    {
        if(!$this->height) {
            return 0;
        }

        return $this->height;
    }

    /**
     * @param float $height
     */
    public function setHeight(float $height): void
    {
        $this->height = $height;
    }

    /**
     * @return float
     */
    public function getWeight(): float
    {
        if(!$this->weight) {
            return 0;
        }

        return $this->weight;
    }

    /**
     * @param float $weight
     */
    public function setWeight(float $weight): void
    {
        $this->weight = $weight;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        if(!$this->amount) {
            return 0;
        }

        return $this->amount;
    }

    /**
     * @param int $amount
     */
    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return int
     */
    public function getSequenceNumber(): int
    {
        if(!$this->sequenceNumber) {
            return 0;
        }

        return $this->sequenceNumber;
    }

    /**
     * @param int $sequenceNumber
     */
    public function setSequenceNumber(int $sequenceNumber): void
    {
        $this->sequenceNumber = $sequenceNumber;
    }

    /**
     * @return string
     */
    public function getStackable(): string
    {
        if(!$this->stackable) {
            return '';
        }

        return $this->stackable;
    }

    /**
     * @param string $stackable
     */
    public function setStackable(string $stackable): void
    {
        $this->stackable = $stackable;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        if(!$this->description) {
            return '';
        }

        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        if(!$this->code) {
            return '';
        }

        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @param string $type
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $insurance
     */
    public function setInsurance(float $insurance): void
    {
        $this->insurance = $insurance;
    }

    /**
     * @param string $type
     */
    public function getInsurance(): float
    {
        return $this->insurance ?? 0;
    }

    public function setBoxes(int $boxes): void
    {
        $this->boxes = $boxes;
    }

    public function getBoxes(): int
    {
        return $this->boxes ?? 0;
    }
}
