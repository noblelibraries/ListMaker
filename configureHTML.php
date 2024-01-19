<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta http-equiv="Cache-control" content="no-cache">
<meta http-equiv="Expires" content="-1">
<meta http-equiv="pragma" content="no-cache">

<title>Configure HTML output </title>

<link rel="stylesheet" type="text/css" href="../css/noble.css" />

<script src="../../shared/sweetalert2/dist/sweetalert2.min.js"></script>
<link rel="stylesheet" type="text/css" href="../../shared/sweetalert2/dist/sweetalert2.css">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="https://code.jquery.com/jquery-1.9.1.js"></script>
<script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

<script type="text/javascript">

function SetCallNumDisplay()
{
   document.getElementById('call_number').checked = true;
}

function SetActiveDate()
{
   document.getElementById('active_date').checked=true;
}

function SetLifetimeCircs()
{
   document.getElementById('lifetime_circ').checked=true;
}

function SetYTDCircs()
{
   document.getElementById('ytd_circ').checked=true;
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

   document.getElementById("no-inline-sort").style.display = "inline";
   document.getElementById("no-inline-image").style.display = "inline";

}

function ShowDisplayOptions()
{
   document.getElementById('grid_width').value='';
   document.getElementById("display").style.display = "block";
   document.getElementById("display_options").style.display = "block";
   document.getElementById('group_copy').style.display ="inline-block";

   document.getElementById('author').checked = true;
   document.getElementById('call_number').checked = true;
   document.getElementById('cover_image').checked = true;
   document.getElementById('title').checked = true;

   document.getElementById("no-inline-sort").style.display = "inline";
   document.getElementById("no-inline-image").style.display = "inline";
   document.getElementById("no-inline-cover").style.display = "inline";

}

function ShowInlineDisplayOptions()
{
   document.getElementById('grid_width').value='';
   document.getElementById("display_options").style.display = "none";
   document.getElementById('group_copy').style.display ="inline-block";

   document.getElementById('author').checked = true;
   document.getElementById('call_number').checked = true;
   document.getElementById('cover_image').checked = false;
   document.getElementById('title').checked = true;

   var checkbox_array = document.getElementsByName('options');
   for(var i=0; i<checkbox_array.length; i++)
   {
      checkbox_array[i].checked = false;
   }

   document.getElementById("no-inline-sort").style.display = "none";
   document.getElementById("no-inline-image").style.display = "none";
   document.getElementById("no-inline-cover").style.display = "none";

}

