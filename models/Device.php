<?php
/**
 * @author Thorne Melcher <tmelcher@portdusk.com>
 * @package WeMo-PHP-Toolkit
 * @version 0.1
 * @license LGPL
 */

namespace wemo\models;

/**
 * Generic WeMo device class. All devices will have these fields.
 *
 * @package wemo\models
 */
class Device {
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
   * @return string
   */
  public function getDisplayName() {
    return $this->display_name;
  }

  /**
   * @return string
   */
  public function getManufacturer() {
    return $this->manufacturer;
  }

  /**
   * @return string
   */
  public function getManufacturerUrl() {
    return $this->manufacturer_url;
  }

  /**
   * @return string
   */
  public function getModelName() {
    return $this->model_name;
  }

  /**
   * @return string
   */
  public function getModelDescription() {
    return $this->model_description;
  }

  /**
   * @return string
   */
  public function getModelNumber() {
    return $this->model_number;
  }

  /**
   * @return string
   */
  public function getModelUrl() {
    return $this->model_url;
  }

  /**
   * @return string
   */
  public function getSerialNumber() {
    return $this->serial_number;
  }


}