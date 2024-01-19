# ListMaker
 NOBLE ListMaker Tool
 
 The ListMaker code consists of a series of PHP scripts that provide both a front-end form 
 and back-end functions to collect and validate user criteria, query the Evergreen database, 
 and deliver the report in various formats to the user.  Javascript validates form entries and 
 dynamically changes the form as users make selections.  Crontab entries run reports that have been 
 designated to run periodically.
 
## What you will need

### db_info.php
The scripts will look for database connection information in a file called db_info.php which should be stored
outside the web accessible directories.  The file defines the Evergreen host, port, database name, username, and password:

```
$evergreen_host = "evergreen.yourdomain.org";
$evergreen_port = 5432;
$evergreen_database = "database_name";
$evergreen_user = "db_user_name";
$evergreen_password = "password";

$test_host = "test.yourdomain.org";
$test_port = 5432;
$test_database = "database_name";
$test_user = "db_user_name";
$test_password = "password";
```

### Outside Libraries/classes
PHPExcel - https://github.com/PHPOffice/PHPExcel- DEPRECATED 
PHPMailer - https://github.com/PHPMailer/PHPMailer 
Ajax sack library - no longer exists
Sweetalert - https://sweetalert.js.org/	

### Custom Database Tables
If you want users to schedule reports you need a table to store the information.  We created a schema and table (noble.scheduled_list)
for this purpose.

### Languages
php, jquery, javascript, html, css 

### PHP files

activateLists.php
  Purpose: Called from edit_scheduled.php to turn on or off a scheduled list. 
  NOBLE custom: updates custom noble.scheduled lists table

add_scheduled_report.php
  Purpose: Interpret all the data to create list via ajax params.  Create the structure to enter in the 
  database to be properly run. 
  NOBLE custom: 
    *Adds lists to custom DB tables
    *emails creation of scheduled list 
  Libraries Used:  PHPMailer

BibList.php
  Class: BibList - contains all the records and statistics  needed for output
  Has array of MutipleCopyBib objects - used in HTML and Bib sheet
  Has array of LibBopyList objects - used in spreadsheets
  Had array of BibRecs for online records
  Statistical data. 
  Sorting functions for different output sorts
  NOBLE Custom:
    *Hard coded “NOBLE” as constoria name

BibRec.php
  Classes: 
    BibRec -  all data associated with a bib record
    MutipleCopyBib  - extends BibRec - Used for HTML and Bib Sheet
      Bib with all copies for system attached
      Has array of CopyList - one list for each branch
      Keeps statistical totals by system
    OneCopyBib - extends BibRec - used for Spreadsheet and ungrouped HTML
      Bib with only one copy
  NOBLE Custom:
    *Hard coded link and cover image paths

configureHTML.php
  Purpose: Custom form to configure output written in HTML format
  Libraries Used: sweetalert

configurePreview.php
  Purpose: Custom form to configure output written for the Quick Preview (in HTML) 
  Libraries Used: sweetalert

configureRSS.php
  Purpose: Custom form to configure output written fin RSS (xml) 
  Libraries Used: NONE

configureSpreadsheet.php
  Purpose: Custom form to configure output for Spreadscheet/CSV file
  Libraries Used: sweetalert

CopyList.php
  Class: CopyList - Array of all copies associated with one bib for a branch
    contains array of Copy Recs
    member of MultipleCopyBib
    keeps track of circ info and copy counts for one branch
  Custom: NONE

CopyRec.php
  Class: CopyRec 
    contains all data associated with a copy
      asset.copy
      asset.call_number
      action.all_circulation
    Get and Set functions 
  NOBLE Custom: 
    Active/Create Dates 
    No stored data before 2000
    Data migration to evergreen 06-01-2012
    Age Protection id to name hard coded
    Call Number id to name hard coded 
    Loan duration id to name hard coded
    Fine Level id to name hard coded
    Uses migrated table data (extend_reporter.legacy.ill_data) for circ information when needed. 

create_list.php
  Purpose: Command line application triggered by run_list_report.php and run_scheduled_lists.php
  The main body of the program does the following:
    Opens DB
    Creates Filters from arguments 
    Created OutputOptions from arguments
    Creates Bib List
    Queries DB for query created by Filters
    For each copy found:
      Create and populate CopyRec
      Create and populate BIbRec
      Filter out any copies not able to be filtered by query
      Add item to BibList
    For each Online record found:
      Create and populate BIbRec
      Filter out any records not able to be filtered by query
      Add item to BibList for Online items
    Write out files
    Send user email with stats 
  Includes:
    CopyRec.php
    CopyList.php
    LibCopyList.php
    BibRec.php
    BibList.php
    Filters.php
    Output_Options.php
    list_functions.php
    Libraries Used: PHPMailer
    NOBLE Custom: Collection Reporting 

edit_scheduled_out.php
  Purpose: displays a list of scheduled lists and allows for turning lists on or off using activate_lists.php
  Includes:
    Filters.php
    Output_Options.php
    list_functions.php
  NOBLE Custom: Searches noble.scheduled_list table in database

edit_scheduled.js
  Purpose: Javascript used for form edit_scheduled.php
  NOBLE Custom: Hard coded branch names
  Libraries Used: sweetalert, ajax

