<?php
/**
 * @author Thorne Melcher <tmelcher@portdusk.com>
 * @package WeMo-PHP-Toolkit
 * @version 0.1
 * @license LGPL
 */

namespace Wemo\Models;

/**
 * Generic WeMo device class. All devices will have these fields.
 *
 * @package Wemo\Models
 */
abstract class Device {

  /**
   * The IP Address of the device.
   *
   * @var string
   */
  protected $ip_address;

  /**
   * Device's SOAP port. Currently always 49153 in all usages I'm aware of.
   *
   * @var int
   */
  protected $port = 49153;

  /**
   * The MAC address of the device.
   *
   * @var string
   */
  protected $mac_address;

  /**
   * The display name stored on the device.
   *
   * @var string
   */
  protected $display_name = "";

  /**
   * The manufacturer of the device.
   *
   * @var string
   */
  protected $manufacturer;

  /**
   * The manufacturer's URL.
   *
   * @var string
   */
  protected $manufacturer_url;

  /**
   * The model of device.
   *
   * @var string
   */
  protected $model_name;

  /**
   * A short description of this device.
   *
   * @var string
   */
  protected $model_description;

  /**
   * The model number of this device.
   *
   * @var string
   */
  protected $model_number;

  /**
   * A URL for this specific model.
   *
   * @var string
   */
  protected $model_url;

  /**
   * This device's serial number.
   *
   * @var string
   */
  protected $serial_number;

  /**
   * If the device's properties have been fetched yet. $this->refresh() will be called
   * from all getters if this is false. Subclasses should implement $this->refresh and
   * set this variable appropriately for success or failure.
   *
   * @var boolean
   */
  protected $properties_fetched = false;

  /**
   * Updates the devices's state by pulling info from the device itself.
   * Subclasses implementing this should set $this->properties_fetched
   * appropriately for success or failure.
   */
  abstract public function refresh();

  /**
   * @return string
   */
  public function getIpAddress() {
    return $this->ip_address;
  }

  /**
   * Gets the SOAP port of the Outlet. Currently always returns 49153, but this is subject to change.
   *
   * @return int
   */
  public function getPort() {
    return $this->port;
  }

  /**
   * @return string
   */
  public function getMacAddress() {
    if (!$this->properties_fetched) {
      $this->refresh();
    }
    return $this->mac_address;
  }

  /**
   * @return string
   */
  public function getDisplayName() {
    if (!$this->properties_fetched) {
      $this->refresh();
    }
    return $this->display_name;
  }

  /**
   * @return string
   */
  public function getManufacturer() {
    if (!$this->properties_fetched) {
      $this->refresh();
    }
    return $this->manufacturer;
  }

  /**
   * @return string
   */
  public function getManufacturerUrl() {
    if (!$this->properties_fetched) {
      $this->refresh();
    }
    return $this->manufacturer_url;
  }

  /**
   * @return string
   */
  public function getModelName() {
    if (!$this->properties_fetched) {
      $this->refresh();
    }
    return $this->model_name;
  }

  /**
   * @return string
   */
  public function getModelDescription() {
    if (!$this->properties_fetched) {
      $this->refresh();
    }
    return $this->model_description;
  }

  /**
   * @return string
   */
  public function getModelNumber() {
    if (!$this->properties_fetched) {
      $this->refresh();
    }
    return $this->model_number;
  }

  /**
   * @return string
   */
  public function getModelUrl() {
    if (!$this->properties_fetched) {
      $this->refresh();
    }
    return $this->model_url;
  }

  /**
   * @return string
   */
  public function getSerialNumber() {
    if (!$this->properties_fetched) {
      $this->refresh();
    }
    return $this->serial_number;
  }
}
