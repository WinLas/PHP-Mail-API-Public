<!DOCTYPE html>
<html lang="sv">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0 maximum-scale=1, user-scalable=no" />
	<title><?= isset($page_title) ? $page_title : 'WLOffice';?></title>
	
	<script>var base_url='<?=base_url()?>'</script>
	<script>var base_konto_url='<?=WINLAS_KONTO_PATH?>'</script>
	<?php $baseJs='assets/js/' ?>
	
	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700|Fira Sans:300,400,500,700" rel="stylesheet">
	<link href="<?=base_url()?>assets/css/vendor.css" rel="stylesheet">
	<link href="<?=base_url()?>assets/css/winlas.css" rel="stylesheet">
	<script type="text/javascript" src="<?=base_url($baseJs)?>vendor.js"></script>
	<script type="text/javascript" src="<?=base_url($baseJs)?>winlas.js"></script>
	<link href="<?= base_url()?>assets/favicon.png" rel="shortcut icon">

</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-inverse fixed-top p-0">
		<div class="container-fluid">
			<a class="navbar-brand d-flex align-items-center" href="<?=base_url()?>"><img width="160" height="40" class="img-fluid pb-1" src="<?=base_url('assets/img/logo.svg')?>"><span class="ml-3">Mail-API-v2-LOG</span></a>
			<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon text-white"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarCollapse">
				<ul class="nav navbar-nav mr-auto">
				</ul>
				<ul class="nav navbar-nav">
						<li class="nav-item" id="nav-start">
							<a href="<?=site_url('')?>" class="nav-link" data-tooltip='tooltip' data-placement='bottom' title="Startsida"> 
								<i class="fal fa-fw fa-lg fa-home"></i>
								<span class="d-inline-block d-sm-none ml-2">Start</span>
							</a>
						</li>
						<li class="nav-item" id="nav-kundregister">
							<a href="<?=site_url('kundregister/main')?>" data-tooltip='tooltip' data-placement='bottom' class="nav-link" title="Kundregister"> 
								<i class="fal fa-fw fa-lg fa-heart"></i>
								<span class="d-inline-block d-sm-none ml-2">Kundregister</span>
							</a>
						</li>
						<li class="nav-item" id="nav-arenden">
							<a href="<?=site_url('arenden')?>" data-tooltip='tooltip' data-placement='bottom'  class="nav-link" title="Ärenden"> 
								<i class="fal fa-fw fa-lg fa-suitcase"></i>
								<span class="d-inline-block d-sm-none ml-2">Ärenden</span>
							</a>
						</li>
						<li class="nav-item" id="nav-projekt">
							<a href="<?=site_url('projekt')?>" data-tooltip='tooltip' data-placement='bottom'  class="nav-link" title="Projekt">
								<i class="fal fa-fw fa-lg fa-folder-open"></i>
								<span class="d-inline-block d-sm-none ml-2">Projekt</span>
							</a>
						</li>
						<li class="nav-item" id="nav-sok">
							<a href="<?=site_url('sok')?>" data-tooltip='tooltip' data-placement='bottom'  class="nav-link" title="Ärendesökning">
								<i class="fal fa-fw fa-lg fa-search"></i>
								<span class="d-inline-block d-sm-none ml-2">Ärendesökning</span>
							</a>
						</li>
						<li class="nav-item" id="nav-rapporter">
							<a href="<?=site_url('rapporter')?>" data-tooltip='tooltip' data-placement='bottom'  class="nav-link" title="Rapporter">
								<i class="fal fa-fw fa-lg fa-file-alt"></i>
								<span class="d-inline-block d-sm-none ml-2">Rapporter</span>
							</a>
						</li>
						<li class="nav-item" id="nav-interninfo">
							<a href="<?=site_url('interninfo')?>" data-tooltip='tooltip' data-placement='bottom'  class="nav-link" title="Interninfo">
								<i class="fal fa-fw fa-lg fa-info"></i>
								<span class="d-inline-block d-sm-none ml-2">Interninfo</span>
							</a>
						</li>
						<li class="nav-item" id="nav-kanban">
							<a href="<?=site_url('kanban/')?>" data-tooltip='tooltip' data-placement='bottom'  class="nav-link" title="Kanban">
								<i class="fal fa-fw fa-lg fa-list"></i>
								<span class="d-inline-block d-sm-none ml-2">Rapporter</span>
							</a>
						</li>
						<li class="nav-item" id="nav-versionsinfo">
							<a href="<?=site_url('versionsinfo/')?>" data-tooltip='tooltip' data-placement='bottom'  class="nav-link" title="Versionsinfo">
								<i class="fal fa-fw fa-lg fa-code-branch"></i>
								<span class="d-inline-block d-sm-none ml-2">Versionsinfo</span>
							</a>
						</li>
						<li class="nav-item" id="nav-statistik">
							<a href="<?=site_url('statistik/')?>" data-tooltip='tooltip' data-placement='bottom'  class="nav-link" title="Statistik">
								<i class="fal fa-fw fa-lg fa-chart-bar"></i>
								<span class="d-inline-block d-sm-none ml-2">Statistik</span>
							</a>
						</li>
						<li class="nav-item" id="nav-users">
							<a href="<?=site_url('users')?>" data-tooltip='tooltip' data-placement='bottom'  class="nav-link" title="Administrera användare">
								<i class="fal fa-fw fa-lg fa-users"></i>
								<span class="d-inline-block d-sm-none ml-2">Administrera användare</span>
							</a>
						</li>
						<li class="nav-item" id="nav-installningar">
							<a href="<?=WINLAS_KONTO_PATH?>/start?ref=1" data-tooltip='tooltip' data-placement='bottom'  class="nav-link" title="Inställningar">
								<i class="fal fa-lg fa-cog"></i>
							</a>
							<span class="d-inline-block d-sm-none ml-2">Inställningar</span>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="<?=WINLAS_KONTO_PATH.'/logout?continue='.urlencode(current_url())?>" data-tooltip='tooltip' data-placement='bottom'  title="Logga ut">
								<i class="fal fa-lg fa-sign-out"></i>
							</a>
							<span class="d-inline-block d-sm-none ml-2">Logga ut</span>
						</li>
						<li class="nav-item" id="nav-kund">
							<a href="<?=site_url('kund')?>" data-tooltip='tooltip' data-placement='bottom'  class="nav-link flex-center sm" title="Nytt ärende">
								Nytt ärende
							</a>
						</li>
						<li class="nav-item" id="nav-arenden">
							<a href="<?=site_url('kund/arenden')?>" data-tooltip='tooltip' data-placement='bottom'  class="nav-link flex-center sm" title="Mina ärenden">
								Mina ärenden
							</a>
						</li>
						<li class="nav-item" id="nav-installningar">
							<a href="<?=WINLAS_KONTO_PATH?>/start?ref=1" data-tooltip='tooltip' data-placement='bottom'  class="nav-link flex-center sm" title="Inställningar">
								Inställningar
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link flex-center sm text-danger" data-tooltip='tooltip' data-placement='bottom' href="<?=WINLAS_KONTO_PATH.'/logout?continue='.urlencode(current_url())?>" title="Logga ut">
								Logga ut
							</a>
						</li>

				</ul>
			</div>
		</nav>
		<input type="hidden" id="location" value="<?=  $this->uri->segment(1); ?>">
		<input type="hidden" id="location-2" value="<?=  $this->uri->segment(2); ?>">
		<!-- /.container -->
		<!-- Sätter sidan användaren är inne på som active i navbaren -->