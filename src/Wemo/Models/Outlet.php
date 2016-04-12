<?php
/**
 * @author Thorne Melcher <tmelcher@portdusk.com>
 * @package WeMo-PHP-Toolkit
 * @version 0.1
 * @license LGPL
 */

namespace Wemo\Models;

/**
 * Model class representing a WeMo Outlet. Connects over IP, so it must be accessible to the server running the PHP
 * app at the IP specified.
 *
 * @package Wemo\Models
 */
class Outlet extends Device {

  /**
   * The URL of the icon to display for this outlet.
   *
   * @var string
   */
  protected $icon_url;

  /**
   * Constructor method. Will populate other information beyond IP address from the outlet itself.
   *
   * @param $ip_address
   */
  public function __construct($ip_address) {
    $this->ip_address = $ip_address;
  }

  /**
   * Updates the Outlet's state by pulling info from the outlet itself.
   */
  public function refresh() {
    // Squelching is bad practice, but we're handling failures
    $contents = @file_get_contents("http://" . $this->ip_address . ":" . $this->port . "/setup.xml");

    if($contents === false) {
      $this->properties_fetched;
      trigger_error("Unable to connect to outlet at " . $ip_address, E_USER_WARNING);
    }

    $contents = new \SimpleXMLElement($contents);

    $this->manufacturer = (string) $contents->device->manufacturer;
    $this->manufacturer_url = (string) $contents->device->manufacturerURL;
    $this->model_description = (string) $contents->device->modelDescription;
    $this->model_name = (string) $contents->device->modelName;
    $this->model_number = (string) $contents->device->modelNumber;
    $this->model_url = (string) $contents->device->modelURL;
    $this->serial_number = (string) $contents->device->serialNumber;
    $this->display_name = (string) $contents->device->friendlyName;
    $this->mac_address = (string) $contents->device->macAddress;
    $this->icon_url = "http://" . $this->ip_address . ":" . $this->port . "/" . $contents->device->iconList->icon->url;

    $this->properties_fetched = true;
  }

  /**
   * @return string
   */
  public function getIconUrl() {
    return $this->icon_url;
  }

  /**
   * Whether or not this outlet is on.
   *
   * @return boolean
   */
  public function getIsOn() {
    $location = 'http://'.$this->ip_address.':' . $this->port . '/upnp/control/basicevent1';
    $action = 'urn:Belkin:service:basicevent:1#GetBinaryState';

    $client = new \SoapClient(dirname(__DIR__) . "/wsdl/BasicService.wsdl");
    $xml = '<?xml version="1.0" encoding="utf-8"?><s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/" s:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"><s:Body><u:GetBinaryState xmlns:u="urn:Belkin:service:basicevent:1"></u:GetBinaryState></s:Body></s:Envelope>';

    try {
      $response = $client->__doRequest($xml, $location, $action, 1, false);
      preg_match("/<BinaryState>(\d)<\/BinaryState>/", $response, $matches);

      return ($matches[1] == 1);
    } catch (SoapFault $exception) {
      // Our soap ain't faulty, but PHP doesn't want us to drop the soap and will generate low-level warnings
    }
  }

  /**
   * Sets whether or not this outlet is on. Makes the SOAP call to the outlet itself to enact the change.
   *
   * @param bool $is_on
   * @return boolean
   */
  public function setIsOn($is_on) {
    if ($this->getIsOn() == $is_on) {
      return $is_on;
    }

    $on_off = $is_on ? "1" : "0";
    $location = 'http://'.$this->ip_address.':' . $this->port . '/upnp/control/basicevent1';
    $action = 'urn:Belkin:service:basicevent:1#SetBinaryState';

    $client = new \SoapClient(dirname(__DIR__) . "/wsdl/BasicService.wsdl");
    $xml = '<?xml version="1.0" encoding="utf-8"?><s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/" s:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"><s:Body><u:SetBinaryState xmlns:u="urn:Belkin:service:basicevent:1"><BinaryState>'.$on_off.'</BinaryState></u:SetBinaryState></s:Body></s:Envelope>';

    try {
      $response = $client->__doRequest($xml, $location, $action, 1, false);
      preg_match("/<BinaryState>(\d)<\/BinaryState>/", $response, $matches);

      return ($matches[1] == 1);
    } catch (SoapFault $exception) {
      // Our soap ain't faulty, but PHP doesn't want us to drop the soap and will generate low-level warnings
    }
  }
}
