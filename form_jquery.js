//Set up the report options
$(document).ready(function()
{

     $("#multiple_output").show();
     $("#preview_output").hide();
     $("#create_preview").hide();
     $("#weeding_only").hide();
	 $(".not_weeding").show();
	 $(".canned_hide").hide();
	 $(".canned_file").hide();
	 $(".canned_status").hide();
	 $(".canned_new").show();
	 $(".show_electronic").show();
	 $(".canned_acq").hide();
	 $(".course_section").show();
     $("#email_opt_out").hide();

    /*
    $(".stat_absolute").show();
	 $(".stat_relative").hide();
	 $(".added_absolute").show();
	 $(".added_relative").hide();
	 $(".checkin_absolute").show();
	 $(".checkin_relative").hide();
	 $(".circ_absolute").show();
	 $(".circ_relative").hide();
	 $("#circ_dates").show();
	 $(".added_between").show();
	 $(".status_between").hide();
	 $(".deleted_between").hide();*/


	 if ($("#use_filters").val() == "1")
	 {

		 //if editing a scheduled report make the right components visible
		 var frequency = $('input:radio[name=frequency]:checked').val();
		 var scheduled_report = true;
		 if (frequency =="once")
		 {
			 $(".no_schedule").show();
			 $(".schedule_only").hide();
			 $("#schedule").hide();
			 $("#monthly").hide();
			 $("#weekly").hide();
			 $("#configure").hide();
			 scheduled_report = false;
		 }
		 else
		 {
			 $(".no_schedule").hide();
			 $(".schedule_only").show();
			 $("#schedule").show;

			 //now check which filters to show
			 var sched_type = $("#how_often option:selected").val();
			 if (sched_type == "none") //select
			 {
				 $("#monthly").hide();
				 $("#weekly").hide();
				 $("#configure").hide();
			 }
			 else if (sched_type == "daily")
			 {
			     $("#monthly").hide();
				 $("#weekly").hide();
				 $("#configure").hide();

				//if json, bookbag, or copy bucket show email opt out
				if( $('#spreadsheet').prop('checked') == false && $('#html').prop('checked') == false && ( $('#bookbag').prop('checked') || $('#copy_bucket').prop('checked') || $('#json').prop('checked'))) $("#email_opt_out").show();
			 }
			 else if (sched_type == "monthly") //select
			 {
				 $("#monthly").show();
				 $("#weekly").hide();
				 $("#configure").hide();
			 }
			 else if (sched_type == "weekly")
			 {
				 $("#monthly").hide();
				 $("#weekly").show();
				 $("#configure").hide();
			 }
			 else if (sched_type == "configure")
			 {
				 $("#monthly").hide();
				 $("#weekly").hide();
				 $("#configure").show();
			 }
		 }

		  var report_type = $('input[name="report_type"]:checked').val();
		  $(".canned_hide").show();
		  $(".canned_file").show();
		  $(".canned_status").show();
		  $(".canned_new").show();
		  $(".show_electronic").show();
		  $(".canned_acq").show();
		  $(".course_section").show();

		  $("#create_preview").hide();
		  $("#create_report").show();

		   //show the filters hidden by preview
		  $(".no-preview").show();

		  $("#multiple_output").show();
		  $("#preview_output").hide();
		  $("#preview").prop('checked', false);


		  $( "#active_start").datepicker( "option", "minDate", new Date(2000, 1 - 1, 1) );
		  $( "#active_end").datepicker( "option", "minDate", new Date(2000, 1 - 1, 1) );
		  if (report_type == "weeding")
		  {
			  $("#weeding_only").show();
			  $(".not_weeding").hide();

			  var type = $("#checkin_date_type option:selected").val();

			  if (type == "absolute")
			  {
				  $(".checkin_absolute").show();
				  $(".checkin_relative").hide();
			  }
			  else if (type == "relative" || scheduled_report)
			  {
				  $(".checkin_absolute").hide();
				  $(".checkin_relative").show();
			  }
		  }
		  else
		  {
			  $("#weeding_only").hide();
			  $(".not_weeding").show();
		  }

		  var lib = $("#library option:selected").val();
		  if (lib == "NOBLE")
		  {
			  $(".no-noble").hide();
			  $("#copy_loc").hide();
			  $(".noble-only").show();
			  $(".call_num").show();
			  $("#collection").show();

			  var type =  $(".report_type").val();;
			  if (type == "weeding")
			  {
				  $(".weeding_report").prop("checked", false);
				  $(".inventory_report").prop("checked", true);
				  $("#weeding_only").hide();
				  $(".not_weeding").show();
			  }

			  $( "#active_start").datepicker( "option", "minDate", new Date(2012, 6 - 1, 1) );
			  $( "#active_end").datepicker( "option", "minDate", new Date(2012, 6 - 1, 1) );
		  }
		  else
		  {
			  $(".no-noble").show();
			  $("#copy_loc").show();
			  $(".noble-only").hide();

			  $( "#active_start").datepicker( "option", "minDate", new Date(2000, 1 - 1, 1) );
			  $( "#active_end").datepicker( "option", "minDate", new Date(2000, 1 - 1, 1) );
		  }

		  var pub_type = $("#pub_time_type option:selected").val();

		  if (pub_type == "before" )
		  {
		      $(".pub_between").hide();
		      $(".pub_start").show();
		      $("#null_pub_date").show();
			  $("#null_pub_date").prop('checked', false);
		  }
		  else if (pub_type == "after" )
		  {
		      $(".pub_start").show();
			  $(".pub_between").hide();
			  $("#null_pub_date").hide();
			  $("#null_pub_date").prop('checked', false);
		  }
		  else if (pub_type == "between" )
		  {
		      $(".pub_start").show();
			  $(".pub_between").show();
			  $("#null_pub_date").hide();
			  $("#null_pub_date").prop('checked', false);
		  }
		  else
		  {
		      $(".pub_start").hide();
			  $(".pub_between").hide();
			  $("#null_pub_date").hide();
			  $("#null_pub_date").prop('checked', false);
		  }

		  var del_type = $("#deleted option:selected").val();

		  if (del_type == "deleted_only")
		  {
			  $("#deleted_date_div").show();
			  var del_date_type = $("#deleted_date_type option:selected").val();

			  if (del_date_type == "absolute" )
			  {
				  $(".deleted_absolute").show();
				  $(".deleted_relative").hide();
			  }
			  else if (del_date_type == "relative" || scheduled_report)
			  {
				  $(".deleted_absolute").hide();
				  $(".deleted_relative").show();
			  }

			  var del_time_type = $("#deleted_time_type option:selected").val();

			  if (del_time_type == "before" || del_time_type == "after" )
			  {
				  $(".deleted_between").hide();
			  }
			  else
			  {
				  $(".deleted_between").show();
			  }
		  }
		  else
		  {
			  $("#deleted_date_div").hide();
			  //clear the dates and checkbox
			  $("#use_deleted_date").prop('checked', false);


		  }

		  var stat_date_type = $("#status_date_type option:selected").val();

		  if (stat_date_type == "absolute")
		  {
			  $(".stat_absolute").show();
			  $(".stat_relative").hide();
		  }
		  else if (stat_date_type == "relative")
		  {
			  $(".stat_absolute").hide();
			  $(".stat_relative").show();
		  }
		  var stat_time_type = $("#stat_time_type option:selected").val();

		  if (stat_time_type == "before" || stat_time_type == "after" )
		  {
			  $(".status_between").hide();
		  }
		  else
		  {
			  $(".status_between").show();
		  }

		  var add_date_type = $("#added_date_type option:selected").val();

		  if (add_date_type == "absolute")
		  {
			 $(".added_absolute").show();
			 $(".added_relative").hide();
		  }
		  else if (add_date_type == "relative")
		  {
			  $(".added_absolute").hide();
			  $(".added_relative").show();
		  }

		  var add_time_type = $("#added_time_type option:selected").val();

		  if (add_time_type == "before" || add_time_type == "after" )
		  {
			  $(".added_between").hide();
		  }
		  else
		  {
			  $(".added_between").show();
		  }

		  var circ_date_type = $("#circ_date_type option:selected").val();

		  if (circ_date_type == "absolute")
		  {
			 $(".circ_absolute").show();
			 $(".circ_relative").hide();
		  }
		  else if (circ_date_type == "relative")
		  {
			  $(".circ_absolute").hide();
			  $(".circ_relative").show();
		  }

		  var circ_time_type = $("#circ_time_type option:selected").val();

		  if (circ_time_type == "before" || circ_time_type == "after" )
		  {
			  $(".circ_between").hide();
		  }
		  else
		  {
			  $(".circ_between").show();
		  }

		  var due_date_type = $("#due_date_type option:selected").val();

		  if (due_date_type == "absolute")
		  {
			 $(".due_absolute").show();
			 $(".due_relative").hide();
		  }
		  else if (due_date_type == "relative")
		  {
			  $(".due_absolute").hide();
			  $(".due_relative").show();
		  }

		  var due_time_type = $("#due_time_type option:selected").val();

		  if (due_time_type == "before" || due_time_type == "after" )
		  {
			  $(".due_between").hide();
		  }
		  else
		  {
			  $(".due_between").show();
		  }

		  var inventory_date_type = $("#inventory_date_type option:selected").val();

		  if (inventory_date_type == "absolute")
		  {
			 $(".inventory_absolute").show();
			 $(".inventory_relative").hide();
		  }
		  else if (inventory_date_type == "relative")
		  {
			  $(".inventory_absolute").hide();
			  $(".inventory_relative").show();
		  }

		  var inventory_time_type = $("#inventory_time_type option:selected").val();

		  if (inventory_time_type == "before"  )
		  {
			  $(".inventory_between").hide();
			  $(".inventory_start").show();
			  $("#null_inventory").show();
			  $("#null_inventory").prop('checked', false);
		  }
		  else if (inventory_time_type == "after" )
		  {
		      $(".inventory_between").hide();
		      $(".inventory_start").show();
		      $("#null_inventory").hide();
		      $("#null_inventory").prop('checked', false);
		  }
		  else if (inventory_time_type == "between" )
		  {
			  $(".inventory_between").show();
			  $(".inventory_start").show();
			  $("#null_inventory").hide();
			  $("#null_inventory").prop('checked', false);
		  }
		  else
		  {
		      $(".inventory_between").hide();
		      $(".inventory_start").hide();
			  $("#null_inventory").hide();
			  $("#null_inventory").prop('checked', false);
		  }

		  var invoice_date_type = $("#invoice_date_type option:selected").val();

		  if (invoice_date_type == "absolute")
		  {
			 $(".invoice_absolute").show();
			 $(".invoice_relative").hide();
		  }
		  else if (invoice_date_type == "relative")
		  {
			  $(".invoice_absolute").hide();
			  $(".invoice_relative").show();
		  }

		  var invoice_time_type = $("#invoice_time_type option:selected").val();

		  if (invoice_time_type == "before" || invoice_time_type == "after" )
		  {
			  $(".invoice_between").hide();
		  }
		  else
		  {
			  $(".invoice_between").show();
		  }

		  var invoice_closed_date_type = $("#invoice_closed_date_type option:selected").val();

		  if (invoice_closed_date_type == "absolute")
		  {
			 $(".invoice_closed_absolute").show();
			 $(".invoice_closed_relative").hide();
		  }
		  else if (invoice_closed_date_type == "relative")
		  {
			  $(".invoice_closed_absolute").hide();
			  $(".invoice_closed_relative").show();
		  }

		  var invoice_closed_time_type = $("#invoice_closed_time_type option:selected").val();

		  if (invoice_closed_time_type == "before" )
		  {
		      $(".invoice_closed_start").show();
		      $(".invoice_closed_between").hide();
              $("#null_invoice_closed").show();
		      $("#null_invoice_closed").prop('checked', false);
		  }
		  else if( invoice_closed_time_type == "after" )
		  {
		      $(".invoice_closed_start").show();
			  $(".invoice_closed_between").hide();
              $("#null_invoice_closed").hide();
		      $("#null_invoice_closed").prop('checked', false);
		  }
		  else if( invoice_closed_time_type == "between" )
		  {
		      $(".invoice_closed_start").show();
			  $(".invoice_closed_between").show();
			  $("#null_invoice_closed").hide();
		      $("#null_invoice_closed").prop('checked', false);
		  }
		  else
		  {
		      $(".invoice_closed_start").hide();
			  $(".invoice_closed_between").hide();
			  $("#null_invoice_closed").hide();
		      $("#null_invoice_closed").prop('checked', false);
		  }

		  var order_date_type = $("#order_date_type option:selected").val();

		  if (order_date_type == "absolute")
		  {
			 $(".order_absolute").show();
			 $(".order_relative").hide();
		  }
		  else if (order_date_type == "relative")
		  {
			  $(".order_absolute").hide();
			  $(".order_relative").show();
		  }

		  var order_time_type = $("#order_time_type option:selected").val();

		  if (order_time_type == "before" || order_time_type == "after" )
		  {
			  $(".order_between").hide();
			  $(".order_start").show();
		  }
		  else if (order_time_type == "between" )
		  {
			  $(".order_between").show();
			  $(".order_start").show();
		  }
		  else
		  {
		     $(".order_between").hide();
		     $(".order_start").hide();
		  }

		  var file_name = $("#input_file_name").val();

		  if (file_name !== '-1')
		  {
			  //hide upload button
			  //show clear_file_button
			  $("#upload_button").hide();
			  $("#clear_file_button").show();

			  //enable electronic select
			  $("#electronic").prop("disabled",false);
			  // set enable select = physical_electronic
			  $("#electronic").val('physical_electronic');
		  }

		  var call_type = $("#call_class option:selected").val();

		  if (call_type == "0") //none
		  {
			  $("#call_range").hide();
			  $("#call_contains").hide();
			  $("#collection").hide();
			  $("#bisac").hide();
			  $(".call_num").hide();
		  }
		  else if (call_type == "1") //generic
		  {
			  $("#call_range").show();
			  $("#call_contains").show();
			  $("#collection").hide();
			  $("#bisac").hide();
		  }
		  else if (call_type == "2") //dewey
		  {
			  $("#call_range").show();
			  $("#call_contains").hide();
			  $("#collection").show();
			  $("#bisac").hide();
		  }
		  else if (call_type == "3") //lc
		  {
			  $("#call_range").show();
			  $("#call_contains").hide();
			  $("#collection").show();
			  $("#bisac").hide();
		  }
		  else if (call_type == "4")//bisac
		  {
			  $("#call_range").hide();
		  	  $("#call_contains").show();
			  $("#collection").hide();
			  $("#bisac").show();
		  }

   }
    else
    {
		 $(".no_schedule").show();
		 $(".schedule_only").hide();
		 $("#schedule").hide();
         $("#monthly").hide();
         $("#weekly").hide();
         $("#configure").hide();

         $(".not_weeding").show();
		 $("#weeding_only").hide();
		 $("#multiple_output").show();
		 $("#preview_output").hide();
		 $("#call_range").hide();
		 $("#call_contains").hide();
		 $(".call_num").hide();
		 $("#collection").hide();
		 $("#bisac").hide();
		 $("#create_preview").hide();
		 $(".stat_absolute").show();
		 $(".stat_relative").hide();
		 $(".added_absolute").show();
		 $(".added_relative").hide();
		 $(".checkin_absolute").show();
		 $(".checkin_relative").hide();
		 $(".deleted_absolute").show();
		 $(".deleted_relative").hide();
		 $("#deleted_date_div").hide();
		 $(".circ_absolute").show();
		 $(".circ_relative").hide();
		 $("#circ_dates").show();
	     $(".due_absolute").show();
		 $(".due_relative").hide();
		 $("#due_dates").show();
		 $(".inventory_absolute").show();
		 $(".inventory_relative").hide();
		 $("#null_inventory").hide();
		 $("#inventory_dates").show();
		 $(".invoice_absolute").show();
		 $(".invoice_relative").hide();
		 $("#invoice_dates").show();
		 $(".invoice_closed_absolute").show();
		 $(".invoice_closed_relative").hide();
		 $("#invoice_closed_dates").show();
		 $("#null_invoice_closed").hide();
		 $(".order_absolute").show();
		 $(".order_relative").hide();
		 $("#order_dates").show();

		 $(".pub_between").hide();
		 $("#null_pub_date").show();
		 $(".added_between").show();
		 $(".status_between").hide();
		 $(".deleted_between").hide();
		 $(".noble-only").hide();
    }


});

