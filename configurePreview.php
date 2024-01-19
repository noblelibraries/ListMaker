<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta http-equiv="Cache-control" content="no-cache">
<meta http-equiv="Expires" content="-1">
<meta http-equiv="pragma" content="no-cache">

<title>Configure Preview output </title>

<link rel="stylesheet" type="text/css" href="../css/noble.css" />

<script src="../../shared/sweetalert2/dist/sweetalert2.min.js"></script>
<link rel="stylesheet" type="text/css" href="../../shared/sweetalert2/dist/sweetalert2.css">

<script type="text/javascript">

function SetCallNumDisplay()
{
   document.getElementById('call_number').checked = true;
}

function SetGridWidth()
{
   document.getElementById('grid_width').value='3';

   //set all display options to false.
   document.getElementById('author').checked = false;
   document.getElementById('call_number').checked = false;
   document.getElementById('cover_image').checked = true;
   document.getElementById('part').checked = false;
   document.getElementById('title').checked = false;

   var checkbox_array = document.getElementsByName('options');
   for(var i=0; i<checkbox_array.length; i++)
   {
      checkbox_array[i].checked = false;
   }

   document.getElementById('display').style.display = "none";

   document.getElementById('group_copy').style.display ="none";

}

function ShowDisplayOptions()
{
   document.getElementById('grid_width').value='';
   document.getElementById("display").style.display = "block";
   document.getElementById('group_copy').style.display ="inline-block";

   document.getElementById('author').checked = true;
   document.getElementById('call_number').checked = true;
   document.getElementById('cover_image').checked = true;
   document.getElementById('part').checked = true;
   document.getElementById('title').checked = true;
}


function setPreviousPreview()
{
   var order = "<?php echo $_GET['order'] ?>";
   var display = "<?php echo $_GET['display'] ?>";
   var layout = "<?php echo $_GET['layout'] ?>";
   var options = "<?php echo $_GET['options'] ?>";

   if (order.includes('Title')) document.getElementById('title_order').checked = true;
   else if (order.includes('Author')) document.getElementById('author_order').checked = true;
   else if (order.includes('Call')) document.getElementById('call_num_order').checked = true;

   if (layout.includes('Block')) document.getElementById('block_layout').checked = true;
   else if (layout.includes('Inline')) document.getElementById('inline_layout').checked = true;
   else if (layout.includes('Grid'))
   {
      document.getElementById('grid_layout').checked = true;

      //find the number and fill the box
      var val =layout.substring(4);
      document.getElementById('grid_width').value = val.toString();


      document.getElementById('display').style.display = "none";

      document.getElementById('group_copy').style.display ="none";
   }

   if (options.includes('GroupItemsFirst'))
   {
      document.getElementById('group_copies').checked = true;
      document.getElementById('first_copy').checked = true;
   }
   else if (options.includes('GroupItemsAll'))
   {
      document.getElementById('group_copies').checked = true;
      document.getElementById('all_copies').checked = true;
   }

   if (options.includes('ImageSizeSmall'))
   {
      document.getElementById('small').checked = true;
   }
   else if (options.includes('ImageSizeSmall'))
   {
      document.getElementById('medium').checked = true;
   }
   else if (options.includes('ImageSizeLarge'))
   {
      document.getElementById('large').checked = true;
   }

   //pull apart the display string and figure out what needs to be checked
   if (display.includes('Author')) document.getElementById('author').checked = true;
   if (display.includes('CallNumber')) document.getElementById('call_number').checked = true;
   if (display.includes('Cover')) document.getElementById('cover_image').checked = true;
   if (display.includes('Title')) document.getElementById('title').checked = true;

   if (display.includes('Active')) document.getElementById('active_date').checked = true;
   if (display.includes('AgeProtection')) document.getElementById('age_protection').checked = true;
   if (display.includes('AmazonDirect')) document.getElementById('amazon_direct').checked = true;
   if (display.includes('AmazonSearch')) document.getElementById('amazon_search').checked = true;
   if (display.includes('Barcode')) document.getElementById('barcode').checked = true;
   if (display.includes('BibId')) document.getElementById('bib_id').checked = true;
   if (display.includes('CircLib')) document.getElementById('circ_lib').checked = true;
   if (display.includes('CircModifier')) document.getElementById('circ_modifier').checked = true;
   if (display.includes('ShelvingLocation')) document.getElementById('copy_loc').checked = true;
   if (display.includes('ItemStatus')) document.getElementById('copy_status').checked = true;
   if (display.includes('InHouse')) document.getElementById('in_house').checked = true;
   if (display.includes('Goodreads')) document.getElementById('goodreads').checked = true;
   if (display.includes('GoogleBooks')) document.getElementById('google').checked = true;
   if (display.includes('Part')) document.getElementById('part').checked = true;
   if (display.includes('PubDate')) document.getElementById('pub_date').checked = true;
   if (display.includes('Publisher')) document.getElementById('publisher').checked = true;
   if (display.includes('StatCat')) document.getElementById('stat_cat').checked = true;
   if (display.includes('StatusChange')) document.getElementById('status_change').checked = true;
   if (display.includes('Summary')) document.getElementById('summary').checked = true;
}

