<?php

class Bucket_Output_Options
{
   //need for the RSS file
   public $list_name;
   public $db_list_name;
   public $description;

   public $bucket_id;
   public $update_bucket; //false == new or false
   public $update_type; //replace or append
   public $use_owner;
   public $owner;
   public $carousel;

   public $copy_bucket; //set true if this is a copy_buckey

   public $db;

   function __construct()
   {
      $this->output_filename = "";
      $this->list_name = "";
      $this->db_list_name;
      $this->description = "";
      $this->bucket_id = -1;
      $this->update_bucket = false;
      $this->update_type = "new";
      $this->use_owner = false;
      $this->owner = "";
      $this->copy_bucket = false;
      $this->carousel = false;
   }

   function SetDb($db)
   {
      $this->db = $db;
   }

   function SetBucketName($name)
   {
      //add the date and some info to end of name to make it unique
      //what about when it's a scheduled list?
      $date = date('U');

      $this->db_list_name = $name." ***".$date;
      $this->list_name = $name;
   }

   function GetBucketName()
   {
      return str_replace("/!","!",$this->list_name);
   }

   function SetBucketDescription($val)
   {
      if ($val != "none") $this->description = $val;
   }

   function GetBucketDescription()
   {
      return str_replace("/!","!", $this->description);
   }

   function SetBucketId($id)
   {
      $this->update_bucket = true;
      $this->bucket_id = $id;
      //echo "bucket id=".$this->bucket_id.".\n";
   }

   function GetBucketId()
   {
      return $this->bucket_id;
   }

   function SetBucketUpdateType($type)
   {
      $this->update_type = $type;
   }

   function GetBucketUpdateType()
   {
      return $this->update_type;
   }

   function SetBucketOwner($owner)
   {
      $this->use_owner = true;
      $this->owner = $owner;
   }

   function UseOwner()
   {
      return $this->use_owner;
   }

   function GetBucketOwner()
   {
      return $this->owner;
   }

   function SetCopyBucket()
   {
      $this->copy_bucket = true;
   }

   function GetCopyBucket()
   {
      return $this->copy_bucket;
   }

   function SetCarousel()
   {
      $this->carousel = true;
   }

   function GetCarousel()
   {
       return $this->carousel;
   }

   function WriteBucket($bib_list, $system_id)
   {
      //make a new bucket with name and description created by list maker
      //save the bucket id

      if ($this->update_bucket && $this->update_type != "new")
      {
         if (strlen($this->db_list_name) > 0 )
         {
            //do an update not a insert - name and description only

            $bucket_name = str_replace("'","''",$this->db_list_name);
            $sql ="UPDATE container.biblio_record_entry_bucket
                  SET name = '$bucket_name'";

            if(strlen($this->description) > 0 )
            {
               $description = str_replace("'","''",$this->description);
               $sql .= ", description = '$description'";
            }
            $sql .= " WHERE id = $this->bucket_id
                     RETURNING id";

            echo $sql."\n";

            $result = pg_query($this->db,$sql);

         }
         else if (strlen($this->description) > 0)
         {
             $description = str_replace("'","''",$this->description);
             $sql ="UPDATE container.biblio_record_entry_bucket
                    SET description = '$description'
                    WHERE id = $this->bucket_id
                    RETURNING id";

            echo $sql."\n";

            $result = pg_query($this->db,$sql);
         }

         echo "Bag id =".$this->GetBucketId()."\n";

      }
      else if (!$this->update_bucket)
      {
         if ($this->UseOwner() )
         {
            //get the user name from the database
				$user_sql = "SELECT id
							 FROM actor.usr
							 WHERE usrname = '$this->owner'";

				$result = pg_query($this->db,$user_sql);

				$row = pg_fetch_row($result);

				$user= $row[0];
         }
         else
         {
            $user = intval(GetListMakerUserId($system_id));
         }

         $bucket_name = str_replace("'","''",$this->db_list_name);
         $description = str_replace("'","''",$this->description);

         if ($this->carousel)
         {
            //owner needs to be system or branch if single branch library
            $carousel_name = $bucket_name."-carousel";
            $lib_id = $this->GetCarouselLibId($system_id);
            //echo "System id = ".$system_id." Carousel= ".$lib_id."\n";

            $sql = "INSERT INTO container.biblio_record_entry_bucket (owner, name, btype, description, pub, owning_lib)
                    VALUES ($user, '$carousel_name' ,'carousel', '$description', true, $lib_id)
                    RETURNING id";
         }
         else
         {

            $sql = "INSERT INTO container.biblio_record_entry_bucket (owner, name, btype, description, pub, owning_lib)
                    VALUES ($user, '$bucket_name' ,'bookbag', '$description', true, $system_id)
                    RETURNING id";
         }

         echo $sql."\n";

         $result = pg_query($this->db,$sql);

         $row = pg_fetch_row($result);

         $this->SetBucketId($row[0]);

         echo "Bag id =".$this->GetBucketId()."\n";

         if ($this->carousel)
         {
            //add an entry to the carousel table
            $sql = "INSERT INTO container.carousel (type, owner, name, bucket, creator, editor, create_time, edit_time, max_items)
                    VALUES (101, $lib_id, '$carousel_name',$this->bucket_id , $user, $user, now(), now(), 100)";

            $result = pg_query($this->db,$sql);
            echo $sql."\n";;
         }
      }

		if($this->update_bucket && $this->update_type != "append")
		{
			//remove all the entries in the bag
			$remove_sql = "DELETE FROM container.biblio_record_entry_bucket_item
								WHERE bucket = $this->bucket_id";

			$remove_result = pg_query($this->db,$remove_sql);
		}

		foreach ($bib_list->multiple_copy_recs as $curr_bib)
		{
			//Put all the bib ids into the bucket

			$bib_id = $curr_bib->GetBibId();

			$item_sql = "INSERT INTO container.biblio_record_entry_bucket_item (bucket, target_biblio_record_entry)
							 VALUES($this->bucket_id, $bib_id)";
			$item_result = pg_query($this->db,$item_sql);

		}

		if ($bib_list->HasOnlineRecs())
		{
			foreach ($bib_list->online_recs  as $curr_bib)
			{
				//Put all the bib ids into the bucket

				$bib_id = $curr_bib->GetBibId();

				$item_sql = "INSERT INTO container.biblio_record_entry_bucket_item (bucket, target_biblio_record_entry)
								 VALUES($this->bucket_id, $bib_id)";
				$item_result = pg_query($this->db,$item_sql);
			}
		}
   }

