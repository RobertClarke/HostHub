<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Host List</title>
	<link rel="stylesheet" href="./assets/css/main.css" type="text/css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700" type="text/css">

	<link rel="stylesheet" href="https://i.icomoon.io/public/temp/db83463888/UntitledProject/style.css">


	<link rel="shortcut icon" href="/favicon.png">
	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
	<meta name="format-detection" content="telephone=no">
</head>

<body id="offers-dedicated">
	<section id="header">
		<div class="wrapper">
			<div id="logo">Host List</div>
		</div>
	</section>

	<section id="sub-header">
		<div class="wrapper">
			<header>
				<h1><span>Dedicated Server</span> Offers</h1>
			</header>
			<p>Dedicated servers consist of purely dedicated hardware that is yours to manage, every host will choose different hardware for their servers (brand, processor, RAM, hard drives etc). From what we've seen in the marketplace there's no real way to know what quality &amp; performance you will get from a dedicated server without reading reviews from existing customers.</p>
			<div class="filters">


	<?php


	$cpus = [

	[
	'id'			=> 'E7-4850',
	'family'		=> 'Intel Xeon',
	'model'			=> 'E7-4850 v3',
	'description'	=> '2.20 GHz, 14 Cores, 35M Cache'
	],
	[
	'id'			=> 'E7-4830',
	'family'		=> 'Intel Xeon',
	'model'			=> 'E7-4830 v3',
	'description'	=> '2.10 GHz, 12 Cores, 30M Cache'
	],
	[
	'id'			=> 'E7-4820',
	'family'		=> 'Intel Xeon',
	'model'			=> 'E7-4820 v3',
	'description'	=> '1.90 GHz, 10 Cores, 25M Cache'
	],
	[
	'id'			=> 'E7-4809',
	'family'		=> 'Intel Xeon',
	'model'			=> 'E7-4809 v3',
	'description'	=> '2.00 GHz, 8 Cores, 20M Cache'
	],
	[
	'id'			=> 'E7-8893',
	'family'		=> 'Intel Xeon',
	'model'			=> 'E7-8893 v3',
	'description'	=> '3.20 GHz, 4 Cores, 45M Cache'
	],
	[
	'id'			=> 'E7-8891',
	'family'		=> 'Intel Xeon',
	'model'			=> 'E7-8891 v3',
	'description'	=> '2.80 GHz, 10 Cores, 45M Cache'
	]

	];

	foreach ( $cpus as $id => $cpu ) {
	$cpus[$id]['name'] = $cpu['family'].' '.$cpu['model'];
	$cpus[$id]['json'] = htmlspecialchars(json_encode($cpu, JSON_FORCE_OBJECT));
	}

	//echo '<pre>'; print_r($cpus); echo '</pre>';

	?>

				<div class="selects">

					<select id="filter-cpu" placeholder="CPU Model" class="filter-cpu">
						<option value="">CPU Model</option>
						<?php foreach ( $cpus as $cpu ) echo '<option value="'.$cpu['id'].'" data-data="'.$cpu['json'].'">'.$cpu['name'].'</option>'; ?>
					</select>
					<select id="filter-ram" placeholder="Memory" class="filter-ram">
						<option value="">Memory</option>
						<option value="1">1GB</option>
						<option value="2">2GB</option>
						<option value="4">4GB</option>
						<option value="6">6GB</option>
						<option value="8">8GB</option>
						<option value="12">12GB</option>
						<option value="16">16GB</option>
						<option value="24">24GB</option>
						<option value="32">32GB</option>
						<option value="48">48GB</option>
						<option value="64">64GB</option>
						<option value="128">128GB</option>
						<option value="256">256GB</option>
					</select>
					<select id="filter-storage" placeholder="Disk Space" class="filter-storage">
						<option value="">Disk Space</option>
						<option value="10">At least 10GB</option>
						<option value="20">At least 20GB</option>
						<option value="60">At least 60GB</option>
						<option value="120">At least 120GB</option>
						<option value="240">At least 240GB</option>
						<option value="500">At least 500GB</option>
						<option value="1000">At least 1TB</option>
						<option value="2000">At least 2TB</option>
						<option value="4000">At least 4TB</option>
						<option value="6000">At least 6TB</option>
						<option value="8000">At least 8TB</option>
					</select>
					<select id="filter-bandwidth" placeholder="Bandwidth" class="filter-bandwidth">
						<option value="">Bandwidth</option>
						<option value="10">At least 10GB</option>
						<option value="20">At least 20GB</option>
						<option value="60">At least 60GB</option>
						<option value="120">At least 120GB</option>
						<option value="240">At least 240GB</option>
						<option value="500">At least 500GB</option>
						<option value="1000">At least 1TB</option>
						<option value="2000">At least 2TB</option>
						<option value="4000">At least 4TB</option>
						<option value="6000">At least 6TB</option>
						<option value="8000">At least 8TB</option>
					</select>

				</div>

				<div class="toggles">

					<div class="toggle" id="filter-setup" data-filter="instant_setup">Instant Setup</div>
					<div class="toggle" id="filter-ddos" data-filter="ddos_protected">DDOS Protected</div>
					<div class="toggle" id="filter-ipmi" data-filter="ipmi">IPMI</div>
					<div class="toggle" id="filter-ssd" data-filter="ssd">SSD Drives</div>
					<div class="toggle" id="filter-ecc" data-filter="ecc">ECC RAM</div>

					<div class="toggle hidden" id="filter-setup" data-filter="asdasd">more 1</div>
					<div class="toggle hidden" id="filter-ddos" data-filter="qweqwe">more 2</div>
					<div class="toggle hidden" id="filter-ipmi" data-filter="asd">more 3</div>
					<div class="toggle hidden" id="filter-ssd" data-filter="qweqwe">more 4</div>
					<div class="toggle hidden" id="filter-ecc" data-filter="sdfsdfsc">more 5</div>
					<div class="toggle hidden" id="filter-ssd" data-filter="dsfsdfsdfd">more 6</div>
					<div class="toggle hidden" id="filter-ecc" data-filter="sadasdsadwe">more 7</div>

					<div class="toggle more" id="filter-more" data-type="expand">MORE FILTERS</div>

				</div>

			</div>
			<div class="list-offer">
				<p><b class="hilight">Have an offer to share?</b> Reach thousands of potential dedicated server customers by listing your offer on our directory for free!</p>
				<div class="actions">
					<a href="#" class="button submit">List Offer</a>
					<a href="#" class="close tooltip" title="Don't Show This"><i class="icon-close"></i></a>
				</div>
			</div>


		</div>
	</section>

	<section id="content">
		<div class="wrapper">
			<header id="title">
				<h2>Showing <b>Dedicated Server</b> offers with an <b>Intel Xeon E7-4850 v3</b> and <b>DDOS Protection</b> located in <b>Canada</b></h2>
				<p>2,504 offers found</p>
			</header>
			<section id="posts">
