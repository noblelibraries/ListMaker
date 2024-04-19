 <!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />

<title> Edit Scheduled Lists  - Version 1.0 </title>

<link rel="stylesheet" type="text/css" href="../css/noble.css" />
<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="https://code.jquery.com/jquery-1.9.1.js"></script>
<script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script type="text/javascript" src="../../shared/ajax/ajax.js"></script>

<script src="../../shared/sweetalert2/dist/sweetalert2.min.js"></script>
<script type="text/javascript" src="edit_scheduled.js"></script>

<link rel="stylesheet" type="text/css" href="../../shared/sweetalert2/dist/sweetalert2.css">

<link rel="icon"  type="image/png" href="../favicon.ico">

</head>

<body >
<div id="wrapper">

  <div id="header">

    <div id="top_nav">
       <ul>
          <li></li>
       </ul>
    </div><!-- end top nav -->
  
    <div id="header_image">
       <img src="../../shared/images/nblue.png" class="nat_sign" />
    </div> <!-- end header image -->
      
    <div id ="header_text">
       <h1> Edit Scheduled Lists  - Version 1.0 </h1>
    </div><!-- end header text-->
      
    <div id ="page_nav">
      <ul>
        <li><a href="list_form.php" target="_blank">List Maker</a></li>
      </ul>
    </div><!-- end page nav -->
    
  </div> <!-- end header -->

  <div id ="content">
<form id="stats" action="edit_scheduled_out.php" onsubmit="return CheckForm()" method="post">
    
   <h2> Find Scheduled Lists By Library or Email Address. </h2> 
    
   <table class="weeding" cellspacing="12">
    <tr>
       <td>
          Library: 
       </td>
       <td>
         <select name="library" id="library" class="stats" onchange="JavaScript:getBranches(this.value)">
         <option value="NONE">Select Library</option>
         <option value="BEVERLY">Beverly</option>
         <option value="BUNKERHILL">Bunker Hill</option>
         <option value="DANVERS">Danvers</option>
         <option value="ENDICOTT">Endicott</option>
         <option value="EVERETT">Everett</option>
         <option value="GLOUCESTER">Gloucester</option>
         <option value="GORDON">Gordon</option>
         <option value="LYNN">Lynn</option>
         <option value="LYNNFIELD">Lynnfield</option>
         <option value="MARBLEHEAD">Marblehead</option>
         <option value="BOARD">MBLC Library</option>
         <option value="MELROSE">Melrose</option>
         <option value="MERRIMACK">Merrimack</option>
         <option value="MONTSERRAT">Montserrat</option>  
         <option value="PEABODY">Peabody</option>
         <option value="PHILLIPS">Phillips</option>
         <option value="READING">Reading</option>
         <option value="REVERE">Revere</option>
         <option value="SALEM">Salem</option>
         <option value="SALEMSTATE">Salem State</option>
         <option value="SAUGUS">Saugus</option>
         <option value="STONEHAM">Stoneham</option>
         <option value="SWAMPSCOTT">Swampscott</option>
         <option value="WAKEFIELD">Wakefield</option>
        <option value="WINTHROP">Winthrop</option>
      </select>
    </td>
    </tr>
    
    <tr>
      <td> 
         Branch: 
      </td>
      <td>
       <select name="branch" id="branch" class="stats">
          <option value="-1"> NONE </option>
       </select>
      </td>
    </tr>
    
    
    <tr>
      <td> 
         Email : 
      </td>
      <td>
        <input type="text" name="email" id ="email" size=60 class="stats">
      </td>
    </tr>
    
    <tr> 
      <td>
          Include Inactive:
      </td>
      <td>
         <input type="checkbox" id="inactive" name="inactive" class="stats"/>
      </td>
    <tr>
    
    </table>
    
    	<p class="weeding">
   	<input type="submit" value="Find Reports" class="stats" id="find_reports" onclick="JavaScript:checkForm()" />
   	</p>
    
</form>

 <div id="results">
 </div>


  </div><!-- end contents -->
  
     <div id="footer">
   
      <div id="footer_links">
      <ul>
         <li><a href="https://evergreen.noblenet.org" target="blank"> Catalog </a></li>
      </ul>
      </div><!-- end links -->
      
   </div> <!-- end footer -->
   
      
</div><!-- end wrapper -->

</body>

</html>
