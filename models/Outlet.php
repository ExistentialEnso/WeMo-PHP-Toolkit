<?php
/**
 * @author Thorne Melcher <tmelcher@portdusk.com>
 * @package WeMo-PHP-Toolkit
 * @version 0.1
 * @license LGPL
 */

namespace wemo\models;

/**
 * Class representing a WeMo Outlet.
 *
 * @package wemo\models
 */
class Outlet {
  /**
   * The display name for this outlet.
   *
   * @var string
   */
  protected $display_name = "";

  /**
   * The MAC address of the outlet.
   *
   * @var string
   */
  protected $mac_address;

  /**
   * The IP Address of the outlet.
   *
   * @var string
   */
  protected $ip_address;

  /**
   * Whether or not this outlet is on.
   *
   * @var boolean
   */
  protected $is_on = false;

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

    if(!$this->refresh()) {
      trigger_error("Unable to connect to outlet at " . $ip_address, E_USER_WARNING);
    }
  }

  /**
   * Updates the Outlet's state by re-pulling info from the outlet itself.
   *
   * @return bool Was the refresh successful?
   */
  public function refresh() {
    // Squelching is bad practice, but we're handling failures
    $contents = @file_get_contents("http://" . $this->ip_address . ":49153/setup.xml");

    if($contents === false) return false;

    $contents = new \SimpleXMLElement($contents);

    $this->display_name = $contents->device->friendlyName;
    $this->mac_address = $contents->device->macAddress;
    $this->is_on = ($contents->device->binaryState == "1" ? true : false);
    $this->icon_url = "http://" . $this->ip_address . ":49153/" . $contents->device->iconList->icon->url;

    return true;
  }

  /**
   * @return string
   */
  public function getDisplayName() {
    return $this->display_name;
  }

  /**
   * @return string
   */
  public function getIconUrl() {
    return $this->icon_url;
  }

  /**
   * @return string
   */
  public function getIpAddress() {
    return $this->ip_address;
  }

  /**
   * @return boolean
   */
  public function getIsOn() {
    return $this->is_on;
  }

  /**
   * @return string
   */
  public function getMacAddress() {
    return $this->mac_address;
  }

  /**
   * Sets whether or not this outlet is on. Makes the SOAP call to the outlet itself to enact the change.
   *
   * @param bool $is_on
   * @return string
   */
  public function setIsOn($is_on) {
    $this->is_on = $is_on;
    $on_off = $is_on ? "1" : "0";

    $location = 'http://'.$this->ip_address.':49153/upnp/control/basicevent1';
    $action = 'urn:Belkin:service:basicevent:1#SetBinaryState';

    $client = new \SoapClient(dirname(__DIR__) . "/wsdl/BasicService.wsdl");
    $xml = '<?xml version="1.0" encoding="utf-8"?><s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/" s:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"><s:Body><u:SetBinaryState xmlns:u="urn:Belkin:service:basicevent:1"><BinaryState>'.$on_off.'</BinaryState></u:SetBinaryState></s:Body></s:Envelope>';

    try {
      $response = $client->__doRequest($xml, $location, $action, 1, false);

      return $response;
    } catch (SoapFault $exception) {
      // Our soap ain't faulty, but PHP doesn't want us to drop the soap and will generate low-level warnings
    }
  }
}