   function WriteCopyBucket($bib_list, $system_id)
   {
      //make a new bucket with name and description created by list maker
      //save the bucket id

      if ($this->update_bucket && $this->update_type != "new")
      {
         if (strlen($this->db_list_name) > 0 )
         {
            //do an update not a insert - name and description only
            $bucket_name = str_replace("'","''",$this->db_list_name);
            $sql ="UPDATE container.copy_bucket
                  SET name = '$this->db_list_name'";

            if(strlen($this->description) > 0 )
            {

               $description = str_replace("'","''",$this->description);
               $sql .= ", description = '$this->description'";
            }
            $sql .= " WHERE id = $this->bucket_id
                     RETURNING id";

            echo $sql."\n";
            $result = pg_query($this->db,$sql);

         }
         else if (strlen($this->description) > 0)
         {
             $description = str_replace("'","''",$this->description);
             $sql ="UPDATE container.copy_bucket
                    SET description = '$this->description'
                    WHERE id = $this->bucket_id
                    RETURNING id";

            echo $sql."\n";
            $result = pg_query($this->db,$sql);
         }

         echo "Bag id =".$this->GetBucketId()."\n";

      }
      else if (!$this->update_bucket)
      {
         if ($this->UseOwner() )
         {
            //get the user name from the database
				$user_sql = "SELECT id
								 FROM actor.usr
								 WHERE usrname = '$this->owner'";

				$result = pg_query($this->db,$user_sql);

				$row = pg_fetch_row($result);

				$user= $row[0];
         }
         else
         {
            $user = intval(GetListMakerUserId($system_id));
         }

         $bucket_name = str_replace("'","''",$this->db_list_name);
         $description = str_replace("'","''",$this->description);


         $sql = "INSERT INTO container.copy_bucket (owner, name, btype, description,  owning_lib)
                 VALUES ($user, '$this->db_list_name' ,'staff_client', '$this->description',  $system_id)
                 RETURNING id";

         echo $sql."\n";

         $result = pg_query($this->db,$sql);

         $row = pg_fetch_row($result);

         $this->SetBucketId($row[0]);

         echo "Bag id =".$this->GetBucketId()."\n";
      }


		if($this->update_bucket && $this->update_type != "append")
		{
			//remove all the entries in the bag
			$remove_sql = "DELETE FROM container.copy_bucket_item
								WHERE bucket = $this->bucket_id";

			$remove_result = pg_query($this->db,$remove_sql);
		}

		foreach ($bib_list->one_bib_one_copy_recs as $curr_lib)
		{
			$bibs = $curr_lib->bib_copy_list;
			//Put all the bib ids into the bucket

			foreach($bibs as $curr_bib)
			{
				$curr_copy =  $curr_bib->GetCopyRec()->GetCopyId();

				$item_sql = "INSERT INTO container.copy_bucket_item (bucket, target_copy)
								 VALUES($this->bucket_id, $curr_copy)";
				$item_result = pg_query($this->db,$item_sql);
			}

		}
   }

