<?php

class AuthorList
{
   public $author_data; //array of the author information

   public $num_authors;
   public $num_no_author;
   public $count_circs_between;

   function __construct()
   {
      $this->author_data = array();
      $this->num_authors = 0;
      $this->num_no_author = 0;
      $this->count_circs_between = false;
   }

   function __destruct()
   {
      unset($this->author_data);
   }

   function SetCircsBetween()
   {
      $this->count_circs_between = true;
   }

   function GetCircsBetween()
   {
      return $this->count_circs_between;
   }

   function AddAuthorItem($bib_rec, $copy_rec)
   {
       //check array to see if author is already added
       //if yes increment - circs, bib, copesor
       $name = trim($bib_rec->GetSearchAuthor());
       $name = trim($name, ".");

       if (strlen($name) < 2 )
       {
          $this->num_no_author++;
       }
       else if (array_key_exists($name, $this->author_data))
       {
           $this->author_data[$name]->AddBib($bib_rec->GetBibId());
           $this->author_data[$name]->AddCopy();
           $this->author_data[$name]->AddCircs($copy_rec->GetLifetimeCircs());
           if ($this->count_circs_between) $this->author_data[$name]->AddCircsBetween($copy_rec->GetCircsBetween());
       }
       else
       {
           $curr_author = new AuthorRec();

           $curr_author->SetAuthorName($name);

           $curr_author->AddBib($bib_rec->GetBibId());
           $curr_author->AddCopy();
           $curr_author->AddCircs($copy_rec->GetLifetimeCircs());
           if ($this->count_circs_between) $curr_author->AddCircsBetween($copy_rec->GetCircsBetween());

           $this->author_data[$name] = $curr_author;
       }

       //else add a new author
   }

   function NameSort($rec1, $rec2)
   {
      return strcasecmp($rec1->GetAuthorName(), $rec2->GetAuthorName());
   }

   function SortByName()
   {
      echo "In SortByName\n";
      usort($this->author_data, array("AuthorList","NameSort"));
   }
}

class AuthorRec
{
   public $author_name;
   public $bib_ids;

   //USED FOR SPREADSHEET
   public $total_copies;
   public $total_bibs;
   public $total_circs;

   public $total_circs_between;

   function __construct()
   {
      $this->total_bibs = 0;
      $this->total_copies = 0;
      $this->total_circs = 0;
      $this->total_circs_between = 0;

      $this->bib_ids = array();
   }

   function __destruct()
   {
      unset($this->bib_ids);
   }

   function SetAuthorName($name)
   {
      $this->author_name = $name;
   }

   function GetAuthorName()
   {
      return $this->author_name;
   }

   function SetCircBetween()
   {
      $this->count_circs_between = true;
   }

   function AddCopy()
   {
      $this->total_copies++;
   }

   function GetNumCopies()
   {
      return $this->total_copies;
   }

   function AddBib($bib_id)
   {
      if (array_search($bib_id, $this->bib_ids) === false)
      {
         $this->total_bibs++;
         $this->bib_ids[] = $bib_id;
      }
   }

   function GetNumBibs()
   {
      return $this->total_bibs;
   }

   function AddCircs($val)
   {
      $this->total_circs += $val;
   }

   function GetNumCircs()
   {
      return $this->total_circs;
   }

   function AddCircsBetween($val)
   {
      $this->total_circs_between += $val;
   }

   function GetNumCircsBetween()
   {
      return $this->total_circs_between;
   }

}

?>