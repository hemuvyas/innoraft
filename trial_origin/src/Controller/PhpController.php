<?php

/**
 * @file
 *
 * Contains Drupal\trial\Controller\PhpController
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

  /**
   * It provides the list of actor/actress (published) on site.
   *
   * @return array
   *  Returns a renderable array to it's twig file for displaying list.
   */
  public function getlatestactor()
  {
    // Get the node id of published actors.
    $query = \Drupal::entityQuery('node')
      ->condition('status', 1)
      ->condition('type', 'actor');
    $nids = $query->execute();
    // kint($nids);
    // Array to store movie ids.
    $m_ids[] = array();
    // If no actors are available in database then show the message,
    // else displays the list
    if (empty($nids)) {
      drupal_set_message("No Actors Found");
      return $this->redirect('trial_movie');
    }
    else {
      foreach ($nids as $nid) {

        // Query to fetch node id of latest movie having this actor form nid.
        $query = \Drupal::entityQuery('node')
          ->condition('status', 1)
          ->condition('type', 'movie')
          ->condition('field_actor_role.entity:paragraph.field_actor.target_id',$nid)
          ->sort('field_release_date', 'DESC')
          ->range(0, 1);
        $m_ids[] = $query->execute();
      }
      // Actor nodes being loaded.
      $actor = entity_load_multiple('node', $nids);
      $items = array();
      // Getting all the required information from the actor node.
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
        // A flag value to determine the rating of a movie in fractions.
        $halfStarFlag = false;
        if($result[0]->value%20 != 0) {
          $halfStarFlag = true;
        }
        $node_image_fid = $key->get('field_actor_image')->target_id;
        if(!is_null($node_image_fid)) {
          $image_entity = \Drupal\file\Entity\File::load($node_image_fid);
          $image_entity_url = $image_entity->url();
        }
        else {
          $image_entity_url = "/sites/default/files/default_images/def_actor.jpeg";
        }
        // Storing all the info in items array for future use.
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
    // Storing actors url in it's 2D array.
    $count=0;
    foreach ($nids as $nid) {
      $items[$count]['actor_url'] = "/node/".$nid;
      $count = $count+1;
    }
    // kint($items);
    // Storing the information for Recent movie of the actor.
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
    // Returns the renderable array.
    return array(
      '#theme' => 'actor_list',
      '#items' => $items,
      '#title' => 'ACTOR LIST',
    );
  }

  /**
   * Provides a list of movies(published) in chronological order.
   *
   * @return array
   *  Returns a renderable array to it's twig file to display list.
   */
  public function movielist()
  {
    $form = \Drupal::formBuilder()->getForm(\Drupal\trial\Form\SearchByName::class);
    $form_rendered = \Drupal::service('renderer')->render($form);
    $name = \Drupal::request()->query->get('word');
    if ($name == " ") {
      $name=NULL;
    }
    //Query to fetch node id of actor whose name has been searched.
    $query = \Drupal::entityQuery('node')
     ->condition('status', 1)
     ->condition('type', 'actor')
     ->condition('title', $name, 'CONTAINS');
    $actor_id = $query->execute();
    //Query search for node id's of movies if actor's id is empty i.e. no result found.
    $bundle = 'movie';
    if (empty($actor_id) && $name) {
     $query = \Drupal::entityQuery('node')
         ->condition('status', 1)
         ->condition('type', $bundle)
         ->condition('title', $name, 'CONTAINS');
    }
    //Query used to fetch node id of movies if actor's id is not empty.
    elseif (!empty($actor_id) && $name) {
     $query = \Drupal::entityQuery('node')
       ->condition('status', 1)
       ->condition('type', $bundle)
       ->condition('field_actor_role.entity:paragraph.field_actor.target_id',$act_id);
    }
    // By default displays the list of all movies in chronological order.
    else {
      $query = \Drupal::entityQuery('node')
        ->condition('status', 1)
        ->condition('type', $bundle)
        ->sort('field_release_date', 'DESC');
    }
    $nids = $query->execute();
    // If result not found then show this message, else display the list.
    if (empty($nids)) {
      drupal_set_message("No Results Found");
      return $this->redirect('trial_movie');
    }
    else {
      // Movie nodes being loaded.
      $nodes = entity_load_multiple('node', $nids);
      // Getting all the values required to display movie's list.
      foreach ($nodes as $node) {
        $mid = $node->id();
        $title = $node->title->value;
        $body = $node->get('body')->value;
        $date = $node->get('field_release_date')->value;
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
        $node_image_fid = $node->get('field_poster')->target_id;
        if(!is_null($node_image_fid)) {
          $image_entity = \Drupal\file\Entity\File::load($node_image_fid);
          $image_entity_url = $image_entity->url();
        }
        else {
          $image_entity_url = "/sites/default/files/default_images/def_actor.jpeg";
        }
        $para = $node->field_actor_role->getValue();
        $actors = array();
        $count = 0;
        foreach ($para as $value) {
          // Loading paragraph having target id of actors of that movie.
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

    // Storing movie url in 2D array.
    $count=0;
    foreach ($nids as $nid) {
      $items[$count]['url_movie'] = "/node/".$nid;
      $count = $count+1;
    }
    // Returns the renderable array.
    return array(
      '#theme' => 'movie_list',
      '#items' => $items,
      '#title' => 'MOVIES LIST',
      '#form' => $form_rendered,
    );
  }

  /**
   * Function to fetch co-star details of the actor.
   *
   * @param  int $movie
   *  Node id of the movie of the co-star.
   * @param  int $nid
   *  Node id of the co-star.
   *
   * @return Object
   *  Returns a JsonResponse object to js file for displaying info in popup.
   */
  public function costar($movie=NULL, $nid=NULL)
  {
    // Node of movie being loaded.
    $node = Node::load($movie);
    $target_id = array();
    $target_id = $node->field_actor_role->getValue();
    foreach ($target_id as $value) {
      $paragraph = Paragraph::load($value['target_id']);
      $actor_id = $paragraph->field_actor->target_id;
      // Checks for actor id fetched with nid of co-star.
      if ($actor_id == $nid) {
        $role = $paragraph->field_role->value;
        $actor = Node::load($actor_id);
        $node_image_fid = $actor->field_actor_image->target_id;
        if(!is_null($node_image_fid)) {
          $image_entity = \Drupal\file\Entity\File::load($node_image_fid);
          $image_entity_url = $image_entity->url();
        }
        else {
          $image_entity_url = "/sites/default/files/default_images/def_actor.jpeg";
        }
        $node_title = $actor->title->value;
      }
    }
    // Save the required data in a array.
    $items = [
      'name' => $node_title,
      'image' => $image_entity_url,
      'role' => $role,
    ];
    // Returns the JsonResponse of the array.
    return new JsonResponse($items);
  }

}