edit_scheduled.php
  Purpose: Form to find and edit scheduled reports for a user or library
  Calls edit_scheduled_out.php on form submit
  NOBLE Custom: Hard coded system names, NOBLE page links

Excel_Output_Options.php
  Class: Excel_Output_Options - all data needed for writing out spreadsheet or csv 
  NOBLE Custom: Hard coded output file paths
  Libraries Used: s PHPExcel

Filters.php
  Class: Filters
    Reads all the input filters
    Creates a query for physical items based on the filterrs
    Has functions to exclude record based on data collected after the inital query.  
    Exclude functions are broken out due to how data is acquired and to quicken the speed of the inital query
    Creates online query when using input file as a parameter
  NOBLE Custom: Hard coded ouptut file paths, no circs before 2000, no create dates before 5/2012, 
    NOBLE consortia name, hard coded start of evergreen date in status changed and deleted
  Libraries Used: PHPExcel

form_functions.js
  Purpose: All Javascript functions associated with the dynamic list form, error checking
  NOBLE Custom: NOBLE as consortia name, hard coded branch names, updates to datepickers for libraries who 
    joined NOBLE at different dates , error checking of BISAC libraries 
  Libraries Used: 
    Ajax
    sweetalert

form_jquery.js
  Purpose: JQuery functions associated with dynamic list form 
  NOBLE Custom: Dates coded to when NOBLE started using evergreen, hard coded call number classes 

getCircModStatusAndPrefixSuffix.php
  Purpose: Called from Javascript using ajax to update form based on selections. 
  NOBLE Custom: Use of NOBLE as consortia name

getCollManTopics.php
  Purpose: Called from Javascript using ajax to update form based on selections. 
  NOBLE Custom: NOBLE specific collection topic defined in an external database 

getCopyLocations.php
  Purpose: Called from Javascript using ajax to update form based on selections. 
  NOBLE Custom: Use of NOBLE as consortia name

getStatCatEntryList.php
  Purpose: Called from Javascript using ajax to update stat cat form based on selections. 

getStatCats.php
  Purpose: Called from Javascript using ajax to update stat cat form based on selections. 
  NOBLE Custom: Use of NOBLE as consortia name

HTML_Output_Options.php
  Class: HTML_Output_Options - all data needed for writing out html file 
  NOBLE Custom: Hard coded output file paths 

LibCopyList.php
  Class: LibCopyList - 
  Contains all the records and statistics for a single system/branch
  Contains array of OneCopyBibRecs
  NOBLE Custom: Hard coded system names 

list_form.php
  Purpose: The dynamic form 
    Will read in and set any pre set fields set in the url 
    Form submit for preview calls preview_output.php. 
    For all other options form submit pops up sweetalert and calls run_list_report.php
  NOBLE Custom:  NOBLE specific collection topics, links to NOBLE pages, hard coded ids for libraries not 
    displayed, hard coded library name manipulation. - add spaces to shortnames, hard coded info on what 
	libraries have branches, hard coded call number class ids, hard coded library names for subdomain
  Includes:
    form_functions.js
    form_jquery.js
  Libraries Inlcuded:
    ajax
    sweetalert 

list_functions.php
  Purpose: Helper functions for List Maker
    Fiscal year calculations
    Domain and Scope 
    ISBN functions - used when inputting file of ISBNs
  NOBLE Custom: Hard coded shortames and subdomains, hard coded shortnames and scope ids, hard coded link to 
    link to update list

Output_Options.php
  Class: Output_Options
  Generic wrapper for all Output options
  Reads the selected output options
  Sends email 
  NOBLE Custom: Custom functions for writing NOBLE specific collection reports, file paths
  Includes:
    Excel_Output_Options.php
    HTML_Output_Options.php
    RSS_Output_Options.php
  Libraries Used: Phpmailer

preview_output.php
  Purpose: displays an HTML view of output 
  Reads the form and called Filters
  Uses HTML output 
  Similar to create_list. 
  NOBLE Custom: Lnks to NOBLE pages
  Includes:
    List_funcitons.php
    CopyRec.php
    CopyList.php
    BIbRec.php
    BibList.php
    Filters.php
    Output_Options.php

RSS_Output_Options.php
  Class: RSS_Output_Options - all data needed for writing out rss file in xml
  NOBLE Custom: Hard coded output file paths

run_list_report.php
  Purpose: Creates a command line of arguments to execute create_list.php via command line
  NOBLE Custom: Mails NOBLE when list created, hard coded paths for live/test/working
  Libraries Used: PHPMailer

run_scheduled_lists.php 
  Purpose: Checks database daily via cron job to see if any scheduled lists need to be run. 
  NOBLE Custom: Hard coded paths for live/test/working, hard coded paths for log files
  Includes:
    list_functions.php

setPrevStatCats.php 
  Purpose: Sets any previously set stat cats & entries on stat cat form 
  NOBLE Custom: Use of NOBLE as consortia name

stat_cat.php
  Purpose: Pop up for selecting what stat cats to filter on
  Libraries Used: ajax

upload_confirm.php 
  Purpose: Uploads and checks the files for the right format and headers
  NOBLE Custom: Hard coded paths for uploaded files

upload_file.php 
  Purpose: Pop up for uploading and checking a file for input

writeStatCats.php 
  Purpose: Write data from stat cat form onto the List Maker form. 

