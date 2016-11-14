<?php
/**
 * Created by PhpStorm.
 * User: samir
 * Date: 11/12/16
 * Time: 12:04 AM
 */

namespace ObibaMicaClient;

class ObibaMica extends MicaRestClient{
  protected $studies = "Get studies hihaa  ";
  protected $study = "Get study";
  protected $config;
  protected $micaWatchDog;
  protected $micaRestClient;
  protected $micaCache;

  function __construct(MicaConfigInterface $micaConfig,
                       MicaWatchDogInterface $micaWatchDog,
                       MicaCacheInterface $micaCache

  ) {
    $this->micaWatchDog = $micaWatchDog;
    $this->config = $micaConfig;
    $this->micaCache = $micaCache;
    parent::__construct($micaConfig, $micaWatchDog);
    return $this;
  }

  public function obibaPost($param = NULL) {
    if (!$param) {
      return $this->studies . $this->config->micaGetConfigTest("testMyKey");
    }
    else {
      return $this->study . "  ->" . $param . $this->config->micaGetConfigTest("testMyKey");
    }
  }

  public function obibaGet($resource, $acceptType, $ajax = NULL, $parameters = NULL) {
    $this->httpGet($resource, $parameters, $acceptType);
    return $this->send($parameters, $ajax);
  }

  public function obibaPut($param = NULL) {
  }

  public function obibaDelete($param = NULL) {
  }

  public function obibaDownload($param = NULL) {
  }

  public function obibaUpload($param = NULL) {
  }


}