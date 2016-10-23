<!DOCTYPE html>
<html lang="en">
  <?php
	include_once('include/dbconfig.php');
	include_once('include/common_function.php');
	include_once("include/head.php");
	if($_REQUEST['delete_id']!='' && $_REQUEST['delete_id'] > 0){
		$resultrow = single_row("event_gallery", "id", $_REQUEST['delete_id']);
		@unlink("gallery_images/".$resultrow['image']);
		$delete = deleterecord("event_gallery", "id", $_REQUEST['delete_id']);
		if($delete==true){
			$message = DELETEMSG;
		}
	}
	if($_REQUEST['add']=='done'){
		$message=INSERTMSG;
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
                <h3>Event Video</h3>
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
                    <h2>Event Video</h2>
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
				  <form name="searach" method="get">
					<table width="100%">
					<tr>
						<td>Lord Name</td>
						<td><select name="lordname"  class="form-control">
							<option value="">--Select--</option>
							<?php
							  $select = mysql_query("SELECT * from lords order by name asc");
							  $i=1;
							  while($row = mysql_fetch_assoc($select)) {
							  ?>
							  <option value="<?php echo $row['id']?>" <?php if($_REQUEST['lordname']==$row['id']) { echo 'selected="selected"';}?>><?php echo $row['name']?></option>
							  <?php } ?>
						  </select>
						 </td>
						<td>Status</td>
						<td><select name="status" class="form-control col-md-7 col-xs-12">
								<option value="">--Select--</option>
								<option value="1" <?php if($_REQUEST['status']=='1') { echo 'selected="selected"';}?>>Active</option>
								<option value="0" <?php if($_REQUEST['status']=='0') { echo 'selected="selected"';}?>>In-Active</option>
							</select>
						</td>
						<td><input type="submit" name="action" value="Search" class="btn btn-success" />
						<input type="button" name="actionreset" value="Reset" onclick="document.location.href='event_list.php'" class="btn btn-success" /></td>
						
					</tr>
					</table>
				  </form>
				  
					<?php if($message != '') { ?>
						<p><strong><?php echo $message?></strong></p>
					<?php } ?>
					
					<?php
					$end = '20';
					if($_REQUEST['page'] != ''){
						$start = ($_REQUEST['page']-1)*$end;
						$j = $start+1;
					} else {
						$start = 0;
						$j=1;
					}
					$searchquery='';
					if($_REQUEST['action']=='Search'){
						if($_REQUEST['status'] != ''){
							$status =$_REQUEST['status'];
							$searchquery .= " and status=$status";
						}
						if($_REQUEST['lordname'] != ''){
							$lordname = $_REQUEST['lordname'];
							$searchquery .= " and lordid = '".$lordname."' ";
						}
					}
					
					
					$totalquery = mysql_query("SELECT * from event_gallery where id!='' $searchquery and gallery_type='video'");
					$select = mysql_query("select * from event_gallery where id!='' $searchquery and gallery_type='video' order by id desc limit $start, $end");
					$alldata = mysql_num_rows($totalquery);
					?>
					<p>Total Records: <?php echo mysql_num_rows($totalquery)?></p>
                    <table id="datatable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Event Title</th>
						 
						 
						  <th>Video</th>
						  <th>Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
					  <?php
					  while($row = mysql_fetch_assoc($select)) {
					  ?>
                        <tr>
                          <td><?PHP echo $j?></td>
                          <td><?php 
						  $lordinfo = single_row('event', 'id', $row['event_id']);
							echo $lordinfo['event_title'];?></td>
						
						  <td><?php echo $row['video_url']?></td>
						  <td><?php 
						  if($row['status']=='0'){
							echo 'In-active';
						  } elseif($row['status']=='1'){
							echo 'Active';
							}?></td>
                          <td><a href="<?php echo $baseurl?>/add_event_gallery.php?id=<?php echo $row['id']?>">Edit<a/> | <a href="<?php echo $baseurl?>/event_gallery_list.php?delete_id=<?php echo $row['id']?>" onclick="return confirm('Are you sure want to delete?');">Delete<a/>
                        </tr>
					   <?php  $j++;}  ?>
                        
                        
                        
                      </tbody>
                    </table>
					
					
					
					<div class="pagination">	
								<?php
									$searchq='';									
									if($_REQUEST['action'] !=''){
										$action= $_REQUEST['action'];
										$searchq .= "&action=$action";
									} else {
										$searchq .='';
									}
									if($_REQUEST['status'] !=''){
										$status= $_REQUEST['status'];
										$searchq .= "&status=$status";
									} else {
										$searchq .='';
									}
									if($_REQUEST['lordname'] !=''){
										$lordname= $_REQUEST['lordname'];
										$searchq .= "&lordname=$lordname";
									} else {
										$searchq .='';
									}									
									$pages = ceil($alldata/$end);
									$tpages = $pages;
									$adjacents = 5;
									if($_REQUEST['page']){
										$page = intval($_REQUEST['page']);
									} else {
										$page = '1';
									}

									if($adjacents<=0) $adjacents = 5;
									$reload = $baseurl."/lord_list.php";
									$prevlabel = "&lsaquo; Prev";
									$nextlabel = "Next &rsaquo;";
									$out = "<div class=\"pagin\">\n";
									// previous
									if($page==1) {
										$out.= "<span>" . $prevlabel . "</span>\n";
									} elseif($page==2) {
										$out.= "<a href=\"" . $reload . "\">" . $prevlabel . "</a>\n";
									} else {
										$out.= "<a href=\"" . $reload . "?page=" . ($page-1) . $searchq. "\">" . $prevlabel . "</a>\n";
									}	
									// first
									if($page>($adjacents+1)) {
										$out.= "<a href=\"" . $reload . "\">1</a>\n";
									}	
									// interval
									if($page>($adjacents+2)) {
										$out.= "...\n";
									}	
									// pages
									$pmin = ($page>$adjacents) ? ($page-$adjacents) : 1;
									$pmax = ($page<($tpages-$adjacents)) ? ($page+$adjacents) : $tpages;
									for($i=$pmin; $i<=$pmax; $i++) {
										if($i==$page) {
											$out.= "<span class=\"current\">" . $i . "</span>\n";
										} elseif($i==1) {
											$out.= "<a href=\"" . $reload . "?page=" . $i .$searchq. "\">" . $i . "</a>\n";
										} else {
											$out.= "<a href=\"" . $reload . "?page=" . $i .$searchq. "\">" . $i . "</a>\n";
										}
									}
									// interval
									if($page<($tpages-$adjacents-1)) {
										$out.= "...\n";
									}	
									// last
									if($page<($tpages-$adjacents)) {
										$out.= "<a href=\"" . $reload . "?page=" . $tpages .$searchq. "\">" . $tpages . "</a>\n";
									}	
									// next
									if($page<$tpages) {
										$out.= "<a href=\"" . $reload . "?page=" . ($page+1) .$searchq. "\">" . $nextlabel . "</a>\n";
									} else {
										$out.= "<span>" . $nextlabel . "</span>\n";
									}	
									$out.= "</div>";	
									echo $out;
								   ?>
									</div>
					
					
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