//change the report options based on the report type selected
$(document).ready(function()
{

    $(".report_type").change(function()
    {
        $(".no-preview").show();
		  var type = $(this).val();
		  if (type == "new_items")
		  {
		     $("#weeding_only").hide();
		     $(".not_weeding").show();
		     $(".canned_hide").hide();
		     $(".canned_file").hide();
		     $(".canned_status").hide();
		     $(".canned_new").show();
		     $(".canned_acq").hide();
		     $(".show_electronic").show();
		     $(".course_section").show();
		  }
		  else if (type == "status_change")
		  {
		     //set inventory
		     $("#weeding_only").hide();
			 $(".not_weeding").show();
		     $(".canned_hide").hide();
		     $(".canned_file").hide();
		     $(".canned_status").show();
		     $(".canned_new").hide();
		     $(".canned_acq").hide();
		     $(".show_electronic").hide();
		     $(".course_section").hide();
	     }
	     else if (type == "file_upload")
		  {
		     $("#weeding_only").hide();
		     $(".not_weeding").show();
		     $(".canned_hide").hide();
		     $(".canned_file").show();
		     $(".canned_status").hide();
		     $(".canned_new").hide();
		     $(".canned_acq").hide();
		     $(".show_electronic").show();
		     $(".course_section").hide();

		  }
	     else if (type == "shelf_sitter")
		  {
		     //set shelf_sitter
		     $("#weeding_only").show();
		     $(".canned_hide").hide();
		     $(".canned_file").hide();
		     $(".canned_status").hide();
		     $(".canned_new").hide();
		     $(".canned_acq").hide();
		     $(".show_electronic").hide();
		     $(".canned_shelf").show();
		     $(".course_section").show();
	     }
	     else if (type == "acq_report")
		  {
		     //set shelf_sitter
		     $(".canned_acq").show();
		     $("#weeding_only").hide();
		     $(".canned_hide").hide();
		     $(".canned_file").hide();
		     $(".canned_status").hide();
		     $(".canned_new").hide();
		     $(".show_electronic").hide();
		     $(".course_section").hide();
	     }
	     else if (type == "preview")
		  {
			  $("#multiple_output").hide();
			  $("#preview_output").show();
			  $("#preview").prop('checked', true);

			  $("#weeding_only").hide();
			  $(".not_weeding").show();
		     $(".canned_hide").show();
		     $(".canned_file").show();
		     $(".canned_status").show();
		     $(".canned_new").show();
		     $(".canned_acq").hide();
		     $(".show_electronic").show();
		     $(".course_section").hide();

			  //hide the filters not able to use
			  $(".no-preview").hide();

			  $("#create_preview").show();
			  $("#create_report").hide();

			  $( "#active_start").datepicker( "option", "minDate", new Date(2012, 6 - 1, 1) );
			  $( "#active_end").datepicker( "option", "minDate", new Date(2012, 6 - 1, 1) );
		  }
		  else
		  {
		     $(".canned_hide").show();
		     $(".canned_file").show();
		     $(".canned_status").show();
		     $(".canned_new").show();
		     $(".canned_acq").show();
		     $(".course_section").show();
		     $(".show_electronic").show();

			  $("#create_preview").hide();
			  $("#create_report").show();

			  //show the filters hidden by preview
				$(".no-preview").show();

			  $("#multiple_output").show();
			  $("#preview_output").hide();
			  $("#preview").prop('checked', false);

			  if (type == "weeding")
			  {
				  $("#weeding_only").show();
				  $(".not_weeding").hide();
			  }
			  else
			  {
				  $("#weeding_only").hide();
				  $(".not_weeding").show();
			  }

			  $( "#active_start").datepicker( "option", "minDate", new Date(2000, 1 - 1, 1) );
			  $( "#active_end").datepicker( "option", "minDate", new Date(2000, 1 - 1, 1) );

			}
    });


    $("#library").change(function()
    {
        var lib = $("#library option:selected").val();

        if (lib == "NOBLE")
        {
           $(".no-noble").hide();
           $("#copy_loc").hide();
           $(".noble-only").show();
           $(".call_num").show();
           $("#collection").show();
           $(".canned_acq").hide();

           var type =  $(".report_type").val();;
           if (type == "weeding")
           {
              $(".weeding_report").prop("checked", false);
              $(".inventory_report").prop("checked", true);
              $("#weeding_only").hide();
				  $(".not_weeding").show();
           }

           $( "#active_start").datepicker( "option", "minDate", new Date(2012, 6 - 1, 1) );
			  $( "#active_end").datepicker( "option", "minDate", new Date(2012, 6 - 1, 1) );
        }
        else
        {
           $(".no-noble").show();
           $("#copy_loc").show();
           $(".noble-only").hide();

           $("#call_class option[value='0']").attr("selected", true);

           $("#start_call").val('');
		     $("#end_call").val('');
			  $("#call_range").hide();

			  $("#contains_call").val('');
			  $("#call_contains").hide();

			  $("#collection").find('option').removeAttr("selected");
			  $("#collection").hide();

			  $('#bisac').prop('selectedIndex',0);
			  $("#bisac").hide();

			  $( "#active_start").datepicker( "option", "minDate", new Date(2000, 1 - 1, 1) );
			  $( "#active_end").datepicker( "option", "minDate", new Date(2000, 1 - 1, 1) );
        }

    });

    $(".frequency").change(function()
    {
		  var type = $(this).val();
		  if (type == "once")
		  {
		     $(".no_schedule").show();
		     $(".schedule_only").hide();
		     $("#create_report").val("Generate Report");
		     $("#update_sched").hide();

			  //hide the filters not able to use
			  $("#schedule").hide();
			  /*$("#status_date_type option[value='absolute']").prop("disabled",false);
		     $("#added_date_type option[value='absolute']").prop("disabled",false);
		     $("#checkin_date_type option[value='absolute']").prop("disabled",false);
		     $("#deleted_date_type option[value='absolute']").prop("disabled",false);*/

		  }
		  else
		  {
		     $(".no_schedule").hide();
		     $(".schedule_only").show();
		     $("#create_report").val("Schedule Report");

			  $("#schedule").show();
			  //$("#status_date_type option[value='absolute']").prop("disabled",true);
			  $("#status_date_type").val('relative');
			  $(".stat_absolute").hide();
		     $(".stat_relative").show();

		     //$("#added_date_type option[value='absolute']").prop("disabled",true);
			  $("#added_date_type").val('relative');
			  $(".added_absolute").hide();
		     $(".added_relative").show();

		     //$("#checkin_date_type option[value='absolute']").prop("disabled",true);
			  $("#checkin_date_type").val('relative');
			  $(".checkin_absolute").hide();
		     $(".checkin_relative").show();

		     //$("#deleted_date_type option[value='absolute']").prop("disabled",true);
			  $("#deleted_date_type").val('relative');
			  $(".deleted_absolute").hide();
		     $(".deleted_relative").show();

		     $("#circ_date_type").val('relative');
			  $(".circ_absolute").hide();
		     $(".circ_relative").show();

  		     $("#due_date_type").val('relative');
			  $(".due_absolute").hide();
		     $(".due_relative").show();

		     $("#inventory_date_type").val('relative');
			  $(".inventory_absolute").hide();
		     $(".inventory_relative").show();

		     $("#invoice_date_type").val('relative');
			  $(".invoice_absolute").hide();
		     $(".invoice_relative").show();

		     $("#invoice_closed_date_type").val('relative');
			  $(".invoice_closed_absolute").hide();
		     $(".invoice_closed_relative").show();

		     $("#order_date_type").val('relative');
			  $(".order_absolute").hide();
		     $(".order_relative").show();
		  }
    });

    $('#how_often').change(function()
    {
		  var type = $("#how_often option:selected").val();

		  if (type == "none") //select
		  {
           $("#monthly").hide();
           $("#weekly").hide();
           $("#configure").hide();
		  }
		  else if (type == "monthly") //select
		  {
           $("#monthly").show();
           $("#weekly").hide();
           $("#configure").hide();
		  }
		  else if (type == "weekly")
		  {
		     $("#monthly").hide();
             $("#weekly").show();
             $("#configure").hide();
		  }
		  else if (type == "daily")
		  {
		     $("#monthly").hide();
             $("#weekly").hide();
             $("#configure").hide();
		  }
		  else if (type == "yearly")
		  {
		     $("#monthly").hide();
             $("#weekly").hide();
             $("#configure").hide();
		  }
		  else if (type == "configure")
		  {
		     $("#monthly").hide();
             $("#weekly").hide();
             $("#configure").show();
		  }
	  });


    $('#added_date_type').change(function()
    {
		  var type = $("#added_date_type option:selected").val();

		  if (type == "absolute")
		  {
		     $(".added_absolute").show();
		     $(".added_relative").hide();
		  }
		  else if (type == "relative")
		  {
		     $(".added_absolute").hide();
		     $(".added_relative").show();
		  }
	 });

	$('#added_time_type').change(function()
    {
		  var type = $("#added_time_type option:selected").val();

		  if (type == "before" || type == "after" )
		  {
		     $(".added_between").hide();
		  }
		  else
		  {
		     $(".added_between").show();
		  }
	 });


	 $('#circ_date_type').change(function()
    {
		  var type = $("#circ_date_type option:selected").val();

		  if (type == "absolute")
		  {
		     $(".circ_absolute").show();
		     $(".circ_relative").hide();
		  }
		  else if (type == "relative")
		  {
		     $(".circ_absolute").hide();
		     $(".circ_relative").show();
		  }
	 });

	 $('#circ_time_type').change(function()
    {
		  var type = $("#circ_time_type option:selected").val();

		  if (type == "before" || type == "after" )
		  {
		     $(".circ_between").hide();
		  }
		  else
		  {
		     $(".circ_between").show();
		  }
	 });


	 $('#compare_date').change(function()
    {
        var type = $("#compare_date option:selected").val();

		  if (type == "lifetime" )
		  {
		     //disable circ dates
		     $("#use_circ_dates").prop('checked' , false);
		     $("#use_circ_dates").prop( "disabled", true );
		     $("#circ_date_type").prop( "disabled", true );
		     $("#circ_time_type").prop( "disabled", true );
		     $("#circ_start").prop( "disabled", true );
		     $("#circ_start_relative").prop( "disabled", true );
		     $("#circ_start_time").prop( "disabled", true );
		     $("#circ_end").prop( "disabled", true );
		     $("#circ_end_relative").prop( "disabled", true );
		     $("#circ_end_time").prop( "disabled", true );
		  }
		  else
		  {
		     $("#use_circ_dates").prop( "disabled", false );
		     $("#circ_date_type").prop( "disabled", false );
		     $("#circ_time_type").prop( "disabled", false );
		     $("#circ_start").prop( "disabled", false );
		     $("#circ_start_relative").prop( "disabled", false );
		     $("#circ_start_time").prop( "disabled", false );
		     $("#circ_end").prop( "disabled", false );
		     $("#circ_end_relative").prop( "disabled", false );
		     $("#circ_end_time").prop( "disabled", false );
		  }
	 });

	 $('#status_date_type').change(function()
    {
		  var type = $("#status_date_type option:selected").val();

		  if (type == "absolute")
		  {
		     $(".stat_absolute").show();
		     $(".stat_relative").hide();
		  }
		  else if (type == "relative")
		  {
		     $(".stat_absolute").hide();
		     $(".stat_relative").show();
		  }
	 });

	 $('#stat_time_type').change(function()
    {
		  var type = $("#stat_time_type option:selected").val();

		  if (type == "before" || type == "after" )
		  {
		     $(".status_between").hide();
		  }
		  else
		  {
		     $(".status_between").show();
		  }
	 });

	 $('#deleted_time_type').change(function()
    {
		  var type = $("#deleted_time_type option:selected").val();

		  if (type == "before" || type == "after" )
		  {
		     $(".deleted_between").hide();
		  }
		  else
		  {
		     $(".deleted_between").show();
		  }
	 });


    $('#checkin_date_type').change(function()
    {
		  var type = $("#checkin_date_type option:selected").val();

		  if (type == "absolute")
		  {
		     $(".checkin_absolute").show();
		     $(".checkin_relative").hide();
		  }
		  else if (type == "relative")
		  {
		     $(".checkin_absolute").hide();
		     $(".checkin_relative").show();
		  }
	 });

      $('#due_date_type').change(function()
    {
		  var type = $("#due_date_type option:selected").val();

		  if (type == "absolute")
		  {
		     $(".due_absolute").show();
		     $(".due_relative").hide();
		  }
		  else if (type == "relative")
		  {
		     $(".due_absolute").hide();
		     $(".due_relative").show();
		  }
	 });

	 $('#due_time_type').change(function()
    {
		  var type = $("#due_time_type option:selected").val();

		  if (type == "before" || type == "after" )
		  {
		     $(".due_between").hide();
		  }
		  else
		  {
		     $(".due_between").show();
		  }
	 });

	 $('#inventory_date_type').change(function()
    {
		  var type = $("#inventory_date_type option:selected").val();

		  if (type == "absolute")
		  {
		     $(".inventory_absolute").show();
		     $(".inventory_relative").hide();
		  }
		  else if (type == "relative")
		  {
		     $(".inventory_absolute").hide();
		     $(".inventory_relative").show();
		  }
	 });

	 $('#inventory_time_type').change(function()
    {
		  var type = $("#inventory_time_type option:selected").val();

		  if (type == "before")
		  {
		     $(".inventory_start").show();
		     $(".inventory_between").hide();
		     $("#null_inventory").show();
		     $("#null_inventory").prop('checked', false);
		  }
		  else if (type == "after" )
		  {
		     $(".inventory_start").show();
		     $(".inventory_between").hide();
		     $("#null_inventory").hide();
		     $("#null_inventory").prop('checked', false);
		  }
		  else if (type == "between" )
		  {
		     $(".inventory_start").show();
		     $(".inventory_between").show();
		     $("#null_inventory").hide();
		     $("#null_inventory").prop('checked', false);
		  }
		  else
		  {
		     $(".inventory_start").hide();
		     $(".inventory_between").hide();
		     $("#null_inventory").hide();
		     $("#null_inventory").prop('checked', false);
		  }
	 });

	 $('#invoice_date_type').change(function()
    {
		  var type = $("#invoice_date_type option:selected").val();

		  if (type == "absolute")
		  {
		     $(".invoice_absolute").show();
		     $(".invoice_relative").hide();
		  }
		  else if (type == "relative")
		  {
		     $(".invoice_absolute").hide();
		     $(".invoice_relative").show();
		  }
	 });

	 $('#invoice_time_type').change(function()
    {
		  var type = $("#invoice_time_type option:selected").val();

		  if (type == "before" || type == "after" )
		  {
		     $(".invoice_between").hide();
		  }
		  else
		  {
		     $(".invoice_between").show();
		  }
	 });

	 $('#invoice_closed_date_type').change(function()
    {
		  var type = $("#invoice_closed_date_type option:selected").val();

		  if (type == "absolute")
		  {
		     $(".invoice_closed_absolute").show();
		     $(".invoice_closed_relative").hide();
		  }
		  else if (type == "relative")
		  {
		     $(".invoice_closed_absolute").hide();
		     $(".invoice_closed_relative").show();
		  }
	 });

	 $('#invoice_closed_time_type').change(function()
    {
		  var type = $("#invoice_closed_time_type option:selected").val();

		  if (type == "before" )
		  {
		      $(".invoice_closed_between").hide();
		      $(".invoice_closed_start").show();
		      $("#null_invoice_closed").show();
		      $("#null_invoice_closed").prop('checked', false);
		  }
		  else if( type == "after" )
		  {
		     $(".invoice_closed_between").hide();
		     $(".invoice_closed_start").show();
		     $("#null_invoice_closed").hide();
		     $("#null_invoice_closed").prop('checked', false);
		  }
		  else if( type == "between" )
		  {
		     $(".invoice_closed_between").show();
		     $(".invoice_closed_start").show();
		     $("#null_invoice_closed").hide();
		     $("#null_invoice_closed").prop('checked', false);
		  }
		  else
		  {
		     $(".invoice_closed_start").hide();
		     $(".invoice_closed_between").hide();
		     $("#null_invoice_closed").hide();
		     $("#null_invoice_closed").prop('checked', false);
		  }
	 });

	 $('#order_date_type').change(function()
    {
		  var type = $("#order_date_type option:selected").val();

		  if (type == "absolute")
		  {
		     $(".order_absolute").show();
		     $(".order_relative").hide();
		  }
		  else if (type == "relative")
		  {
		     $(".order_absolute").hide();
		     $(".order_relative").show();
		  }
	 });

	 $('#order_time_type').change(function()
    {
		  var type = $("#order_time_type option:selected").val();

		  if (type == "before" || type == "after" )
		  {
		     $(".order_between").hide();
		     $(".order_start").show();
		  }
		  else if (type == "between")
		  {
		     $(".order_between").show();
		     $(".order_start").show();
		  }
		  else
		  {
		      $(".order_between").hide();
		      $(".order_start").hide();
		  }
	 });


	 $('#deleted').change(function()
    {
		  var type = $("#deleted option:selected").val();

		  if (type == "deleted_only")
		  {
		     $("#deleted_date_div").show();
		  }
		  else
		  {
		     $("#deleted_date_div").hide();
		     //clear the dates and checkbox
		     $("#use_deleted_date").prop('checked', false);
		     $("#deleted_date").val('');
		     $("#deleted_date_relative").val('');
		  }
	 });

	 $('#deleted_date_type').change(function()
    {
		  var type = $("#deleted_date_type option:selected").val();

		  if (type == "absolute")
		  {
		     $(".deleted_absolute").show();
		     $(".deleted_relative").hide();
		  }
		  else if (type == "relative")
		  {
		     $(".deleted_absolute").hide();
		     $(".deleted_relative").show();
		  }
	 });

	 $('#pub_time_type').change(function()
    {
		  var type = $("#pub_time_type option:selected").val();

		  if (type == "before" )
		  {
		     $(".pub_start").show();
		     $(".pub_between").hide();
		     $("#null_pub_date").show();
		  }
		  else if ( type == "after" )
		  {
		     $(".pub_start").show();
		     $(".pub_between").hide();
		     $("#null_pub_date").hide();
		  }
		  else if ( type == "between")
		  {
		     $(".pub_start").show();
		     $(".pub_between").show();
		     $("#null_pub_date").hide();
		  }
		  else
		  {
		     $(".pub_start").hide();
		     $(".pub_between").hide();
		     $("#null_pub_date").hide();
		  }
	 });

    $('#call_class').change(function()
    {
		  var type = $("#call_class option:selected").val();

		  if (type == "0") //select
		  {
		     $("#start_call").val('');
		     $("#end_call").val('');
			  $("#call_range").hide();
			  $(".call_num").hide();

			  $("#contains_call").val('');
			  $("#call_contains").hide();

			  $("#collection").find('option').removeAttr("selected");
			  $("#collection").hide();

			  $('#bisac').prop('selectedIndex',0);
			  $("#bisac").hide();
		  }
		  else if (type == "1") //generic
		  {
			  $("#call_range").show();
			  $("#call_contains").show();
			  $(".call_num").show();

			  $("#collection").find('option').removeAttr("selected");
			  $("#collection").hide();

			  $('#bisac').prop('selectedIndex',0);
			  $("#bisac").hide();
		  }
		  else if (type == "2") //dewey
		  {
			  $("#call_range").show();
			  $("#call_contains").hide();
			  $("#collection").show();
			  $(".call_num").show();

			  $('#bisac').prop('selectedIndex',0);
			  $("#bisac").hide();
		  }
		  else if (type == "3") //lc
		  {
			  $("#call_range").show();
			  $("#call_contains").hide();
			  $("#collection").show();
			  $(".call_num").show();

			  $('#bisac').prop('selectedIndex',0);
			  $("#bisac").hide();
		  }
		  else if (type == "4")//bisac
		  {
		      $("#start_call").val('');
		      $("#end_call").val('');
			  $("#call_range").hide();
			  $(".call_num").show();

			  $("#call_contains").show();

			  $("#collection").find('option').removeAttr("selected");
			  $("#collection").hide();

			  $("#bisac").show();
		  }
    });

});