<?php for ($x = 0; $x <= 10; $x++) { ?>
				<article<?php if ( $x == 0 || $x == 1 ) echo ' class="featured"' ?>>
					<a href="#" class="favorite"><i class="icon-favorite_border"></i></a>
					<div class="main">
						<header>
							<div class="title">
								<h3><a href="#">Haswell E5-2630 v3 (16 threads @ 3.2 GHz), 128GB RAM, 4x 512GB SSDs, HW...</a></h3>
								<p>Posted 34 minutes ago &bull; Expires in 39 hours</p>
							</div>
							<div class="company-logo"><img src="./assets/img/servercrate.png" width="160" height="15" alt="ServerCrate" /></div>
						</header>
						<div class="specs">
							<ul>
								<li><span><i class="icon-cpu"></i>CPU</span> Intel Haswell E5-2630 v3 3.2GHz</li>
								<li><span><i class="icon-hdd"></i>Storage</span> 4x 512GB SSD</li>
								<li><span><i class="icon-bandwidth"></i>Bandwidth</span> 1TB</li>
								<li><span><i class="icon-ram"></i>RAM</span> 128GB ECC</li>
								<li><span><i class="icon-location"></i>Location</span> Toronto, Canada</li>
								<li><span><i class="icon-port"></i>Port Speed</span> 10Gbit</li>
							</ul>
							<div class="details"><a href="#">Server Details</a></div>
						</div>
					</div>
					<div class="pricing">
						<p class="price">
							<span class="currency">$</span>
							<span class="dollars">550</span>
							<span class="cents">.00</span>
							<span class="term">/mo</span>
						</p>
						<p class="sub"><s>$62.50 /mo</s> &bull; 25% OFF</p>
						<a href="#" class="button claim">Claim Offer</a>
					</div>
				</article>
<?php } ?>
			</section>
		</div>
	</section>

	<footer>

	</footer>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	<script src="./assets/js/base.js"></script>

	<script>

	$('#filter-cpu').selectize({
	    valueField: 'url',
	    labelField: 'name',
	    searchField: 'name',
		render: {
			option: function(item, escape) {
				return '<div><span class="title"><img src="https://cdn2.iconfinder.com/data/icons/metro-uinvert-dock/128/Intel.png" width="16" height="16" style="position: relative; top: 2px; margin-right: 5px;"><span class="name">'+item.family+'</span><span class="by">'+item.model+'</span></span><span class="description">'+item.description+'</span></div>';
			}
        },
		onChange: function(value) {


			// // CPU FILTER CHANGED, APPLY FILTER ~~ APPLY THIS TO GLOBALLY FOR EVERY SELECT???? WITH DATA('TYPE') TO GRAB WHAT TO CHANGE
			// // CPU FILTER CHANGED, APPLY FILTER ~~ APPLY THIS TO GLOBALLY FOR EVERY SELECT???? WITH DATA('TYPE') TO GRAB WHAT TO CHANGE
			// // CPU FILTER CHANGED, APPLY FILTER ~~ APPLY THIS TO GLOBALLY FOR EVERY SELECT???? WITH DATA('TYPE') TO GRAB WHAT TO CHANGE
			// // CPU FILTER CHANGED, APPLY FILTER ~~ APPLY THIS TO GLOBALLY FOR EVERY SELECT???? WITH DATA('TYPE') TO GRAB WHAT TO CHANGE
			// // CPU FILTER CHANGED, APPLY FILTER ~~ APPLY THIS TO GLOBALLY FOR EVERY SELECT???? WITH DATA('TYPE') TO GRAB WHAT TO CHANGE
			// // CPU FILTER CHANGED, APPLY FILTER ~~ APPLY THIS TO GLOBALLY FOR EVERY SELECT???? WITH DATA('TYPE') TO GRAB WHAT TO CHANGE
			// // CPU FILTER CHANGED, APPLY FILTER ~~ APPLY THIS TO GLOBALLY FOR EVERY SELECT???? WITH DATA('TYPE') TO GRAB WHAT TO CHANGE
			// // CPU FILTER CHANGED, APPLY FILTER ~~ APPLY THIS TO GLOBALLY FOR EVERY SELECT???? WITH DATA('TYPE') TO GRAB WHAT TO CHANGE
			// // CPU FILTER CHANGED, APPLY FILTER ~~ APPLY THIS TO GLOBALLY FOR EVERY SELECT???? WITH DATA('TYPE') TO GRAB WHAT TO CHANGE
			// // CPU FILTER CHANGED, APPLY FILTER ~~ APPLY THIS TO GLOBALLY FOR EVERY SELECT???? WITH DATA('TYPE') TO GRAB WHAT TO CHANGE
			// // CPU FILTER CHANGED, APPLY FILTER ~~ APPLY THIS TO GLOBALLY FOR EVERY SELECT???? WITH DATA('TYPE') TO GRAB WHAT TO CHANGE
			// // CPU FILTER CHANGED, APPLY FILTER ~~ APPLY THIS TO GLOBALLY FOR EVERY SELECT???? WITH DATA('TYPE') TO GRAB WHAT TO CHANGE
			// // CPU FILTER CHANGED, APPLY FILTER ~~ APPLY THIS TO GLOBALLY FOR EVERY SELECT???? WITH DATA('TYPE') TO GRAB WHAT TO CHANGE
			// // CPU FILTER CHANGED, APPLY FILTER ~~ APPLY THIS TO GLOBALLY FOR EVERY SELECT???? WITH DATA('TYPE') TO GRAB WHAT TO CHANGE
			// // CPU FILTER CHANGED, APPLY FILTER ~~ APPLY THIS TO GLOBALLY FOR EVERY SELECT???? WITH DATA('TYPE') TO GRAB WHAT TO CHANGE
			// // CPU FILTER CHANGED, APPLY FILTER ~~ APPLY THIS TO GLOBALLY FOR EVERY SELECT???? WITH DATA('TYPE') TO GRAB WHAT TO CHANGE
			// // CPU FILTER CHANGED, APPLY FILTER ~~ APPLY THIS TO GLOBALLY FOR EVERY SELECT???? WITH DATA('TYPE') TO GRAB WHAT TO CHANGE
			// // CPU FILTER CHANGED, APPLY FILTER ~~ APPLY THIS TO GLOBALLY FOR EVERY SELECT???? WITH DATA('TYPE') TO GRAB WHAT TO CHANGE


		}
	});
	$('#filter-ram').selectize({
		render: {
			item: function(item, escape) {
				return '<div><span class="name">' + escape(item.text) + ' Memory</span></div>';
			}
		}
	});
	$('#filter-storage').selectize({
		render: {
			item: function(item, escape) {
				return '<div><span class="name">' + escape(item.text) + ' Disk Space</span></div>';
			}
		}
	});
	$('#filter-bandwidth').selectize({
		render: {
			item: function(item, escape) {
				return '<div><span class="name">' + escape(item.text) + ' Bandwidth</span></div>';
			}
		}
	});

	var filterValues = [];
	var filterUrl = '';

	var filterAllowed = ['instant_setup', 'ddos_protected', 'ipmi', 'ssd', 'ecc'];

	$('.toggles .toggle').click(function(e) {

		// "More Filters" button pressed
		if ( $(this).data('type') === 'expand' ) {
			$('.toggles .hidden').show();
			$('.toggles .more').hide();
			return false;
		}

		// Check if requested filter is allowed
		if ( $.inArray( $(this).data('filter'), filterAllowed ) > -1 ) {

			// Filter enabled
			if ( !$(this).hasClass('selected') ) {

				filterValues.push( $(this).data('filter') );

			// Filter disabled
			} else {

				// Check if filter exists in array and splice it
				if (filterValues.indexOf($(this).data('filter')) > -1) {
				    filterValues.splice(filterValues.indexOf($(this).data('filter')), 1);
				}

			}

			$(this).toggleClass('selected');

			// Reset URL before making a new one
			filterUrl = '';

			filterAllowed.forEach( function(f) {

				if ( $.inArray( f, filterValues ) > -1 ) {
					filterUrl += f + '&';
				}

			});

			// Remove the last & symbol
			filterUrl = filterUrl.substring(0, filterUrl.length - 1);

			window.history.pushState(null, null, '?' + filterUrl);

		}

		e.preventDefault();

	});

	$('#sub-header .list-offer a.close').click(function(e) {
		$('#sub-header .list-offer').hide(); // Animate this eventually
		e.preventDefault();
	});

	$(document).ready(function() {
            $('.tooltip').tooltipster({
				theme: 'tooltipster-custom',
				speed: 250
			});
        });


	// TEMPORARY!!
	// TEMPORARY!!
	// TEMPORARY!!
	// TEMPORARY!!
	// TEMPORARY!!
	// TEMPORARY!!
	// TEMPORARY!!
	// TEMPORARY!!
	// TEMPORARY!!
	// TEMPORARY!!
	$('a.favorite').click(function(e) {

		if ( $('i.icon-favorite_border', this).hasClass('icon-favorite_border') ) {
			$('i.icon-favorite_border', this).removeClass('icon-favorite_border').addClass('icon-favorite');
			$(this).addClass('active');
		} else {
			$('i.icon-favorite', this).removeClass('icon-favorite').addClass('icon-favorite_border');
			$(this).removeClass('active');
		}





		e.preventDefault();
	});


</script>



</body>

</html>
