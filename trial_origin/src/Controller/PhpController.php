<?php

/**
 * @file
 * Contains code for Drupal\trial\Controller\PhpController
 */

namespace Drupal\trial\Controller;
use Drupal\paragraphs\Entity\Paragraph;
use Drupal\node\Entity\Node;
use Drupal\Core\Link;
use Drupal\Core\Database\Database;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\Core\Controller\ControllerBase;

/**
 * Controller Class of the trial_origin Module
 */
class PhpController extends ControllerBase
{

  public function getlatestactor()
  {
    $query = \Drupal::entityQuery('node')
      ->condition('status', 1)
      ->condition('type', 'actor');
    $nids = $query->execute();
    // kint($nids);
    $m_ids[] = array();
    if (empty($nids)) {
      drupal_set_message("No Actors Found");
      return $this->redirect('trial_movie');
    }
    else {
      foreach ($nids as $nid) {
        $query = \Drupal::entityQuery('node')
          ->condition('status', 1)
          ->condition('type', 'movie')
          ->condition('field_actor_role.entity:paragraph.field_actor.target_id',$nid)
          ->sort('field_release_date', 'DESC')
          ->range(0, 1);
        $m_ids[] = $query->execute();
      }
      $actor = entity_load_multiple('node', $nids);
      $items = array();
      foreach ($actor as $key) {
        $mid = $key->id();
        $name = $key->title->value;
        $about = $key->get('body')->value;
        $database = \Drupal::database();
        $query = $database->query("SELECT value FROM {votingapi_result}
          where function = 'vote_average' and entity_id = $mid");
        $result = $query->fetchAll();
        $rating = $result[0]->value/20;
        $rating = floor($rating);
        $halfStarFlag = false;
        if($result[0]->value%20 != 0) {
          $halfStarFlag = true;
        }
        $node_image_fid = $key->get('field_actor_image')->target_id;
        $image_entity = \Drupal\file\Entity\File::load($node_image_fid);
        $image_entity_url = $image_entity->url();
        $items[] = [
          'name' => $name,
          'about' => $about,
          'rating' => $rating,
          'image_url' => $image_entity_url,
          'halfStarFlag' => $halfStarFlag,
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
    $name = \Drupal::request()->query->get('word');
    if($name == " ") {
      $name=NULL;
    }
    //Query fired to fetch node id of actor content type where title equal to $name.
    $query = \Drupal::entityQuery('node')
     ->condition('status', 1)
     ->condition('type', 'actor')
     ->condition('title', $name, 'CONTAINS');
    $actor_id = $query->execute();
    //Query fired to fetch node id of movie content type where title equal to $name.
    $bundle = 'movie';
    if(empty($actor_id) && $name) {
     $query = \Drupal::entityQuery('node')
         ->condition('status', 1)
         ->condition('type', $bundle)
         ->condition('title', $name, 'CONTAINS');
    }
    //Query fired to fetch node ids of movie where actor node id existin paragraph field.
    elseif(!empty($actor_id) && $name) {
     $query = \Drupal::entityQuery('node')
       ->condition('status', 1)
       ->condition('type', $bundle)
       ->condition('field_actor_role.entity:paragraph.field_actor.target_id',$act_id);
    }
    else {
      $query = \Drupal::entityQuery('node')
        ->condition('status', 1)
        ->condition('type', $bundle)
        ->sort('field_release_date', 'DESC');
    }
    $nids = $query->execute();
    if(empty($nids)) {
      drupal_set_message("No Results Found");
      return $this->redirect('trial_movie');
    }
    else {
      $nodes = entity_load_multiple('node', $nids);
      foreach($nodes as $node){
        $mid = $node->id();
        $title = $node->title->value;
        $body = $node->get('body')->value;
        $date = $node->get('field_release_date')->value;
        $database = \Drupal::database();
        $query = $database->query("SELECT value FROM {votingapi_result}
          where function = 'vote_average' and entity_id = $mid");
        $result = $query->fetchAll();
        $rating = $result[0]->value/20;
        $rating = floor($rating);
        $halfStarFlag = false;
        if($result[0]->value%20 != 0) {
          $halfStarFlag = true;
        }
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
          'halfStarFlag' => $halfStarFlag,
        ];
      }
    }
    $count=0;
    foreach($nids as $nid){
      $items[$count]['url_movie'] = "/node/".$nid;
      $count = $count+1;
    }
    // $items['form'] = $form_rendered;
    // kint($items['form']);
    return array(
      '#theme' => 'movie_list',
      '#items' => $items,
      '#title' => 'movie database',
      '#form' => $form_rendered,
    );
    // return $items;
    // return "hello world";
  }

  public function costar($movie=NULL, $nid=NULL)
  {
    $node = Node::load($movie);
    $target_id = array();
    $target_id = $node->field_actor_role->getValue();
    foreach ($target_id as $value) {
      $paragraph = Paragraph::load($value['target_id']);
      $actor_id = $paragraph->field_actor->target_id;
      if ($actor_id == $nid) {
        $role = $paragraph->field_role->value;
        $actor = Node::load($actor_id);
          // kint($actor);
        $node_image_fid = $actor->field_actor_image->target_id;
        $image_entity = \Drupal\file\Entity\File::load($node_image_fid);
        $image_entity_url = $image_entity->url();
        $node_title = $actor->title->value;
      }
    }
    $items = [
      'name' => $node_title,
      'image' => $image_entity_url,
      'role' => $role,
    ];
      // $resp = json_encode($items);
    return new JsonResponse($items);
  }

}