function setPreviousHTML()
{
   var order = "<?php echo $_GET['order'] ?>";
   var display = "<?php echo $_GET['display'] ?>";
   var layout = "<?php echo $_GET['layout'] ?>";
   var options = "<?php echo $_GET['options'] ?>";

   if (order.includes('Title')) document.getElementById('title_order').checked = true;
   else if (order.includes('Author')) document.getElementById('author_order').checked = true;
   else if (order.includes('Call')) document.getElementById('call_num_order').checked = true;
   else if (order.includes('Active')) document.getElementById('active_order').checked = true;
   else if (order.includes('Lifetime')) document.getElementById('lifetime_circ_order').checked = true;
   else if (order.includes('YTD')) document.getElementById('ytd_circ_order').checked = true;

   if (layout.includes('Block'))
   {
      document.getElementById('block_layout').checked = true;
   }
   if (layout.includes('Inline'))
   {
      document.getElementById('inline_layout').checked = true;

   }
    if (layout.includes('Grid'))
   {
      document.getElementById('grid_layout').checked = true;

      //find the number and fill the box
      var pos = layout.indexOf("Grid");
      var val =layout.substring(pos+4);
      document.getElementById('grid_width').value = val.toString();
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


   if (options.includes('WordPress')) document.getElementById('word_press').checked = true;
   //if (options.includes('EmbeddableURL')) document.getElementById('save_html').checked = true;

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
   if (display.includes('ISBN')) document.getElementById('isbn').checked = true;
   if (display.includes('LastCheckin')) document.getElementById('last_checkin').checked = true;
   if (display.includes('LifetimeCirc')) document.getElementById('lifetime_circ').checked = true;
   if (display.includes('OCLCNumber')) document.getElementById('oclc_number').checked = true;
   if (display.includes('Part')) document.getElementById('part').checked = true;
   if (display.includes('PubDate')) document.getElementById('pub_date').checked = true;
   if (display.includes('PublicNote')) document.getElementById('public_note').checked = true;
   if (display.includes('Publisher')) document.getElementById('publisher').checked = true;
   if (display.includes('StaffNote')) document.getElementById('staff_note').checked = true;
   if (display.includes('StatCat')) document.getElementById('stat_cat').checked = true;
   if (display.includes('StatusChange')) document.getElementById('status_change').checked = true;
   if (display.includes('Summary')) document.getElementById('summary').checked = true;
   if (display.includes('YTDCirc')) document.getElementById('ytd_circ').checked = true;
}

function submitHTML()
{
   var order = "";
   var layout= "";
   var display ="";
   var options="";

   if (document.getElementById('title_order').checked) order = 'Title';
   else if (document.getElementById('author_order').checked) order = 'Author';
   else if (document.getElementById('call_num_order').checked) order = 'Call Number';
   else if (document.getElementById('active_order').checked) order = 'Active Date';
   else if (document.getElementById('lifetime_circ_order').checked) order = 'Lifetime Circs';
   else if (document.getElementById('ytd_circ_order').checked) order = 'YTD Circs';


   if (document.getElementById('block_layout').checked) layout += 'Block*';
   if (document.getElementById('inline_layout').checked) layout += 'Inline*';
   if (document.getElementById('grid_layout').checked)
   {
      layout += 'Grid '+document.getElementById('grid_width').value+'*';
   }

   if (layout.length < 4)
   {
      swal('Error', "HTML Layout MUST be selected ." , 'error');
      return false;
   }

   if (document.getElementById('group_copies').checked)
   {
      if (document.getElementById('first_copy').checked) options += "groupfirst*";
      else if (document.getElementById('all_copies').checked) options += "groupall*";
   }

   //don't display image size when inline since no images included
   if (layout != 'Inline' )
   {
      if (document.getElementById('small').checked) options += "imagesmall*";
      else if (document.getElementById('medium').checked) options += "imagemedium*";
      else if (document.getElementById('large').checked) options += "imagelarge*";
   }

   if (document.getElementById('word_press').checked) options += "wordpress*";
   //if (document.getElementById('save_html').checked) options += "savehtml*";

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
   if (document.getElementById('in_house').checked) display += "inhouse*";
   if (document.getElementById('isbn').checked) display += "isbn*";
   if (document.getElementById('last_checkin').checked) display += "lastcheckin*";
   if (document.getElementById('lifetime_circ').checked) display += "lifetimecirc*";
   if (document.getElementById('oclc_number').checked) display += "oclc*";
   if (document.getElementById('part').checked) display += "part*";
   if (document.getElementById('pub_date').checked) display += "pubdate*";
   if (document.getElementById('public_note').checked) display+="publicnote*";
   if (document.getElementById('publisher').checked) display += "publisher*";
   if (document.getElementById('staff_note').checked) display +="staffnote*";
   if (document.getElementById('stat_cat').checked) display += "statcat*";
   if (document.getElementById('status_change').checked) display += "statuschange*";
   if (document.getElementById('summary').checked) display += "summary*";
   if (document.getElementById('ytd_circ').checked) display += "ytdcirc";

   window.opener.HandleHTMLResult(order, display, layout, options);
   window.opener = self;
   window.close();
   return false;
}

function cancelHTML()
{
   window.opener.HandleHTMLResult();
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


<body onload="setPreviousHTML()">

<div id="content">

<h1 class="stat_cats">Configure HTML Output </h1>

<form id="stats" >
<div id="preview_form">

<div class="done">
	<input type="button" value="Cancel" class="stats" onClick="return cancelHTML()"/>
	<input type="button" value="Done" class="stats" onClick="return submitHTML()"/>
</div>

<h3 class="weeding"> Sort Order: </h3>
<p class="weeding">
      <input type="radio" name="order" value="title" id="title_order">Title <br/>
      <input type="radio" name="order" value="author" id="author_order">Author<br/>
      <input type="radio" name="order" value="call" id="call_num_order" onclick="SetCallNumDisplay()" checked>Call Number <br/>
      <span id="no-inline-sort">
      <input type="radio" name="order" value="added" id="active_order" onclick="SetActiveDate()"  disabled>Active Date<br/>
      <input type="radio" name="order" value="lifetime" id="lifetime_circ_order"  onclick="SetLifetimeCircs()">Lifetime Circulations<br/>
      <input type="radio" name="order" value="ytd" id="ytd_circ_order" onclick="SetYTDCircs()">YTD Circulations (Fiscal Year)
      </span>
</p>

<hr />

<h3 class="weeding"> Layout: </h3>
   <p class="weeding">
      <input type="checkbox" name="block_layout" value="block" id="block_layout"  class="layout">
         <label id="block_label">Block&nbsp;</label>
            <a href="JavaScript:newPopup('https://ocean.noblenet.org/tools/common/block_list.png');" class="example"><img src='https://ocean.noblenet.org/shared/images/question-mark-small.png' class="help" /></a><br />

     <input type="checkbox" name="inline_layout" value="inline" id="inline_layout" class="layout" >
     <label id="inline_label">Inline&nbsp;</label>
               <a href="JavaScript:newPopup('https://ocean.noblenet.org/tools/common/inline_list.png');" class="example"><img src='https://ocean.noblenet.org/shared/images/question-mark-small.png' class="help" /></a><br />

     <input type="checkbox" name="grid_layout" value="grid" id="grid_layout" class="layout" >
      <label id="cover_grid_label">Cover Grid</label>&nbsp;&nbsp;
           <span class="note">Grid Width </span>
           <input type="text" id="grid_width" size="2" value = "3">

           <a href="JavaScript:newPopup('https://ocean.noblenet.org/tools/common/cover_grid.png');" class="example"><img src='https://ocean.noblenet.org/shared/images/question-mark-small.png' class="help" /></a>
    </p>
<hr />


   <div id="display">

   <h3 class="weeding"> Block Display Options: </h3>
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
         <label id="call_number_label"> Call Number </label> <img src='https://ocean.noblenet.org/shared/images/question-mark-small.png' class="help" onclick="JavaScript:swal('Call Number','Call Number Prefix and Suffix will be included.', 'info');"/>
        </td>
      </tr>

      <tr id="no-inline-cover">
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
         <label id="amazon_direct_label"> Amazon Direct Link </label>  <img src='https://ocean.noblenet.org/shared/images/question-mark-small.png' class="help" onclick="JavaScript:swal('Amazon Direct Link','Link to an Amazon ISBN search.', 'info');"/>
       </td>
      </tr>

      <tr>
        <td>
         <input type="checkbox" id="amazon_search" name="options"/>
         <label id="amazon_search"> Amazon Search Link </label> <img src='https://ocean.noblenet.org/shared/images/question-mark-small.png' class="help" onclick="JavaScript:swal('Amazon Search Link','Link to an Amazon title search.', 'info');"/>
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
          <input type="checkbox" id="goodreads" name="options" />
          <label id="goodreads_label"> Goodreads Link </label><img src='https://ocean.noblenet.org/shared/images/question-mark-small.png' class="help" onclick="JavaScript:swal('Goodreads Link','Link to a Goodreads search for title.', 'info');" />
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
          <input type="checkbox" id="in_house" name="options" />
          <label id="in_house_label"> In House Usage </label>
        </td>
      </tr>

      <tr>
        <td>
          <input type="checkbox" id="isbn" name="options" />
          <label id="isbn_label"> ISBN </label>
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
          <input type="checkbox" id="last_checkin" name="options" />
          <label id="last_checkin_label"> Last Checkin </label>
        </td>
      </tr>

      <tr>
        <td>
          <input type="checkbox" id="lifetime_circ" name="options" />
          <label id="lifetime_label"> Lifetime Circs </label>
        </td>
      </tr>

      <tr>
        <td>
          <input type="checkbox" id="oclc_number" name="options" />
          <label id="oclc_label"> OCLC Number </label>
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
         <input type="checkbox" id="public_note" name="options" />
         <label id="public_note_label">Public Note</label>
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
           <input type="checkbox" id="copy_loc" name="options" />
           <label id="copy_loc_label"> Shelving Location</label>
        </td>
      </tr>

      <tr>
        <td>
          <input type="checkbox" id="staff_note" name="options" />
          <label id="staff_note_label">Staff Note </label>
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

       <tr>
        <td>
          <input type="checkbox" id="ytd_circ" name="options" />
          <label id="ytd_label"> YTD Circ </label>
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

      <span id="no-inline-image">
      <label for="image_size"> Image Size </label><img src='https://ocean.noblenet.org/shared/images/question-mark-small.png' class="help" onclick="JavaScript:swal('Image Size','Size of Cover Image to display. Based on image version in Evergreen.','info');"/><br/>
      <input type="radio" name="image_size" value="small" id="small" class="indent">Small <br/>
      <input type="radio" name="image_size" value="medium" id="medium" class="indent" checked>Medium<br/>
      <input type="radio" name="image_size" value="large" id="large" class="indent">Large<br/>
      </span>

      <input type="checkbox" id="word_press" name="word_press" />
      <label for="word_press"> Using WordPress </label><img src='https://ocean.noblenet.org/shared/images/question-mark-small.png' class="help" onclick="JavaScript:swal('WordPress','HTML generated will be in correct format to copy and paste directly into WordPress.','info');"/><br />

      <!--<input type="checkbox" id="save_html" name="save_html" />
      <label for="save_html"> Embeddable HTML  </label><img src='https://ocean.noblenet.org/shared/images/question-mark-small.png' class="help" onclick="JavaScript:swal('Embeddable HTML','Creates an HTML file to be used to embed and a Word Press IFrame.','info');" /><br />
      -->

      <input type="checkbox" id="group_copies" name="group_copies" />
      <label for="group_copies"> Group Items </label><img src='https://ocean.noblenet.org/shared/images/question-mark-small.png' class="help" onclick="JavaScript:swal('Group Items','Will only write one set of information for multiple copies of the same title.','info');" />

      <div id="group_copy">
      <input type="radio" name="copies" value="first" id="first_copy" class="indent" checked>Show only First Item <br/>
      <input type="radio" name="copies" value="all" id="all_copies" class="indent">Show All Items<br/>
      </div>



 </p>

    <div id="debug"></div>

<div class="done">
	<input type="button" value="Cancel" class="stats" onClick="return cancelHTML()"/>
	<input type="button" value="Done" class="stats" onClick="return submitHTML()"/>
</div>

</div> <!-- endstat form -->
</form>

</div><!--end content-->

</body>
</html>