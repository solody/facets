<?php

/**
 * @file
 * Contains \Drupal\facetapi\Plugin\facetapi\query_type\CoreSearchString.
 */

namespace Drupal\facetapi\Plugin\facetapi\query_type;

use Drupal\facetapi\QueryType\QueryTypePluginBase;
use Drupal\facetapi\Result\Result;


/**
 *
 * @FacetApiQueryType(
 *   id = "core_search_string",
 *   label = @Translation("String"),
 * )
 */
class CoreSearchString extends QueryTypePluginBase {

  /**
   * Holds the backend's native query object.
   *
   * @var \Drupal\search_api\Query\QueryInterface
   */
  protected $query;

  /**
   * {@inheritdoc}
   */
  public function execute() {
   /* $query = $this->query;

    // Alter the query here.
    if (!empty($query)) {
      $options = &$query->getOptions();

      $field_identifier = $this->facet->getFieldIdentifier();
      $options['search_api_facets'][$field_identifier] = array(
        'field' => $field_identifier,
        'limit' => 50,
        'operator' => 'and',
        'min_count' => 0,
        'missing' => FALSE,
      );

      // Add the filter to the query if there are active values.
      $active_items = $this->facet->getActiveItems();
      if (count($active_items)) {
        foreach ($active_items as $value) {
          $filter = $query->createFilter();
          $filter->condition($this->facet->getFieldIdentifier(), $value);
          $query->filter($filter);
        }
      }
    }*/
  }

  /**
   * {@inheritdoc}
   */
  public function build() {

    /*
    $build = array();

    // Makes sure there was at least one match.
    if (!$this->adapter->hasMatches) {
      return array();
    }

    // Gets base facet query, adds facet field and filters.
    $facet_query = clone $this->adapter->getFacetQueryExtender();
    $query_info = $this->adapter->getQueryInfo($this->facet);
    $facet_query->addFacetField($query_info);
    foreach ($query_info['joins'] as $table_alias => $join_info) {
      $facet_query->addFacetJoin($query_info, $table_alias);
    }

    // Executes query, iterates over results.
    $result = $facet_query->execute();
    foreach ($result as $record) {
      $build[$record->value] = array('#count' => $record->count);
    }

    // Returns initialized build.
    return $build;
    */

    $facet_query = $facet_manager = \Drupal::service('facetapi.core_manager')->getFacetQueryExtender();
    $facet_query->addFacetField([
      'fields' => [
        'n.' . 'type' => [
          'table_alias' => 'n',
          'field' => 'type',
        ],
      ],
    ]);

    // Executes query, iterates over results.
    $results = $facet_query->execute();

    if (!empty($results)) {
      $facet_results = [];
      foreach ($results as $result) {
        //$facet_results[] = new Result(trim($result['filter'], '"'), trim($result['filter'], '"'), $result['count']);
        $facet_results[] = new Result('test', $result->value, $result->count);
      }
      $this->facet->setResults($facet_results);
    }

    return $this->facet;
  }

}
