<?php
/**
 * Created by PhpStorm.
 * User: samir
 * Date: 11/12/16
 * Time: 12:06 AM
 */

namespace ObibaMicaClient;


trait Study {

  public function getStudies($micaClient){
    return $micaClient->obibaPost();
  }
public function getStudy($micaClient, $idStudy){
  return $micaClient->obibaPost($idStudy);
}
}