function submitPreview()
{
   var order = "";
   var layout= "";
   var display ="";
   var options="";

   if (document.getElementById('title_order').checked) order = 'Title';
   else if (document.getElementById('author_order').checked) order = 'Author';
   else if (document.getElementById('call_num_order').checked) order = 'Call Number';


   if (document.getElementById('block_layout').checked) layout = 'Block';
   else if (document.getElementById('inline_layout').checked) layout = 'Inline';
   else if (document.getElementById('grid_layout').checked)
   {
      layout = 'Grid '+document.getElementById('grid_width').value;
   }

   if (document.getElementById('group_copies').checked)
   {
      if (document.getElementById('first_copy').checked) options += "groupfirst*";
      else if (document.getElementById('all_copies').checked) options += "groupall*";
   }

   if (document.getElementById('small').checked) options += "imagesmall*";
   else if (document.getElementById('medium').checked) options += "imagemedium*";
   else if (document.getElementById('large').checked) options += "imagelarge*";

   //make a display string to send back. Use * to separate
   if (document.getElementById('author').checked) display += "author*";
   if (document.getElementById('call_number').checked) display += "callnum*";
   if (document.getElementById('cover_image').checked) display += "cover*";
   if (document.getElementById('title').checked) display += "title*";

   if (document.getElementById('active_date').checked) display += "active*";
   if (document.getElementById('age_protection').checked) display += "ageprotection*";
   if (document.getElementById('amazon_direct').checked) display += "adirect*";
   if (document.getElementById('amazon_search').checked) display += "asearch*";
   if (document.getElementById('barcode').checked) display += "barcode*";
   if (document.getElementById('bib_id').checked) display += "bibid*";
   if (document.getElementById('circ_lib').checked) display += "circlib*";
   if (document.getElementById('circ_modifier').checked) display += "circmod*";
   if (document.getElementById('copy_loc').checked) display += "copyloc*";
   if (document.getElementById('copy_status').checked) display += "copystatus*";
   if (document.getElementById('goodreads').checked) display += "goodreads*";
   if (document.getElementById('google').checked) display += "google*";
   if (document.getElementById('part').checked) display += "part*";
   if (document.getElementById('pub_date').checked) display += "pubdate*";
   if (document.getElementById('publisher').checked) display += "publisher*";
   if (document.getElementById('stat_cat').checked) display += "statcat*";
   if (document.getElementById('status_change').checked) display += "statuschange*";
   if (document.getElementById('summary').checked) display += "summary*";

   window.opener.HandlePreviewResult(order, display, layout, options);
   window.opener = self;
   window.close();
   return false;
}

function cancelPreview()
{
   window.opener.HandlePrevireResult();
   window.close();
   return false;
}

function newPopup(url)
{
	popupWindow = window.open(url,'popUpWindow','height=700,width=800,left=10,top=10,resizable=yes,scrollbars=no,toolbar=no,menubar=no,location=no,directories=no,status=yes')
}


function selectAll(all)
{
   var checkbox_array = document.getElementsByName('options');
   for(var i=0; i<checkbox_array.length; i++)
   {
      checkbox_array[i].checked = all.checked;
   }
}



</script>
</head>


<body onload="setPreviousPreview()">

<div id="content">

<h1 class="stat_cats">Configure Preview Output </h1>

<form id="stats" >
<div id="preview_form">

<div class="done">
	<input type="button" value="Cancel" class="stats" onClick="return cancelPreview()"/>
	<input type="button" value="Done" class="stats" onClick="return submitPreview()"/>