   function GetCarouselLibId ($system_id)
   {
      //if BEVERLY EVERETT or PHILLIPS leave as is.
      if ($system_id == 1 || $system_id == 2 || $system_id == 14 || $system_id == 49)
      {
         return $system_id;
      }

      //this is a single branch library, get the child id
      return $system_id+1;
   }

   function GetEmailText($include_link, $domain)
   {
       if ($this->copy_bucket)$message = "Item Bucket OUTPUT\n";
       else $message = "Bucket OUTPUT\n";

       $message .="Options \n";

       $message .="List Name: ".$this->GetBucketName()."\n";
       $message .="Description: ".$this->GetBucketDescription()."\n";
       $message .="Update: ".ucwords($this->GetBucketUpdateType())."\n";
       if ($this->UseOwner() )$message .="Owner: ".$this->GetBucketOwner()."\n";

       $message .= "Bucket Id: ".$this->GetBucketId()."\n\n";

       if ($include_link)
       {
          if ($this->copy_bucket)
          {
             $message .= "Web Client Link = https://evergreen.noblenet.org/eg/staff/cat/bucket/copy/view/".$this->GetBucketId()."\n";
          }
          else if ($this->carousel)
          {
             $message .= "To add this carousel to your catalog page visit the Carousels Visible at Library Configuration at https://evergreen.noblenet.org/eg2/en-US/staff/admin/local/container/carousel_org_unit  \n";
             $message .= "Web Client Link = https://evergreen.noblenet.org/eg/staff/cat/bucket/record/view/".$this->GetBucketId()."\n";

          }
          else
          {
             $message .= "Web Client Link = https://evergreen.noblenet.org/eg/staff/cat/bucket/record/view/".$this->GetBucketId()."\n";
             $message .= "OPAC Link = https://".$domain.".noblenet.org/eg/opac/bookbag?bookbag=".$this->GetBucketId()."\n";
             $message .= "Title Sort OPAC Link = https://".$domain.".noblenet.org/eg/opac/bookbag?bookbag=".$this->GetBucketId()."&sort=titlesort\n";
             $message .= "Author Sort OPAC Link = https://".$domain.".noblenet.org/eg/opac/bookbag?bookbag=".$this->GetBucketId()."&sort=authorsort\n";
             $message .= "Pub Date Sort OPAC Link = https://".$domain.".noblenet.org/eg/opac/bookbag?bookbag=".$this->GetBucketId()."&sort=pubdate.descending\n\n";

             $message .= "If you want your list to display in Detail view, add this to the end of the URL: &detail_record_view=1\n";
             $message .= "If you want your list to display only records with at least one available item, add this to the end of the URL:  &modifier=available\n";

          }
       }

       return $message;
   }

   function GetHTMLText()
   {
       $bag_out ="<div class=\"output_block\">";
       if ($this->copy_bucket)
       {
          $bag_out .= "<h3> Item Bucket</h3>";
       }
       else
       {
          $bag_out .= "<h3>Bucket</h3>";
       }


       $bag_out .= "<div class=\"bucket_params\">";

       $bag_out .="List Name: ".$this->GetBucketName()."<br/>";
       $bag_out .="Description: ".$this->GetBucketDescription()."<br/>";
       $bag_out .="Update: ".ucwords($this->GetBucketUpdateType())."<br/>";
       if ($this->UseOwner() )$bag_out .="Owner: ".$this->GetBucketOwner()."<br/>";
       if ($this->GetCarousel() ) $bag_out .="Carousel: Yes <br/>";
       else $bag_out .="Carousel: No <br/>";

       $bag_out .= "Bucket Id: ".$this->GetBucketId()."\n\n";

       $bag_out .="</div></div>";
       return $bag_out;
   }

   function GetReportLinkText()
   {
      if ($this->copy_bucket)$report_link = "copy_bucket*";
      else $report_link = "bucket*";
      $report_link .= "bucket_id*".$this->GetBucketId()."*";
      if (strlen($this->list_name) > 0)
      {
         $report_link .= "bucket_name*".urlencode(str_replace("\"","",$this->GetBucketName()))."*";
      }
      if (strlen($this->description) > 0)
      {
         $report_link .= "bucket_desc*".urlencode(str_replace("\"","",$this->GetBucketDescription()))."*";
      }
      $report_link .= "update_type*".urlencode(str_replace("\"","",$this->GetBucketUpdateType()))."*";
      if ($this->UseOwner() )$report_link .= "bucket_owner*".urlencode(str_replace("\"","",$this->GetBucketOwner()))."*";
      if ($this->GetCarousel()) $report_link .= "carousel*";

      return $report_link;
   }

}


?>