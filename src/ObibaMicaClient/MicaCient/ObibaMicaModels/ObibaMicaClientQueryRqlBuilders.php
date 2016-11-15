<?php
/**
 * Copyright (c) 2016 OBiBa. All rights reserved.
 *
 * This program and the accompanying materials
 * are made available under the terms of the GNU Public License v3.0.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace ObibaMicaClient;

use ObibaMicaClient\MicaConfig as MicaConfig;

class RqlQueryBuilder {
  function __construct() {

  }

  public static function network_query_charts($studyIds) {
    return self::createChartsQuery(
      "variable(in(studyIds,(%s)),sort(name),aggregate(%s,bucket(studyIds))),locale(%s)",
      $studyIds
    );
  }

  public static function study_query_charts($studyId) {
    return self::createChartsQuery(
      "variable(eq(studyIds,%s),sort(name),aggregate(%s,bucket(dceIds))),locale(%s)",
      $studyId
    );
  }

  public static function dataset_query_charts($datasetId) {
    return self::createChartsQuery(
      "variable(eq(datasetId,%s),sort(name),aggregate(%s)),locale(%s)",
      $datasetId
    );
  }

  public static function networks($networkIds) {
    return self::createQuery(
      "network(in(id,(%s)),sort(acronym)),locale(%s)",
      $networkIds
    );
  }

  private static function createQuery($format, $args) {
    global $language;

    return sprintf(
      $format,
      is_array($args) ? join(',', $args) : $args,
      $language->language
    );
  }

  private static function createChartsQuery($format, $args) {
    global $language;

    return sprintf(
      $format,
      is_array($args) ? join(',', $args) : $args,
      self::createAggregationQuery(),
      $language->language
    );
  }


  private static function createAggregationQuery() {
    $config = new MicaConfig();
    $figures = $config->MicaGetConfig('mica_taxonomy_figures');
    if (empty($figures)) {
      return '';
    }
    $taxonomies = array_map(function ($figure) {
      return $figure['value'];
    }, $figures);
    foreach ($taxonomies as &$taxonomy) {
      $taxonomy .= '*';
    }
    return sprintf("re(%s)", implode(',', $taxonomies));
  }

}
