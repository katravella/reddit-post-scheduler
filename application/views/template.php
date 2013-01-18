<? 
$this->load->view('includes/header_view_p1');
//if(isset($header_extra)) { echo $header_extra; } 

if($this->router->fetch_class() == 'dashboard'): ?>
   <!-- breadcrumbs-->
            <link rel="stylesheet" href="static/lib/jBreadcrumbs/css/BreadCrumb.css" />
        <!-- tooltips-->
            <link rel="stylesheet" href="static/lib/qtip2/jquery.qtip.min.css" />
        <!-- colorbox -->
            <link rel="stylesheet" href="static/lib/colorbox/colorbox.css" />    
        <!-- code prettify -->
            <link rel="stylesheet" href="static/lib/google-code-prettify/prettify.css" />    
        <!-- notifications -->
            <link rel="stylesheet" href="static/lib/sticky/sticky.css" />    
        <!-- splashy icons -->
            <link rel="stylesheet" href="static/img/splashy/splashy.css" />
		<!-- flags -->
            <link rel="stylesheet" href="static/img/flags/flags.css" />	
		<!-- calendar -->
            <link rel="stylesheet" href="static/lib/fullcalendar/fullcalendar_gebo.css" />
?>
endif;

$this->load->view('includes/header_view_p2');
$this->load->view('pages/'.$page); 
$this->load->view('includes/footer_view_p1');
if($this->router->fetch_class() == 'dashboard'):
?>

			<script src="static/lib/jquery-ui/jquery-ui-1.8.23.custom.min.js"></script>
            <!-- touch events for jquery ui-->
            <script src="static/js/forms/jquery.ui.touch-punch.min.js"></script>
            <!-- multi-column layout -->
            <script src="static/js/jquery.imagesloaded.min.js"></script>
            <script src="static/js/jquery.wookmark.js"></script>
            <!-- responsive table -->
            <script src="static/js/jquery.mediaTable.min.js"></script>
            <!-- small charts -->
            <script src="static/js/jquery.peity.min.js"></script>
            <!-- charts -->
			<!-- lightbox -->
            <script src="static/lib/colorbox/jquery.colorbox.min.js"></script>
			<script src="static/lib/UItoTop/jquery.ui.totop.min.js"></script>

            <!-- calendar -->
            <script src="static/lib/fullcalendar/fullcalendar.min.js"></script>
            <!-- sortable/filterable list -->
            <script src="static/lib/list_js/list.min.js"></script>
            <script src="static/lib/list_js/plugins/paging/list.paging.js"></script>
            <!-- dashboard functions -->
            <script src="static/js/gebo_dashboard.js"></script>';	
<?php
endif;

//if(isset($footer_extra)) { echo $footer_extra; } 
$this->load->view('includes/footer_view_p2');
if (isset($footer)) $this->load->view('pages/'.$footer); 