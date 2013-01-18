        <!-- main styles -->
            <link rel="stylesheet" href="static/css/style.css" />
			
            <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=PT+Sans" />
	
        <!-- Favicon -->
            <link rel="shortcut icon" href="favicon.ico" />
		<script type="text/javascript" src="http://stage.redditaide.com/static/js/jquery.min.js"></script>
<script src="<?=base_url()?>static/lib/jquery-ui/jquery-ui-1.8.23.custom.min.js"></script>
<script src="<?=base_url()?>static/js/forms/jquery.autosize.min.js"></script>

        <!--[if lte IE 8]>
            <link rel="stylesheet" href="static/css/ie.css" />
            <script src="static/js/ie/html5.js"></script>
			<script src="static/js/ie/respond.min.js"></script>
        <![endif]-->
		
		<script>
			//* hide all elements & show preloader
			document.documentElement.className += 'js';
		</script>
    </head>
    <body class="sidebar_hidden gebo-fixed menu_hover">
	<div id="loading_layer" style="display:none"><img src="static/img/ajax_loader.gif" alt="" /></div> 
		<div id="maincontainer" class="clearfix">
			<!-- header -->
            <header>
                <div class="navbar navbar-fixed-top">
                    <div class="navbar-inner">
                        <div class="container-fluid">
                            <a class="brand" href="<?=base_url();?>"><i class="icon-home icon-white"></i> Redditaide</a>
                            <ul class="nav user_menu pull-right">
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?=$this->session->userdata('username');?> <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
										<!--li><a href="#">Edit Profile</a></li-->
										<li class="divider"></li>
										<li><a href="auth/logout">Logout</a></li>
                                    </ul>
                                </li>
                            </ul>
                            <ul class="nav" id="mobile-nav">
								<li>
									<a href="<?=base_url();?>"> Dashboard </a>
								</li>
								<li class="dropdown">
									<a data-toggle="dropdown" class="dropdown-toggle" href="#"> Threads <b class="caret"></b></a>
									<ul class="dropdown-menu">
										<li><a href="<?=base_url()?>thread/create">Add Thread</a></li>
										<li><a href="<?=base_url()?>thread/list">Manage Threads</a></li>
										<li><a href="<?=base_url()?>thread/log">Thread Log</a></li>
									</ul>
								</li>
								<li class="dropdown">
									<a data-toggle="dropdown" class="dropdown-toggle" href="#"> Bots <b class="caret"></b></a>
									<ul class="dropdown-menu">
										<li><a data-toggle="modal" data-backdrop="static" href="#modalAddBot">Add Bot</a></li>
										<li><a href="<?=base_url()?>dashboard/users/list">Manage Bots</a></li>
										<li><a href="#">Bot Log</a></li>
									</ul>
								</li>
								<li>
									<a href="#"> Support </a>
								</li>
							</ul>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- main content -->
            <div id="contentwrapper">
                <div class="main_content">