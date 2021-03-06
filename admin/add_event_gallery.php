<!DOCTYPE html>
<html lang="en">
  <?php
	include_once('include/dbconfig.php');
	include_once('include/common_function.php');
	include_once("include/head.php");
	if($_POST['action']=='frmsubmit'){
		$event_id = $_POST['event_id'];
		$gallery_type= $_POST['gallery_type'];		
		$video_url= $_POST['video_url'];
		$status = $_POST['status'];
		if($_POST['actiontype']=='insert'){
			if($_FILES['image']['name']!=''){
				$imgname = $_FILES['image']['name'];
				$temp_name= $_FILES['image']['tmp_name'];
				$path = 'gallery_images/';
				$uploadfile = image_upload($imgname, $_FILES['image']['tmp_name'], $path);
			}
			
			$insert = mysql_query("insert into event_gallery set event_id='".$event_id."', gallery_type='".$gallery_type."', video_url='".$video_url."', image='".$uploadfile."', created_on='".DATETIME."', created_by='".$_SESSION['user_id']."' ");
			
			if($insert==1){
				//header("location: lord_list.php?add=done");
				echo '<script>window.location.href="event_gallery_list.php?add=done"</script>';
			}
		}
		if($_POST['actiontype']=='update'){			
			if($_FILES['image']['name']!=''){
				$imgname = $_FILES['image']['name'];
				$temp_name= $_FILES['image']['tmp_name'];
				$path = 'gallery_images/';
				$uploadfile = image_upload($imgname, $_FILES['image']['tmp_name'], $path);
				@unlink($path.$_POST['oldimage']);
			} else if($_POST['oldimage']!=''){
				$uploadfile = $_POST['oldimage'];
			} else {
				$uploadfile='';
			}
				
			$update = mysql_query("update event_gallery set event_id='".$event_id."', gallery_type='".$gallery_type."', video_url='".$video_url."', image='".$uploadfile."', updated_on='".DATETIME."', updated_by='".$_SESSION['user_id']."', status='".$status."' where id='".$_REQUEST['id']."'");
			if($update){
				$frmmsg = UPDATEMSG;
			}
			
		}
	}
	if($_REQUEST['id']!=''){
		$result_row = single_row('event_gallery', 'id', $_REQUEST['id']);
	}
	
  
  ?>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
       

        <?php
        // side bar //
        include_once("include/sidemenu.php");

        // top menu //
        include_once("include/topmenu.php");
        ?>

        <!-- page content -->
			<div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Event Gallery</h3>
              </div>

              <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button">Go!</button>
                    </span>
                  </div>
                </div>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Add Event Gallery </h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
					<?php if($frmmsg!='') {?>
						<p><strong><?php echo $frmmsg?></strong></p>
					<?php } ?>
                    <form name="addfrm" id="" data-parsley-validate class="form-horizontal form-label-left" method="post" enctype="multipart/form-data">

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Event Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select name="event_id" required="required" class="form-control col-md-7 col-xs-12">
                            <option value="">--Select--</option>
                            <?php
							  $select = mysql_query("select * from event where status='1' order by event_title asc");
							  $i=1;
							  while($row = mysql_fetch_assoc($select)) {
							  ?>
							  <option value="<?php echo $row['id']?>" <?php if($result_row['event_id']==$row['id']) { echo 'selected="selected"';}?>><?php echo $row['event_title']?></option>
							  <?php } ?>
						  </select>
                        </div>
                      </div>
					  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Gallery Type
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
						<?php if($_REQUEST['id'] > 0) { ?>
						<?php if($result_row['gallery_type']=='photo') { ?>
						<input type="radio" name="gallery_type" class="" required="required" value="photo" checked/> Photo 
						<?php } ?>
						<?php if($result_row['gallery_type']=='video') { ?>
						<input type="radio" name="gallery_type" class="" required="required" value="video" checked/> Video 
						<?php } ?>
						<?PHP } else { ?>
                          <input type="radio" name="gallery_type" class="" required="required" value="photo" /> Photo 
						  <input type="radio" name="gallery_type" class="" required="required" value="video" /> Video 
						<?php } ?>
                        </div>
                      </div>
					  <?php if($_REQUEST['id'] > 0) { ?>
						<?php if($result_row['gallery_type']=='video') { ?>
							<div class="form-group" id="divvid" >
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Video Url
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
								  <input type="text" id="video_url" name="video_url" class="form-control col-md-7 col-xs-12" value="<?php echo $result_row['video_url']?>"  />
								</div>
							  </div>
						<?php } ?>
						<?php if($result_row['gallery_type']=='photo') { ?>
						<div class="form-group" id="divimg" style="">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Image <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="file" name="image" id="gallimage" class="" >
						  <?php
						  if($result_row['image']!='') { ?>
						  <input type="hidden" id="oldimage" name="oldimage" value="<?php echo $result_row['image'];?>">
						  <a href="<?php echo $baseurl.'/gallery_images/'.$result_row['image']?>" target="_blank"><?php echo $result_row['image'];?></a>
						  <?php } ?>
                        </div>
                      </div>
						<?php } ?>
					  <?php }  else { ?>
					  <div class="form-group" id="divimg" style="display:none">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Image <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="file" name="image" id="gallimage" class="" >
						  <?php
						  if($result_row['image']!='') { ?>
						  <input type="hidden" id="oldimage" name="oldimage" value="<?php echo $result_row['image'];?>">
						  <a href="<?php echo $baseurl.'/gallery_images/'.$result_row['image']?>" target="_blank"><?php echo $result_row['image'];?></a>
						  <?php } ?>
                        </div>
                      </div>
                      <div class="form-group" id="divvid" style="display:none">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Video Url
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="video_url" name="video_url" class="form-control col-md-7 col-xs-12" value="<?php echo $result_row['video_url']?>"  />
                        </div>
                      </div>
					  <?php } ?>
					  
					  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Status<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
							<select name="status" required="required" class="form-control col-md-7 col-xs-12">
								<option value="1" <?php if($result_row['status']=='1') { echo 'selected="selected"';}?>>Active</option>
								<option value="0" <?php if($result_row['status']=='0') { echo 'selected="selected"';}?>>In-Active</option>
							</select>
                        </div>
                      </div>
					  
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button type="button" class="btn btn-primary" onclick="document.location.href='event_gallery_list.php'">Back</button>
                          <button type="submit" class="btn btn-success">Submit</button>
						  <?php if($_REQUEST['id']!=''){ ?>
						  <input type="hidden" name="actiontype" value="update" />
						  <?php  } else { ?>
                          <input type="hidden" name="actiontype" value="insert" />
						  <?php  } ?>
						  <input type="hidden" name="action" value="frmsubmit" />
                        </div>
                      </div>

                    </form>
                  </div>
                </div>
              </div>
            </div>

            

            

           


          </div>
        </div>
		
		
          </div>
        </div>
        <!-- /page content -->

        <!-- footer content -->
       <?php
       include_once("include/footer.php"); 
       ?>
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="vendors/nprogress/nprogress.js"></script>
    <!-- Chart.js -->
    <script src="vendors/Chart.js/dist/Chart.min.js"></script>
    <!-- gauge.js -->
    <script src="vendors/gauge.js/dist/gauge.min.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="vendors/iCheck/icheck.min.js"></script>
    <!-- Skycons -->
    <script src="vendors/skycons/skycons.js"></script>
    <!-- Flot -->
    <script src="vendors/Flot/jquery.flot.js"></script>
    <script src="vendors/Flot/jquery.flot.pie.js"></script>
    <script src="vendors/Flot/jquery.flot.time.js"></script>
    <script src="vendors/Flot/jquery.flot.stack.js"></script>
    <script src="vendors/Flot/jquery.flot.resize.js"></script>
    <!-- Flot plugins -->
    <script src="vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
    <script src="vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
    <script src="vendors/flot.curvedlines/curvedLines.js"></script>
    <!-- DateJS -->
    <script src="vendors/DateJS/build/date.js"></script>
    <!-- JQVMap -->
    <script src="vendors/jqvmap/dist/jquery.vmap.js"></script>
    <script src="vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script src="vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="js/moment/moment.min.js"></script>
    <script src="js/datepicker/daterangepicker.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="build/js/custom.min.js"></script>

    <!-- Flot -->
    <script>
      $(document).ready(function() {
        var data1 = [
          [gd(2012, 1, 1), 17],
          [gd(2012, 1, 2), 74],
          [gd(2012, 1, 3), 6],
          [gd(2012, 1, 4), 39],
          [gd(2012, 1, 5), 20],
          [gd(2012, 1, 6), 85],
          [gd(2012, 1, 7), 7]
        ];

        var data2 = [
          [gd(2012, 1, 1), 82],
          [gd(2012, 1, 2), 23],
          [gd(2012, 1, 3), 66],
          [gd(2012, 1, 4), 9],
          [gd(2012, 1, 5), 119],
          [gd(2012, 1, 6), 6],
          [gd(2012, 1, 7), 9]
        ];
        $("#canvas_dahs").length && $.plot($("#canvas_dahs"), [
          data1, data2
        ], {
          series: {
            lines: {
              show: false,
              fill: true
            },
            splines: {
              show: true,
              tension: 0.4,
              lineWidth: 1,
              fill: 0.4
            },
            points: {
              radius: 0,
              show: true
            },
            shadowSize: 2
          },
          grid: {
            verticalLines: true,
            hoverable: true,
            clickable: true,
            tickColor: "#d5d5d5",
            borderWidth: 1,
            color: '#fff'
          },
          colors: ["rgba(38, 185, 154, 0.38)", "rgba(3, 88, 106, 0.38)"],
          xaxis: {
            tickColor: "rgba(51, 51, 51, 0.06)",
            mode: "time",
            tickSize: [1, "day"],
            //tickLength: 10,
            axisLabel: "Date",
            axisLabelUseCanvas: true,
            axisLabelFontSizePixels: 12,
            axisLabelFontFamily: 'Verdana, Arial',
            axisLabelPadding: 10
          },
          yaxis: {
            ticks: 8,
            tickColor: "rgba(51, 51, 51, 0.06)",
          },
          tooltip: false
        });

        function gd(year, month, day) {
          return new Date(year, month - 1, day).getTime();
        }
      });
    </script>
    <!-- /Flot -->

    <!-- JQVMap -->
    <script>
      $(document).ready(function(){
        $('#world-map-gdp').vectorMap({
            map: 'world_en',
            backgroundColor: null,
            color: '#ffffff',
            hoverOpacity: 0.7,
            selectedColor: '#666666',
            enableZoom: true,
            showTooltip: true,
            values: sample_data,
            scaleColors: ['#E6F2F0', '#149B7E'],
            normalizeFunction: 'polynomial'
        });
      });
    </script>
    <!-- /JQVMap -->

    <!-- Skycons -->
    <script>
      $(document).ready(function() {
        var icons = new Skycons({
            "color": "#73879C"
          }),
          list = [
            "clear-day", "clear-night", "partly-cloudy-day",
            "partly-cloudy-night", "cloudy", "rain", "sleet", "snow", "wind",
            "fog"
          ],
          i;

        for (i = list.length; i--;)
          icons.set(list[i], list[i]);

        icons.play();
      });
    </script>
    <!-- /Skycons -->

    <!-- Doughnut Chart -->
    <script>
      $(document).ready(function(){
	  
		$("input[name='gallery_type']").click(function(){
			// $("#gallimage").change(function (e) {
				// var image_file = $("#gallimage").val();
				// var ftype = image_file.split(".");
				// var extn = ftype.slice(-1)[0];
				// if(extn!='jpg' && extn!='jpeg' && extn!='png' && extn!='gif'){
					// alert("Please upload a valid image file.");
					// document.getElementById("gallimage").value = "";
					// return false;
				// }
			// });
			
			if($("input:radio[name='gallery_type']:checked").val()=='photo'){
				$("#gallimage").change(function (e) {
					var image_file = $("#gallimage").val();
					var ftype = image_file.split(".");
					var extn = ftype.slice(-1)[0];
					if(extn!='jpg' && extn!='jpeg' && extn!='png' && extn!='gif'){
						alert("Please upload a valid image file.");
						document.getElementById("gallimage").value = "";
						return false;
					}
				});
				$("#divimg").show();
				$("#gallimage").attr('required', 'required');
				$("#video_url").removeAttr('required');
				$("#divvid").hide();
				
			}
			if($("input:radio[name='gallery_type']:checked").val()=='video'){
				$("#divvid").show();
				$("#video_url").attr('required', 'required');
				$("#gallimage").removeAttr('required');
				$("#divimg").hide();
			}
		});
	  
	  
		var _URL = window.URL;
		$("#gallimage").change(function (e) {
		var image_file = $("#gallimage").val();
		var ftype = image_file.split(".");
		var extn = ftype.slice(-1)[0];
		if(extn!='jpg' && extn!='jpeg' && extn!='png' && extn!='gif'){
			alert("Please upload a valid image file.");
			document.getElementById("gallimage").value = "";
			return false;
		}
		/*	size validation below
			var file, img;
			if ((file = this.files[0])) {
				img = new Image();
				img.onload = function () {
					if(this.width!=200 && this.height!=150){
						alert("Logo image width and height should be 200 x 150 ");
						document.getElementById("lordimage").value = "";
					}
				};
				img.src = _URL.createObjectURL(file);
			}*/
			
		});

	  
	  
        var options = {
          legend: false,
          responsive: false
        };

        new Chart(document.getElementById("canvas1"), {
          type: 'doughnut',
          tooltipFillColor: "rgba(51, 51, 51, 0.55)",
          data: {
            labels: [
              "Symbian",
              "Blackberry",
              "Other",
              "Android",
              "IOS"
            ],
            datasets: [{
              data: [15, 20, 30, 10, 30],
              backgroundColor: [
                "#BDC3C7",
                "#9B59B6",
                "#E74C3C",
                "#26B99A",
                "#3498DB"
              ],
              hoverBackgroundColor: [
                "#CFD4D8",
                "#B370CF",
                "#E95E4F",
                "#36CAAB",
                "#49A9EA"
              ]
            }]
          },
          options: options
        });
      });
    </script>
    <!-- /Doughnut Chart -->
    
    <!-- bootstrap-daterangepicker -->
    <script>
      $(document).ready(function() {
	    var cb = function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
          $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        };

        var optionSet1 = {
          startDate: moment().subtract(29, 'days'),
          endDate: moment(),
          minDate: '01/01/2012',
          maxDate: '12/31/2015',
          dateLimit: {
            days: 60
          },
          showDropdowns: true,
          showWeekNumbers: true,
          timePicker: false,
          timePickerIncrement: 1,
          timePicker12Hour: true,
          ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          },
          opens: 'left',
          buttonClasses: ['btn btn-default'],
          applyClass: 'btn-small btn-primary',
          cancelClass: 'btn-small',
          format: 'MM/DD/YYYY',
          separator: ' to ',
          locale: {
            applyLabel: 'Submit',
            cancelLabel: 'Clear',
            fromLabel: 'From',
            toLabel: 'To',
            customRangeLabel: 'Custom',
            daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
            monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            firstDay: 1
          }
        };
        $('#reportrange span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
        $('#reportrange').daterangepicker(optionSet1, cb);
        $('#reportrange').on('show.daterangepicker', function() {
          console.log("show event fired");
        });
        $('#reportrange').on('hide.daterangepicker', function() {
          console.log("hide event fired");
        });
        $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
          console.log("apply event fired, start/end dates are " + picker.startDate.format('MMMM D, YYYY') + " to " + picker.endDate.format('MMMM D, YYYY'));
        });
        $('#reportrange').on('cancel.daterangepicker', function(ev, picker) {
          console.log("cancel event fired");
        });
        $('#options1').click(function() {
          $('#reportrange').data('daterangepicker').setOptions(optionSet1, cb);
        });
        $('#options2').click(function() {
          $('#reportrange').data('daterangepicker').setOptions(optionSet2, cb);
        });
        $('#destroy').click(function() {
          $('#reportrange').data('daterangepicker').remove();
        });
      });
    </script>
    <!-- /bootstrap-daterangepicker -->

    <!-- gauge.js -->
    <script>
      var opts = {
          lines: 12,
          angle: 0,
          lineWidth: 0.4,
          pointer: {
              length: 0.75,
              strokeWidth: 0.042,
              color: '#1D212A'
          },
          limitMax: 'false',
          colorStart: '#1ABC9C',
          colorStop: '#1ABC9C',
          strokeColor: '#F0F3F3',
          generateGradient: true
      };
      var target = document.getElementById('foo'),
          gauge = new Gauge(target).setOptions(opts);

      gauge.maxValue = 6000;
      gauge.animationSpeed = 32;
      gauge.set(3200);
      gauge.setTextField(document.getElementById("gauge-text"));
    </script>
    <!-- /gauge.js -->
  </body>
</html>
