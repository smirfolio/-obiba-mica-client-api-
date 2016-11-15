<?php
/**
 * Created by PhpStorm.
 * User: samir
 * Date: 16-11-14
 * Time: 01:43
 */

namespace ObibaMicaClient;


trait Dataset {

  public Function getDatasetsResources($parameters){
    $language = MicaConfig::getCurrentLang();
    $from = empty($parameters['from']) ? '0' : $parameters['from'];
    $limit = empty($parameters['limit']) ? '5' : $parameters['limit'];
    $order = empty($parameters['order']) ? '' : ($parameters['order'] == 'desc' ? '-' : '');
    $sort = empty($parameters['sort']) ? '' : $parameters['sort'];
    $sortRqlBucket = empty($sort) ? "" : ",sort($order$sort)";
    $query = empty($parameters['query']) ? '' : $parameters['query'];
    $queryParameter = empty($query) ? '' : ",match($query,(Mica_dataset.name,Mica_dataset.acronym,Mica_dataset.description))";
    $resource = empty($parameters['resource']) ? '' : $parameters['resource'];
    $resourceParams = empty($resource) ? '' : ",in(Mica_dataset.className,$resource)";
    $networkId = empty($parameters['network_id']) ? '' : $parameters['network_id'];
    $networkParams = empty($networkId) ? '' : ",in(Mica_dataset.networkId,$networkId)";
    $studyId = empty($parameters['study_id']) ? '' : $parameters['study_id'];
    $studiesParam = empty($studyId) ? '' : ",study(in(Mica_study.id,(" . rawurlencode($studyId) . ")))";

    if (!empty($queryParameter) || !empty($resourceParams) || !empty($studiesParam)) {
      $params = "dataset(limit($from,$limit)$resourceParams$networkParams$queryParameter$sortRqlBucket)$studiesParam";
    }
    else {
      $params = "dataset(exists(Mica_dataset.id),limit($from,$limit)$sortRqlBucket)";
    }

    $params .= ",locale($language)";
    return  '/datasets/_rql?query=' . $params;
  }

  public  function getDatasetResources($parameters){
    return  (empty($parameters['resource']) ? '/dataset' :
      '/' . $parameters['resource']) . '/' . $parameters['id'];
  }

  public function getDatasets($resourceQuery, $ajax = FALSE) {
    $data = $this->obibaGet($resourceQuery, 'HEADER_JSON', $ajax);
    $resultData = json_decode($data);
    $resultResourceQuery = new DatasetJoinResponseWrapper($resultData);
    if (!empty($resultResourceQuery)) {
      return $resultResourceQuery;
    }
    return FALSE;
  }

  public  function getDataset($resourceQuery){
    $data = $this->obibaGet($resourceQuery, 'HEADER_JSON');
    $resultDataset = $data ? json_decode($data) : NULL;
    if (!empty($resultDataset)) {
      return $resultDataset;
    }
  }

}