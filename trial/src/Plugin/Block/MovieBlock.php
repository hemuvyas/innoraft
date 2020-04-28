<?php
namespace Drupal\trial\Plugin\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\paragraphs\Entity\Paragraph;
use Drupal\node\Entity\Node;
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
    $node = \Drupal::routeMatch()->getParameter('node');
    $nid = $node->id();
    $node_details = Node::load($nid);
    // kint($node_details);
    $page_title = $node_details->title->value;
    $page_title = 'Movies of '. $page_title;
    $query = \Drupal::entityQuery('node')
      ->condition('type', 'movie')
      ->condition('field_actor_role.entity:paragraph.field_actor.target_id',$nid)
      ->sort('field_release_date', 'DESC');
    $mids = $query->execute();
    if(empty($mids)) {
      $data = array("#markup" => "No Results Found");
    }
    else {
      $nodes = entity_load_multiple('node', $mids);
      // kint($mids);
      $items = array();
      $actor = array();
      foreach($nodes as $node) {
        $mid = $node->id();
        $node_title = $node->title->value;
        $node_image_fid = $node->get('field_poster')->target_id;
        $image_entity = \Drupal\file\Entity\File::load($node_image_fid);
        $image_entity_url = $image_entity->url();
        $target_id = $node->field_actor_role->getValue();
        $actors = array();
        $count = 0;
        $coactors = array ();
        foreach ($target_id as $value) {
          $paragraph = Paragraph::load($value['target_id']);
          $actor_id = $paragraph->field_actor->target_id;
          $actor = Node::load($actor_id);
          $actors[$count]['name'] = $actor->title->value;
          $actors[$count]['nid'] = $actor->nid->value;
          if ($actor_id != $nid ) {
            $coactors[$count]['name'] = $actor->title->value;
            $coactors[$count]['nid'] = $actor->nid->value;
          }
          $count++;
        }

        $items[] = [
          'name' => $node_title,
          'nid' => $node_id,
          'des' => $node_des,
          'poster' => $node_poster,
          'actors' =>$actors,
          'ratings' =>$rating,
          'costars' => $coactors
        ];
      }
    }
    kint($items);


    // return [
    //   '#markup' => $this->t('Hello, World! ' . $nid),
    //   '#cache' => [
    //     'max-age' => 0,
    //   ],
    // ];
  }
}