</div>


<h3 class="weeding"> Sort Order: </h3>
<p class="weeding">
      <input type="radio" name="order" value="title" id="title_order">Title <br/>
      <input type="radio" name="order" value="author" id="author_order">Author<br/>
      <input type="radio" name="order" value="call" id="call_num_order" onclick="SetCallNumDisplay()" checked>Call Number <br/>
</p>

<hr />

<h3 class="weeding"> Layout: </h3>
   <p class="weeding">
      <input type="radio" name="layout" value="block" id="block_layout"  onclick="ShowDisplayOptions()">
         <label id="block_label">Block&nbsp;</label>
            <a href="JavaScript:newPopup('https://ocean.noblenet.org/tools/common/block_list.png');" class="example"><img src='https://ocean.noblenet.org/shared/images/question-mark-small.png' class="help" /></a><br />

     <input type="radio" name="layout" value="inline" id="inline_layout" onclick="ShowDisplayOptions()" disabled>
     <label id="inline_label">Inline&nbsp;</label>
               <a href="JavaScript:newPopup('https://ocean.noblenet.org/tools/common/inline_list.png');" class="example"><img src='https://ocean.noblenet.org/shared/images/question-mark-small.png' class="help" /></a><br />

     <input type="radio" name="layout" value="grid" id="grid_layout" onclick="SetGridWidth()" >
      <label id="cover_grid_label">Cover Grid</label>&nbsp;&nbsp;
           <span class="note">Grid Width </span>
           <input type="text" id="grid_width" size="2">

           <a href="JavaScript:newPopup('https://ocean.noblenet.org/tools/common/cover_grid.png');" class="example"><img src='https://ocean.noblenet.org/shared/images/question-mark-small.png' class="help" /></a>
    </p>
