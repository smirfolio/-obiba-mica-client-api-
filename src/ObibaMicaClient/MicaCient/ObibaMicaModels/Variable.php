<?php
/**
 * Created by PhpStorm.
 * User: samir
 * Date: 16-11-15
 * Time: 00:49
 */

namespace ObibaMicaClient;


trait Variable {

  public function getVariablesResources($parameters){
    $language = MicaConfig::getCurrentLang();
    $params = empty($parameters['from']) ? 'from=0' : 'from=' . $parameters['from'];
    $params .= empty($parameters['limit']) ? '&limit=-1' : '&limit=' . $parameters['limit'];
    $params .= empty($parameters['sort']) ? '' : '&sort=' . $parameters['sort'];
    $params .= empty($parameters['order']) ? '' : '&order=' . $parameters['order'];
    $params .= empty($parameters['query']) ? '' : '&query=' . urlencode($parameters['query']);
    return (empty($parameters['resource']) ? '/dataset' :
      '/' . $parameters['resource']) .
      '/' . rawurlencode($parameters['dataset_id']) .
      '/variables' . (empty($parameters['query']) ? ''
        : '/_search') . '?' . $params . '&locale=' . $language;
  }

  public function getVariableResources($variableId){
    $language = MicaConfig::getCurrentLang();
    return sprintf("/variable/%s?locale=%s", rawurlencode($variableId),$language);
  }

  public function getVariables($resourceQuery, $ajax = FALSE) {
    $data = $this->obibaGet($resourceQuery, 'HEADER_JSON', $ajax);
    $resultData = $data ? json_decode($data) : NULL;
    if (!empty($resultData)) {
      return $resultData;
    }
    return FALSE;
  }

  public  function getVariable($resourceQuery){
    $data = $this->obibaGet($resourceQuery, 'HEADER_JSON');
    $resultVariable = $data ? json_decode($data) : NULL;
    if (!empty($resultVariable)) {
      return $resultVariable;
    }
  }
}