//Set up the date pickers on the page
$(function()
{
    $( "#last_checkin_date" ).datepicker(
    {
      changeMonth: true,
      changeYear: true,
      yearRange: "2000:"
    });

    $( "#active_start" ).datepicker(
    {
      changeMonth: true,
      changeYear: true,
      yearRange: "2000:"
    });

    $( "#active_end" ).datepicker(
    {
      changeMonth: true,
      changeYear: true,
      yearRange: "2000:"
    });

    $( "#circ_start" ).datepicker(
    {
      changeMonth: true,
      changeYear: true,
      yearRange: "2012:",
       minDate: new Date(2012, 5, 1)
    });

    $( "#circ_end" ).datepicker(
    {
      changeMonth: true,
      changeYear: true,
      yearRange: "2012:",
      minDate: new Date(2012, 5, 1)
    });

    $( "#due_start" ).datepicker(
    {
       changeMonth: true,
       changeYear: true,
       yearRange: "2012:",
       minDate: new Date(2012, 5, 1)
    });

    $( "#due_end" ).datepicker(
    {
      changeMonth: true,
      changeYear: true,
      yearRange: "2012:",
      minDate: new Date(2012, 5, 1)
    });

    $( "#inventory_start" ).datepicker(
    {
       changeMonth: true,
       changeYear: true,
       yearRange: "2019:",
       minDate: new Date(2019, 5, 10)
    });

    $( "#inventory_end" ).datepicker(
    {
      changeMonth: true,
      changeYear: true,
      yearRange: "2019:",
      minDate: new Date(2019, 5, 10)
    });

    $( "#invoice_start" ).datepicker(
    {
       changeMonth: true,
       changeYear: true,
       yearRange: "2012:",
       minDate: new Date(2012, 5, 1)
    });

    $( "#invoice_end" ).datepicker(
    {
      changeMonth: true,
      changeYear: true,
      yearRange: "2012:",
      minDate: new Date(2012, 5, 1)
    });

    $( "#invoice_closed_start" ).datepicker(
    {
       changeMonth: true,
       changeYear: true,
       yearRange: "2012:",
       minDate: new Date(2012, 5, 1)
    });

    $( "#invoice_closed_end" ).datepicker(
    {
      changeMonth: true,
      changeYear: true,
      yearRange: "2012:",
      minDate: new Date(2012, 5, 1)
    });

    $( "#order_start" ).datepicker(
    {
       changeMonth: true,
       changeYear: true,
       yearRange: "2012:",
       minDate: new Date(2012, 5, 1)
    });

    $( "#order_end" ).datepicker(
    {
      changeMonth: true,
      changeYear: true,
      yearRange: "2012:",
      minDate: new Date(2019, 5, 1)
    });

    $( "#status_date_start" ).datepicker(
    {
      changeMonth: true,
      changeYear: true,
      yearRange: "2012:",
      minDate: new Date(2012, 5, 1)
    });

    $( "#status_date_end" ).datepicker(
    {
      changeMonth: true,
      changeYear: true,
      yearRange: "2012:",
      minDate: new Date(2012, 5, 1)
    });

    $( "#deleted_date_start" ).datepicker(
    {
      changeMonth: true,
      changeYear: true,
      yearRange: "2012:",
      minDate: new Date(2012, 5, 1)
    });

    $( "#deleted_date_end" ).datepicker(
    {
      changeMonth: true,
      changeYear: true,
      yearRange: "2012:",
      minDate: new Date(2012, 5, 1)
    });

    $( "#relative_date" ).datepicker(
    {
      changeMonth: true,
      changeYear: true,
      yearRange: "2012:"
    });


    $( "#relative_start_date" ).datepicker(
    {
      changeMonth: true,
      changeYear: true,
      yearRange: "-0:+2"
    });

});