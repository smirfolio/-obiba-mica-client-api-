<?php
/**
 * Created by PhpStorm.
 * User: samir
 * Date: 6/1/17
 * Time: 4:24 PM
 */

namespace ObibaMicaClient;


trait  File {

  public function getFileResources($parameters){
    $entity_type = $parameters['entity_type'];
    $entity_id = $parameters['entity_id'];
    $id_file = $parameters['id_file'];

    return !empty($parameters['token_key']) ?
      "/draft/" . $entity_type . "/" . $entity_id . "/file/" . $id_file . "/_download?key=" . $parameters['token_key']:
      "/" . $entity_type . "/" . $entity_id . "/file/" . $id_file . "/_download";
  }

  public function downloadFile($resourceQuery){
     return $this->obibaDownload($resourceQuery, 'HEADER_BINARY');
  }
}