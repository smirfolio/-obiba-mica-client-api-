<?php
/**
 * Created by PhpStorm.
 * User: samir
 * Date: 11/12/16
 * Time: 12:00 AM
 */

namespace ObibaMicaClient;
use ObibaMicaClient\MicaConfig as MicaConfig;


class ObibaMicaDocuments extends ObibaMica
{
  use Study;
function __construct() {
  parent::__construct(new MicaConfig\MicaDrupalConfig());
return $this;
}

  /**
   * Get a collection of entities list studies/datasets/networks/projects/variables.
   * The $method parameters is a string method named in the trait entity class.
   *
   * @param string $method : The method nome in the entity trait.
   * @param array $parameters : parameters to retrieve list entities.
   * @return string : List entities in Json format.
   */
  public function getCollections($method, $parameters){
    return $this->{$method}($this);
  }

  /**
   * Get a specific entity document study/dataset/network/project/variable.
   * @param $method
   * @param $idDocument
   * @return Object : entity document.
   */
  public function getDocument($method, $idDocument){
    return $this->{$method}($this, $idDocument);
  }
}