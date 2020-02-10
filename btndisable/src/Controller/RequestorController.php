<?php

namespace Drupal\btndisable\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;
use \Symfony\Component\HttpFoundation\Response;
use \Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class DefaultController.
 */
class RequestorController extends ControllerBase {


  public function matchrequestor(Request $request) {
    $course_name =  \Drupal::request()->request->get('course_name'); 
    $user = \Drupal::currentUser();
    $user_email = $user->getEmail();

    $study_guide = $lab_request = $practice_exam = false;

    $webform_study_guide = \Drupal\webform\Entity\Webform::load('study_guide');  //webform id is the webform name
    if ($webform_study_guide->hasSubmissions()) {
      $query = \Drupal::entityQuery('webform_submission')
        ->condition('webform_id', 'study_guide');
      $result = $query->execute();
      
      $submission_data_result = false;
      foreach ($result as $item) {
        $submission = \Drupal\webform\Entity\WebformSubmission::load($item);
        $submission_data = $submission->getData();  
        if($submission_data['requestor'] == $user_email && $submission_data['course_name'] == $course_name){
           $submission_data_result = true;
           break;
        }      
      }
      $study_guide = $submission_data_result;
    }
    
    $webform_lab_request = \Drupal\webform\Entity\Webform::load('lab_request');  //webform id is the webform name
    if ($webform_lab_request->hasSubmissions()) {
      $query = \Drupal::entityQuery('webform_submission')
        ->condition('webform_id', 'lab_request');
      $result = $query->execute();

      $submission_data_result = false;
      foreach ($result as $item) {
        $submission = \Drupal\webform\Entity\WebformSubmission::load($item);
        $submission_data = $submission->getData(); 
        if($submission_data['user'] == $user_email && $submission_data['course_name'] == $course_name){
           $submission_data_result = true;
           break;
        }      
      }
      $lab_request = $submission_data_result;
    }

    $webform_practice_exam = \Drupal\webform\Entity\Webform::load('practice_exam');  //webform id is the webform name
    if ($webform_practice_exam->hasSubmissions()) {
      $query = \Drupal::entityQuery('webform_submission')
        ->condition('webform_id', 'practice_exam');
      $result = $query->execute();
      
      $submission_data_result = false;
      foreach ($result as $item) {
        $submission = \Drupal\webform\Entity\WebformSubmission::load($item);
        $submission_data = $submission->getData();  
        if($submission_data['requestor'] == $user_email && $submission_data['course_name'] == $course_name){
           $submission_data_result = true;
           break;
        }      
      }
      $practice_exam = $submission_data_result;
    }

   return new JsonResponse(array('study_guide' => $study_guide, 'lab_request' => $lab_request, 'practice_exam' => $practice_exam));


  
  }

}
