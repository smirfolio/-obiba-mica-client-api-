<?php
/**
 * Created by PhpStorm.
 * User: samir
 * Date: 11/12/16
 * Time: 12:04 AM
 */

namespace ObibaMicaClient;
use ObibaMicaClient\MicaConfig as MicaConfig;
class ObibaMica {
  protected $studies =  "Get studies";
  protected $study =  "Get study";
  protected $micaUrl;
  protected $config;

  function __construct(MicaConfig\MicaConfigInterface $micaConfig) {

$this->config =  new MicaConfig\MicaDrupalConfig();
  }

  public function obibaPost($param = NULL){
  if(!$param){
    return $this->studies . $this->config->micaGetConfigTest("testMyKey");
  }
  else{
    return $this->study . "  ->" .$param. $this->config->micaGetConfigTest("testMyKey");
  }
}

  public function obibaGet($param = NULL){
    if(!$param){
      return $this->studies;
    }
    else{
      return $this->study . "  ->" .$param;
    }
  }
  public function obibaPut($param = NULL){}
  public function obibaDelete($param = NULL){}
  public function obibaDownload($param = NULL){}
  public function obibaUpload($param = NULL){}

}