<hr />


   <div id="display">

   <h3 class="weeding"> Display Options: </h3>
   <table id="display_table">
   <tbody>
   <tr>
     <td>

     <table id="display_defaults">
      <thead>
         <th> Defaults </th>
      </thead>

      <tbody>

        <tr>
        <td>
         <input type="checkbox" id="author" name="author"  />
         <label id="author_label"> Author</label><br />
        </td>
      </tr>

      <tr>
        <td>
         <input type="checkbox" id="call_number" name="call_number"/>
         <label id="call_number_label"> Call Number </label> <img src='https://ocean.noblenet.org/shared/images/question-mark-small.png' class="help" onclick="JavaScript:swal('Call Number','Call Number Prefix and Suffix will be included.', 'info');" />
        </td>
      </tr>

      <tr>
         <td>
           <input type="checkbox" id="cover_image" name="cover_image"  />
           <label id="cover_image_label"> Cover Image</label>
         </td>
      </tr>

      <tr>
        <td>
           <input type="checkbox" id="title" name="title"  />
           <label id="title_label"> Title</label>
         </td>
      </tr>

      </tbody>
      </table>
      </td>

     <td>

      <table id="display_options">
      <thead>
         <th> Optional
                <input type="checkbox" id="all" name="all" onClick="selectAll(this)"/>
                <label id="all_label" style="font-weight:normal;"> Select All</label>
         </th>
      </thead>
      <tbody>

      <tr>
        <td>
          <input type="checkbox" name="options" id="active_date"/>
          <label id="active_date_label"> Active Date </label><br />
        </td>
      </tr>

       <tr>
        <td>
          <input type="checkbox" name="options" id="age_protection"/>
          <label id="age_protect_label"> Age Protection </label><br />
        </td>
      </tr>

      <tr>
        <td>
         <input type="checkbox" id="amazon_direct" name="options"/>
         <label id="amazon_direct_label"> Amazon Direct Link </label> <img src='https://ocean.noblenet.org/shared/images/question-mark-small.png' class="help" onclick="JavaScript:swal('Amazon Direct Link','Link to an Amazon ISBN search.', 'info');"/>
       </td>
      </tr>

      <tr>
        <td>
         <input type="checkbox" id="amazon_search" name="options"/>
         <label id="amazon_search"> Amazon Search Link </label><img src='https://ocean.noblenet.org/shared/images/question-mark-small.png' class="help" onclick="JavaScript:swal('Amazon Search Link','Link to an Amazon title search.', 'info');" />
        </td>
      </tr>

      <tr>
        <td>
          <input type="checkbox" id="barcode" name="options" onchange="setBranchCheckbox(this.checked)"/>
          <label id="barcode_label"> Barcode </label>
        </td>
      </tr>

      <tr>
        <td>
          <input type="checkbox" id="bib_id" name="options"/>
         <label id="bib_id_label"> Bib Id </label> <img src='https://ocean.noblenet.org/shared/images/question-mark-small.png' class="help" onclick="JavaScript:swal('Bib Id','Also known as Database Id, Document Id or Record Id.', 'info');" />
        </td>
      </tr>

      <tr>
        <td>
          <input type="checkbox" id="circ_lib" name="options" />
          <label id="branch_label"> Circ Lib </label>
        </td>
      </tr>

       <tr>
        <td>
          <input type="checkbox" id="circ_modifier" name="options" />
          <label id="circ_modifier_label"> Circ Modifier</label>
        </td>
      </tr>

      <tr>
        <td>
           <input type="checkbox" id="copy_loc" name="options" />
           <label id="copy_loc_label"> Shelving Location</label>
        </td>
      </tr>

      <tr>
        <td>
          <input type="checkbox" id="copy_status" name="options" />
          <label id="status_label"> Item Status </label>
        </td>
      </tr>

       <tr>
        <td>
          <input type="checkbox" id="goodreads" name="options" />
          <label id="goodreads_label"> Goodreads Link </label><img src='https://ocean.noblenet.org/shared/images/question-mark-small.png' class="help" onclick="JavaScript:swal('Goodreads Link','Link to a Goodreads search for title.', 'info');"/>
        </td>
      </tr>

       <tr>
        <td>
          <input type="checkbox" id="google" name="options" disabled />
          <label id="google_label"> Google Books Link </label>
        </td>
      </tr>


       <tr>
        <td>
         <input type="checkbox" id="part" name="options"  />
         <label id="part_label"> Part</label><br />
       </td>
      </tr>

      <tr>
        <td>
          <input type="checkbox" id="pub_date" name="options" />
          <label id="pub_date_label"> Publication Date</label>
        </td>
      </tr>

      <tr>
        <td>
          <input type="checkbox" id="publisher" name="options" />
          <label id="publisher_label"> Publisher</label>
        </td>
      </tr>

      <tr>
        <td>
          <input type="checkbox" id="stat_cat" name="options"/>
          <label id="stat_cat_label"> Statistical Category </label>
        </td>
      </tr>

        <tr>
        <td>
          <input type="checkbox" id="status_change" name="options" />
          <label id="status_change_label"> Status Change Date </label>
        </td>
      </tr>

      <tr>
        <td>
          <input type="checkbox" id="summary" name="options" />
          <label id="summary_label"> Summary </label>
        </td>
      </tr>

      </tbody>
      </table>

     </td>
     </tr>
     </tbody>
     </table>
  <hr />

   </div>


<h3 class="weeding"> Options: </h3>
  <p class="html_options">

      <label for="image_size"> Image Size </label><img src='https://ocean.noblenet.org/shared/images/question-mark-small.png' class="help" onclick="JavaScript:swal('Image Size','Size of Cover Image to display. Based on image version in Evergreen.','info');"/><br/>
      <input type="radio" name="image_size" value="small" id="small" class="indent">Small <br/>
      <input type="radio" name="image_size" value="medium" id="medium" class="indent" checked>Medium<br/>
      <input type="radio" name="image_size" value="large" id="large" class="indent">Large<br/>

      <input type="checkbox" id="group_copies" name="group_copies" />
      <label for="group_copies"> Group Items </label><img src='https://ocean.noblenet.org/shared/images/question-mark-small.png' class="help" onclick="JavaScript:swal('Group Items','Will only write one set of information for multiple copies of the same title.','info');" />

      <div id="group_copy">
      <input type="radio" name="copies" value="first" id="first_copy" class="indent" checked>Show only First Item <br/>
      <input type="radio" name="copies" value="all" id="all_copies" class="indent">Show All Items<br/>
      </div>

 </p>

    <div id="debug"></div>

<div class="done">
	<input type="button" value="Cancel" class="stats" onClick="return cancelPreview()"/>
	<input type="button" value="Done" class="stats" onClick="return submitPreview()"/>
</div>

</div> <!-- endstat form -->
</form>

</div><!--end content-->

</body>
</html>