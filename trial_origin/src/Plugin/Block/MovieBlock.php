<?php

/**
 * @file
 *  Contains Drupal\trial\Plugin\Block\MovieBlock.
 */
namespace Drupal\trial\Plugin\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\paragraphs\Entity\Paragraph;
use Drupal\node\Entity\Node;
use Drupal\Core\Database\Database;

/**
 * Provides a 'Movie' Block.
 *
 * @Block(
 *   id = "movie_block",
 *   admin_label = @Translation("Movie block"),
 *   category = @Translation("Movie World"),
 * )
 */
class MovieBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
    // Fetch the node id of the actor from url.
    $node = \Drupal::routeMatch()->getParameter('node');
    $nid = $node->id();
    $node_details = Node::load($nid);
    // kint($node_details);
    $page_title = $node_details->title->value;
    $page_title = 'Movies of '. $page_title;
    // Query to fetch movies having the same target id as node id of the actor.
    $query = \Drupal::entityQuery('node')
      ->condition('type', 'movie')
      ->condition('field_actor_role.entity:paragraph.field_actor.target_id',$nid)
      ->sort('field_release_date', 'DESC');
    $mids = $query->execute();
    // If no movies of the actor is found then displays this message.
    $items = array();
    if(empty($mids)) {
      $items['empty'] =  "No Movies Found";
    }
    else {
      // All the movie nodes of that actor is being loaded.
      $nodes = entity_load_multiple('node', $mids);
      // kint($nodes);
      $actor = array();
      foreach($nodes as $node) {
        $mid = $node->id();
        $database = \Drupal::database();
        // Fetching the average rating of movie.
        $query = $database->query("SELECT value FROM {votingapi_result}
          where function = 'vote_average' and entity_id = $mid");
        $result = $query->fetchAll();
        $rating = $result[0]->value/20;
        $rating = floor($rating);
        // Flag value to check fraction value of movie rating.
        $halfStarFlag = false;
        if($result[0]->value%20 != 0) {
          $halfStarFlag = true;
        }
        $node_title = $node->title->value;
        $node_des = $node->body->value;
        $node_image_fid = $node->get('field_poster')->target_id;
        if(!is_null($node_image_fid)) {
          $image_entity = \Drupal\file\Entity\File::load($node_image_fid);
          $image_entity_url = $image_entity->url();
        }
        else {
          $image_entity_url = "/sites/default/files/default_images/def_actor.jpeg";
        }
        $target_id = $node->field_actor_role->getValue();
        // kint($target_id);
        $actors = array();
        $count = 0;
        $coactors = array ();
        foreach ($target_id as $value) {
          $paragraph = Paragraph::load($value['target_id']);
          // kint($paragraph);
          $actor_id = $paragraph->field_actor->target_id;
          $actor = Node::load($actor_id);
          if ($actor_id != $nid ) {
            $coactors[$count]['name'] = $actor->title->value;
            $coactors[$count]['nid'] = $actor->nid->value;
          }
          else {
            $role = $paragraph->field_role->getValue();
            if (empty($role)) {
              $actor_role = "No role Defined";
            }
            else {
              $actor_role = $role[0]['value'];
            }
          }
          $count++;
        }

        $items[] = [
          'name' => $node_title,
          'nid' => $mid,
          'des' => $node_des,
          'poster' => $image_entity_url,
          'role' =>$actor_role,
          'ratings' =>$rating,
          'costars' => $coactors,
          'halfStarFlag' => $halfStarFlag,
        ];
      }
    }
    // kint($items);


    return [
      '#theme' => 'movie_block_actor',
      '#items' => $items,
      '#title' => $page_title,
      '#cache' => [
        'max-age' => 0,
      ],
    ];
  }
}
