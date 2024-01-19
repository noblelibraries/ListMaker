<?php

//list of all the copies for one branch -- grouped by bib id
class CopyList
{
   public $lib_shortname;
   public $lib_id;
   public $copies; //array of copy Recs
   public $total_circs;
   public $circs_between = 0;
   public $course_circs = 0;
   public $total_copies;
   public $ytd_circs;

   function __construct()
   {
      $this->lib_shortname="";
      $this->lib_id = -1;
      $this->copies = array();
      $this->total_circs = 0;
      $this->total_copies = 0;
      $this->circs_between = 0;
      $this->course_circs = 0;
      $this->ytd_circs = 0;
   }

   function __destruct()
   {
      unset($this->copies);
   }

   function AddCopy($copy_rec) //increment circs, total copies
   {
      $this->ytd_circs += $copy_rec->GetYTDCirc();
      $this->total_circs += $copy_rec->GetLifetimeCircs();
      $this->total_copies++;
      $this->copies[]= $copy_rec;

      if ($copy_rec->GetCircsBetween() > -1) $this->circs_between += $copy_rec->GetCircsBetween();
      if ($copy_rec->GetCourseCirc() > -1) $this->course_circs += $copy_rec->GetCourseCirc();
   }

   function SetLibrary($shortname, $id)
   {
      $this->lib_shortname = $shortname;
      $this->lib_id = $id;
   }

   function GetShortname()
   {
      return $this->lib_shortname;
   }

   function GetLibId()
   {
      return $this->lib_id;
   }

   function GetCircsBetween()
   {
      return $this->circs_between;
   }

   function GetCourseCirc()
   {
       return $this->course_circs;
   }

   function GetTotalCircs()
   {
      return $this->total_circs;
   }

   function GetTotalCopies()
   {
      return $this->total_copies;
   }

   function GetYTDCircs()
   {
      return $this->ytd_circs;
   }

   function GetCircsPerCopy()
   {
      $circs = array();
      foreach($this->copies as $copy)
      {
         $circs[] = $copy->GetLifetimeCircs();
      }

      return $circs;
   }

}

?>