<?php
/**
 * Created by PhpStorm.
 * User: samir
 * Date: 11/12/16
 * Time: 12:06 AM
 */

namespace ObibaMicaClient;


trait Study {


  public Function getStudiesResources($parameters){
    $language = MicaConfig::getCurrentLang();
    $from = empty($parameters['from']) ? '0' : $parameters['from'];
    $limit = empty($parameters['limit']) ? '5' : $parameters['limit'];
    $order = empty($parameters['order']) ? '' : ($parameters['order'] == 'desc' ? '-' : '');
    $sort = empty($parameters['sort']) ? '' : $parameters['sort'];
    $sortRqlBucket = empty($sort) ? "" : ",sort($order$sort)";
    $query = empty($parameters['query']) ? '' : $parameters['query'];
    $queryParameter = empty($query) ? NULL : ",match($query,(Mica_study.name,Mica_study.acronym,Mica_study.objectives))";
    if (empty($queryParameter)) {
      $params = "study(exists(Mica_study.id),limit($from,$limit)$sortRqlBucket)";
    } else {
      $params = "study(limit($from,$limit)$queryParameter$sortRqlBucket)";
    }
    $params .= ",locale($language)";
    $resource_query = '/studies/_rql?query=' . $params;
    return $resource_query;
  }

  /**
   * GEt studies Collection
   * @param $micaClient : The ObibaMicaDocuments extending ObibaMica
   * object.
   * @param null $resourceQuery
   * @param $ajax
   * @return mixed
   */
  public function getStudies($micaClient,  $resourceQuery, $ajax = FALSE){
    $data = $micaClient->obibaGet($resourceQuery, 'HEADER_JSON', $ajax);
    $resultData = json_decode($data);
    $resultResourceQuery = new StudyJoinResponseWrapper($resultData);
    $hasSummary = $resultResourceQuery->hasSummaries();
    if (!empty($hasSummary)) {
      return $resultResourceQuery;
    }
    return FALSE;
  }
public function getStudy($micaClient, $idStudy){
  return $micaClient->obibaPost($idStudy);
}
}