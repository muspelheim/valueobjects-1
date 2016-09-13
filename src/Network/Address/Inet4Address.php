<?php

namespace RHorv\ValueObjects\Network\Address;

/**
 * Class Inet4Address
 * @package Cognolink\Common\DataType
 * @info    Taken from java.net.Inet4Address
 */
class Inet4Address extends InetAddress
{
    /**
     * @param array $segments
     * @param null $hostName
     */
    protected function __construct(array $segments, $hostName = null)
    {
        if (!$this->isValidIp4Address(
            self::segmentsToAddress($segments)
        )
        ) {
            throw new \InvalidArgumentException(sprintf(
                "'%s' is not a valid IPv4 address",
                self::segmentsToAddress($segments)
            ));
        }
        parent::__construct($segments, $hostName);
    }

    /**
     * @param $address
     *
     * @return bool
     */
    private function isValidIp4Address($address)
    {
        return filter_var($address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
    }

    /**
     * Returns the IP address string in textual presentation.
     *
     * @return string
     */
    public function getHostAddress()
    {
        return $this->segmentsToAddress($this->getAddress());
    }

    /**
     * Converts address to segments
     *
     * @param $address
     *
     * @return array
     */
    public static function addressToSegments($address)
    {
        return explode(".", $address);
    }

    /**
     * Converts segments to address
     *
     * @param array $segments
     *
     * @return array
     */
    public static function segmentsToAddress(array $segments)
    {
        return implode(".", $segments);
    }
}
