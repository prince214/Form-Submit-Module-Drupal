/**
 * @file
 * Global utilities.
 *
 */
(function ($, Drupal) {

  'use strict';

   jQuery(document).ready(function($a){


    $a('.webform-button--submit').click(function(){
      $a(this).attr("disabled", true);
      $a(this).addClass('btn-outline--secondary');
    });
   
    if($a("input[name=course_name]").val() !== "undefined"){
      $a.ajax({
        url: "/call/ajaxdata", 
        method :'POST',
        data: { course_name: $a("input[name=course_name]").val() },
        dataType: "json", 
        success: function(response){
           if(response.study_guide == true){
            $a('.webform-submission-study-guide-form').find('button').addClass('btn-outline--secondary');
            $a('.webform-submission-study-guide-form').find('button').attr("disabled", true);
           }
           if(response.lab_request == true){
              $a('.webform-submission-lab-request-form').find('button').addClass('btn-outline--secondary');
             $a('.webform-submission-lab-request-form').find('button').attr("disabled", true);
           }
           if(response.practice_exam == true){
              $a('.webform-submission-practice-exam-form').find('button').addClass('btn-outline--secondary');
             $a('.webform-submission-practice-exam-form').find('button').attr("disabled", true);
           }
        }
     });
    }

    

});


})(jQuery, Drupal);
