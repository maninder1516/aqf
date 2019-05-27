<?php

namespace AQF\AQFBundle\Entity;

/**
 * Mission
 */
class Mission
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $client;

    /**
     * @var \DateTime
     */
    private $serviceDate;

    /**
     * @var string
     */
    private $productName;

    /**
     * @var int
     */
    private $quantity;

    /**
     * @var string
     */
    private $destinationCountry;

    /**
     * @var string
     */
    private $vendorName;

    /**
     * @var string
     */
    private $vendorEmail;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set client
     *
     * @param integer $client
     *
     * @return Mission
     */
    public function setClient($client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return int
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set serviceDate
     *
     * @param \DateTime $serviceDate
     *
     * @return Mission
     */
    public function setServiceDate($serviceDate)
    {
        $this->serviceDate = $serviceDate;

        return $this;
    }

    /**
     * Get serviceDate
     *
     * @return \DateTime
     */
    public function getServiceDate()
    {
        return $this->serviceDate;
    }

    /**
     * Set productName
     *
     * @param string $productName
     *
     * @return Mission
     */
    public function setProductName($productName)
    {
        $this->productName = $productName;

        return $this;
    }

    /**
     * Get productName
     *
     * @return string
     */
    public function getProductName()
    {
        return $this->productName;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return Mission
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set destinationCountry
     *
     * @param string $destinationCountry
     *
     * @return Mission
     */
    public function setDestinationCountry($destinationCountry)
    {
        $this->destinationCountry = $destinationCountry;

        return $this;
    }

    /**
     * Get destinationCountry
     *
     * @return string
     */
    public function getDestinationCountry()
    {
        return $this->destinationCountry;
    }

    /**
     * Set vendorName
     *
     * @param string $vendorName
     *
     * @return Mission
     */
    public function setVendorName($vendorName)
    {
        $this->vendorName = $vendorName;

        return $this;
    }

    /**
     * Get vendorName
     *
     * @return string
     */
    public function getVendorName()
    {
        return $this->vendorName;
    }

    /**
     * Set vendorEmail
     *
     * @param string $vendorEmail
     *
     * @return Mission
     */
    public function setVendorEmail($vendorEmail)
    {
        $this->vendorEmail = $vendorEmail;

        return $this;
    }

    /**
     * Get vendorEmail
     *
     * @return string
     */
    public function getVendorEmail()
    {
        return $this->vendorEmail;
    }
}

