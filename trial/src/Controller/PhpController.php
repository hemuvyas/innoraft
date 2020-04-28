<?php
namespace Drupal\trial\Controller;
use Drupal\paragraphs\Entity\Paragraph;
use Drupal\node\Entity\Node;
use Drupal\Core\Link;
use Drupal\Core\Database\Database;


/**
 *
 */
class PhpController
{

  public function getlatestactor()
  {
    $myform = \Drupal::formBuilder()->getForm('Drupal\trial\Form\SearchByName');
    $query = \Drupal::entityQuery('node')
    ->condition('type', 'actor');
    $nids = $query->execute();
    // kint($nids);
    $m_ids[] = array();
    foreach ($nids as $nid) {
      $query = \Drupal::entityQuery('node')
      ->condition('type', 'movie')
      ->condition('field_star_cast',$nid)
      ->range(0, 1)
      ->sort('field_release_date', 'DESC');
      $m_ids[] = $query->execute();
    }
    // kint($m_ids);
    if (empty($nids)) {
      $data = array("#markup" => "No Results Found");
    }
    else {
      $actor = entity_load_multiple('node', $nids);
      $items = array();
      foreach ($actor as $key) {
        $name = $key->title->value;
        $about = $key->get('body')->value;
        $ratings = $key->field_actor_rating->getValue();
        $rating = $ratings['0']['rating'];
        $rating /= 10;
        $rating = $rating . "/10";
        $node_image_fid = $key->get('field_actor_image')->target_id;
        $image_entity = \Drupal\file\Entity\File::load($node_image_fid);
        $image_entity_url = $image_entity->url();
        $items[] = [
          'name' => $name,
          'about' => $about,
          'rating' => $rating,
          'image_url' => $image_entity_url,
        ];
      }
    }
    // kint($items);
    $count=0;
    foreach ($nids as $nid) {
      $items[$count]['actor_url'] = "/node/".$nid;
      $count = $count+1;
    }
    // kint($items);
    $count=0;
    foreach($m_ids as $id){
      foreach ($id as $value) {
          // kint($value);
        $node =  Node::load($value);
        $movie_title = $node->title->value;
        $items[$count]['recent_movie'] = $movie_title;
        $items[$count]['movie_url'] = "/node/".$value;
        $count = $count+1;
      }
    }
    return array(
      '#theme' => 'actor_list',
      '#items' => $items,
      '#title' => 'our actor list',
    );
  }

  public function movielist()
  {
    $form = \Drupal::formBuilder()->getForm(\Drupal\trial\Form\SearchByName::class);
    $form_rendered = \Drupal::service('renderer')->render($form);
    $movie = \Drupal::request()->query->get('word');
    if ($movie == NULL) {
      $query = \Drupal::entityQuery('node')
      ->condition('type', 'movie');
    }
    else {
      $query = \Drupal::entityQuery('node')
      ->condition('type', 'movie')
      ->condition('title', $movie, 'CONTAINS');
    }
    $nids = $query->execute();
    // kint($nids);
    if (empty($nids)) {
      $data = array("#markup" => "No Results Found");
    }
    else {
      $nodes = entity_load_multiple('node', $nids);
      foreach($nodes as $node){
        $title = $node->title->value;
        $body = $node->get('body')->value;
        $date = $node->get('field_release_date')->value;
        $ratings = $node->field_movie_rating->getValue();
        $rating = $ratings[0]['rating'];
        $rating = $rating/20;
        $rating = $rating."/"."5";
        $node_image_fid = $node->get('field_poster')->target_id;
        $image_entity = \Drupal\file\Entity\File::load($node_image_fid);
        $image_entity_url = $image_entity->url();
        $para = $node->field_actor_role->getValue();
        $actors = array();
        $count = 0;
        foreach ($para as $value) {
          $paragraph = Paragraph::load($value['target_id']);
          $actor_id = $paragraph->field_actor->target_id;
          $actor = Node::load($actor_id);
          $actors[$count]['name'] = $actor->title->value;
          $actors[$count]['urls'] = '/node/'.$actor_id;
          $count++;
        }
        $url = array();
        $items[] = [
          'name' => $title,
          'url' => $image_entity_url,
          'desc' => $body,
          'date' => $date,
          'rating' => $rating,
          'cast' => $actors,
        ];
      }
    }
    $count=0;
    foreach($nids as $nid){
      $items[$count]['url_movie'] = "/node/".$nid;
      $count = $count+1;
    }
    $items['form'] = $form_rendered;
    // kint($items['form']);
    return array(
      '#theme' => 'movie_list',
      '#items' => $items,
      '#title' => 'movie database',
    );
    // return $items;
    // return "hello world";
  }


}




