<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<title>Tundra News</title>
		<?php echo get_style('dashboard.core.css'); ?>
		<?php echo get_style('dashboard.core.widget.css'); ?>
		<?php echo get_style('themes/' . $profile['theme']['directory'] . '/styles/theme.css'); ?>
	</head>
	<body><div id="super-container">
		<!-- Bar -->
		<div id="bar"><div class="wrapper">
			<div id="bar-left"><strong>Tundra</strong> &nbsp;&nbsp;&nbsp;<?php echo tagline(); ?></div>
			<div id="bar-right">
				<span id="clock"></span>
				<?php echo anchor('news', 'News'); ?>
				<?php echo anchor('settings', 'Settings'); ?>
				<?php echo anchor('auth/logout', 'Logout');?>
			</div>
			
			<div class="clear"></div>
		</div></div>
		<!-- /Bar -->
	
		<!-- Header -->
		<div id="header"><div class="wrapper">
			<div id="header-left"></div>
			<div id="header-right"></div>
			
			<form method="get" action="<?php echo $profile['search_engine']['action']; ?>">
				<input type="text" name="<?php echo $profile['search_engine']['modifier']; ?>" placeholder="Search <?php echo $profile['search_engine']['name']; ?>..." />
			</form>
			
			<div class="clear"></div>
		</div></div>
		<!-- /Header -->

		<!-- Tabs -->
		<div id="tabs"><div class="wrapper">
			<ul>
				<?php
					foreach($tabs as $tab)
						echo '<li' . ($tab['name'] == ucfirst($this->uri->rsegment(3)) ? ' id="active" ' : '') . '>' . anchor('dashboard/' . strtolower($tab['name']), $tab['name']) . '</li>';
				?>
			</ul>
		</div></div>
		<!-- /Tabs -->
	
		<!-- Content -->
		<div id="content"><div class="wrapper news">
			<!--<h1>Tuesday, October 4th - Welcome!</h1>-->
			<p>
				<?php echo get_image('welcome.logo.png', 'Tundra logo', 'float-left'); ?>
				Hi <?php echo $username; ?>! Welcome to what will become the place where you can get all the latest news on Tundra. I figure over the next couple of weeks Tundra development is going to get a bit more
				lively than it has been in the last couple of weeks, so this is where I'll post any updates regarding any changes that I'll be implementing and how they'll effect you. Over the next
				couple of weeks, I hope to move Tundra from a project that was developed for me to a product that anyone can use.
			</p>
			
			<h1>New Features</h1>
			<p>
				There's a couple of major new features that I plan to add. Some of them are fairly obvious, and some of them aren't.
				
				<ul>
					<li>
						<span class="title">Adding and configuring your own widgets and tabs</span>
						I think this one's a bit of a no-brainer. I can't be bothered with editing the database anymore, it's too much of a hastle. This will be the first feature implemented.
					</li>
					
					<li>
						<span class="title">Command bar</span>
						See that search bar up top? Right now, it searches the search engine of your choosing (if you tell me, it's not changable in the UI yet!). This is going to change. I've used a
						program on my laptop called <a href="http://www.alfredapp.com/" target="_blank">Alfred</a> for a while now and it's really great. I hope to introduce some Alfred-style
						functionality to Tundra, so you'll be able to type in "g telephone" and it'll search Google for "telephone", or "yt charlie" to search YouTube for "charlie" and the like. What I
						don't intend on doing is re-implementing the whole of Alfred - it's not appropriate for a web interface, Alfred is an excellent piece of software and
					</li>
					
					<li>
						<span class="title">View history</span>
						For RSS widgets, I want to implement some functionality to log what you've viewed so when logged in between multiple devices, Tundra can keep track of what you've already seen.
						Sadly, this will require me to keep a log of what you've been on which I don't really want to do (for privacy reasons) so this feature will be completely optional and you will be
						<em>opted-out by default</em>. At no point will you ever be required to use this feature, nor will you have a degraded experience for not doing so.
					</li>
					
					<li>
						<span class="title">Better iframes</span>
						I'd like iframes to resize themselves vertically to fit the amount of content within them. It's a bigger task than it sounds (there's some issues with cross-domain requests
						and other security stuff like that)
					</li>
					
					<li>
						<span class="title">Reddit browser</span>
						I've had (what I think is) a nifty idea for a Reddit browser so I'm working on that as well.
					</li>
					
					<li>
						<span class="title">Mobile app</span>
						As nice (ahem) as the web interface is, it doesn't really scale down well onto mobile devices. Eventually, I want to get round to writing a mobile app that will at least support
						iOS and potentially as much as iOS, Android and Windows Phone 7. It <em>may</em> also run on BlackBerry, webOS, Symbian and Bada but don't hold your breath (if it does, it'll
						likely be untested). What is this magic? <a href="http://phonegap.com" target="_blank">PhoneGap</a>.
					</li>
				</ul>
			</p>
			
			<h1>Open registrations are coming</h1>
			<p>
				Right now, Tundra  is by invite only (i.e., I'll ask you if you want to check it out). This will change once the features mentioned above have been implemented, along with a
				<?php echo anchor('welcome', 'fancier welcome page'); ?>. Not that Tundra's gonna get a butt-load of new users, but if required I'll keep it fairly low-key at least for a couple of weeks
				so I can work out any other kinks and bugs.
			</p>
			
			<h1>Privacy and Tundra</h1>
			<p>
				<strong>Tundra does NOT track you any more than a normal website.</strong> Tundra itself doesn't keep any logs (the closest is a a part of the database for storing automatic logins)
				at all and this will never change. The server keeps access logs and some analytics (IP addresses, <em>very</em> rough geographic data, user agents and the like) but this is a standard
				practise in the industry, and 99.999% (my estimate) of all sites will keep very similar data, if not a little more.
			</p>
			
			<h1>Browser support</h1>
			<p>
				<?php echo get_image('html5.png', 'HTML5 + CSS3', 'float-html'); ?>
				Tundra uses the latest web standards (HTML5 placeholders, CSS columns and the like) to make not only development easier for me but also a better experience for you, the user. Using the
				latest web technologies lets me add new features much quicker than if I hadn't used HTML5. For this reason, Tundra requires a modern browser and this isn't ever going to change.
			</p>
			
			<p>
				I test Tundra on the latest versions of Safari, Chrome, Firefox and Opera. I do <em>not</em> test on Internet Explorer, as I don't have easy access to it, and anyone who's going to be
				using Tundra isn't going to be on IE anymore. I'll try to maintain compatability for x - 1 versions, where x is the latest version of browsers. This shouldn't be too much of a big deal
				for most people - Firefox and Chrome are on some crazy "lets-bump-the-major-version-every-6-weeks" release schedule now (which does everything automatically). Safari isn't updated as much
				but it's almost (iirc) as good as Chrome in support for web standards. As far as Opera goes - I know there's some issues with Tundra on Opera right now, and I'm working on them.
			</p>
		
			<h1>Ask not what Tundra can do for you, ask what you can do for Tundra!</h1>
			<p>
				Basically, if you see any bugs (for example, the BBC widget doesn't display images) or feature requests (for example, a new widget type) just 
				<a href="http://bugs.projects.chrisatk.in" target="_blank">file a bug report</a> and I'll get round to fixing/implementing it as soon as I can.
			</p>
			
			<h1>Summary</h1>
			<p>
				The main point that I want you to take away from this is that Tundra is moving away from a project that was developed exclusively for myself to a product that I hope can be used by many.
				I (of course) think Tundra is cool, and I want to share it with the world. I'm not going to say that it's better than iGoogle because it isn't, but it's not meant to be. Google 
				has a very strong developer community creating thousands of widgets, but the vast majority of them aren't - <em>in my opinion</em> - very good. I'd rather Tundra implement a subset of the
				features of iGoogle if each of those features is better than the equivalent iGoogle feature.
			</p>
			
			<p>
				Lastly, <strong>if you notice any bugs, <a href="http://bugs.projects.chrisatk.in" target="_blank">file a bug report</a>!</strong>
			</p>
		</div></div>
		<!-- /Content -->
		
		<!-- Footer -->
		<div id="footer"><div class="wrapper">
			<div id="footer-left">
				<strong>Chris Atkin-Granville &copy; 2011</strong>
			</div>
			<div id="footer-right">
				<ul>
					<li><a href="http://chrisatk.in" target="_blank">Chris Atkin-Granville &raquo;</a></li>
					<li><a href="http://bugs.projects.chrisatk.in" target="_blank">Report Bugs &raquo;</a></li>
					<li><a href="http://chrisatk.in/project.php?id=tundra" target="_blank">Project Page &raquo;</a></li>
				</ul>
			</div>
			
			<div class="clear"></div>
		</div></div>
		<!-- /Footer -->
	</div></body>
	<?php
		echo get_script('mt.core.js');
		echo get_script('mt.more.js');
		echo get_script('tundra.support.js');
		echo get_script('tundra.core.js');
		echo '<script type="text/javascript" src="'. site_url('helper/script/init?tab=' . $this->uri->rsegment(3)).'"></script>';
	?>
</html>
