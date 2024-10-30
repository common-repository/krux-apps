<?php global $kx_confid; ?>
<?php global $kx_pubid; ?>
<div class='kwp-main-wrapper'>
	<?php include(KRUX_PLUGIN_VIEWS . "header.php"); ?>

	<div class='kwp-content'></div>

	<!-- -=Need account -->
	<div class='kwp-hidden' id='kwpNeedAccount'>
		<h1>Getting Started</h1>
		<h2>Step 1</h2>
		<p>
			Sign up for Krux Apps at the following link: <br />
			<a target='_blank' href='http://dataconsole.kruxdigital.com/apps_accounts/register/'>http://dataconsole.kruxdigital.com/apps_accounts/register/</a>
		</p>
		<h2>Step 2</h2>
		<p>
			Once signed up, copy and paste your configuration id from the following link: <br />
			<a target='_blank' href='http://dataconsole.kruxdigital.com/krux_apps/confid'>http://dataconsole.kruxdigital.com/krux_apps/confid</a><br />
			<form method='post' action=''>
				<input type='text' name='confid' />&nbsp;<button>Submit Id</button>
			</form>
		</p>
	</div>

	<!-- -=Sign Up message -->
	<div class='kwp-hidden' id='kwpSignUpMessage'>
		To get the mose out of Krux Apps, <a href='#'>Sign Up Now!</a>
	</div>

	<!-- -=Have account -->
	<div class='kwp-hidden' id='kwpHaveAccount'>
		<h1>Getting Started</h1>
		<p>
			Copy and paste your configuration id from the following link: <br />
			<a target='_blank' href='http://dataconsole.kruxdigital.com/krux_apps/confid'>http://dataconsole.kruxdigital.com/krux_apps/confid</a><br />
			<form method='post' action=''>
				<input type='text' name='confid' />&nbsp;<button>Submit Id</button>
			</form>
		</p>
	</div>

	<!-- -=Getting started -->
	<div class='kwp-hidden' id='kwpGettingStarted'>
		<h1>Getting Started</h1>
		<p>
			First, we need to make sure you're set up with Krux Apps.
			Don't worry, we'll get you setup in minutes.
		</p>
		<button id='kwpHaveAccountBtn'>I have a Krux Apps account</button>
		<button id='kwpGetAccountLaterBtn'>Sign up for Krux Apps later</button>
	</div>

	<!-- -=Social widget configuration -->
	<div class='kwp-hidden' id='kwpSocial'>
		<h1>Social Widget Settings</h1>
		<!--
		<p class='kwp-hidden' id='signupMessage'>
			To access social analytics and more free apps, <a href='http://www.krux.com/apps/signup/' target='_blank'>sign up now!</a>
		</p> -->
		<p class='kwp-hidden' id='signupMessage'>
			To access social analytics and more free apps, get a free account by sending us your info!
			<form enctype="text/plain" method="post" action="mailto:appshelp@krux.com">
				Email: <input type='email' name='email' />
				Url: <input type='text' name='url' />
				<input type='hidden' name='request_type' value='This is an account request from the Krux Wordpress plugin' />
				<input type='hidden' name='pub_uuid' value='<?php echo $kx_pubid ?>' />
				<input type='submit' value='Send' />
			</form>
		</p>
		<p class='kwp-hidden' id='loginMessage'>
			Login to your Krux Apps account to access social analytics and more free apps.
			<a href='http://dataconsole.kruxdigital.com/krux_apps' target='_blank'>View your Krux Apps account</a>
		</p>
		<div class='kwp-input-section'>
			<div class='kwp-input-row'>
				<label>Status</label>
				<div class='kwp-input-content config_status'>
					<input type='radio' name='enabled' value='1' />
					<label>Enabled</label><br />
					<input type='radio' name='enabled' value='0' />
					<label>Disabled</label>
				</div>
			</div>
			<div class='kwp-input-row'>
				<label>Location</label>
				<div class='kwp-input-content'>
					<input type='checkbox' name='location' class='locationChoice' value='posts' id='locationPosts' />
					<label>Posts</label><br />
					<input type='checkbox' name='location' class='locationChoice' value='pages' id='locationPages' />
					<label>Pages</label>
				</div>
			</div>
			<div class='kwp-input-row'>
				<label>Sharing Options and Platform</label>
				<div class='kwp-input-content kwp-social-options'>
					<div class='kwp-left'>
						<input name='socnetwork' type='checkbox' value='facebook' id='fbchoice' />
						<label for='fbchoice'>
							<img src='<?php echo KRUX_IMAGES . 'fb_icon.png' ?>' />
						</label>
					</div>
					<div class='kwp-left'>
						<input name='socnetwork' type='checkbox' value='twitter' id='twchoice' />
						<label for='twchoice'>
							<img src='<?php echo KRUX_IMAGES . 'tw_icon.png' ?>' />
						</label>
					</div>
					<div class='kwp-left'>
						<input name='socnetwork' type='checkbox' value='google' id='gpchoice' />
						<label for='gpchoice'>
							<img src='<?php echo KRUX_IMAGES . 'gp_icon.png' ?>' />
						</label>
					</div>
					<div class='kwp-left'>
						<input name='socnetwork' type='checkbox' value='pinterest' id='pinchoice' />
						<label for='pinchoice'>
							<img src='<?php echo KRUX_IMAGES . 'pinterest_icon.png' ?>' />
						</label>
					</div>
					<div class='kwp-left'>
						<input name='socnetwork' type='checkbox' value='linkedin' id='lichoice' />
						<label for='lichoice'>
							<img src='<?php echo KRUX_IMAGES . 'linked_in_icon.png' ?>' />
						</label>
					</div>

				</div>
			</div>
			<div class='kwp-input-row'>
				<label>Configuration</label>
				<div class='kwp-input-content'>
					<div class='kwp-config-table-wrapper'>
						<table class='kwp-config-table'>
							<tr>
								<th></th>
								<th>Pages</th>
								<th>Posts</th>
							</tr>
							<tr>
								<td class='kwp-label'>Format</td>
								<td>
									<select name='format' class='format_choice' id='pagesFormat' data-location='Pages'>
										<option value='article_style'>Article - vertical</option>
										<option value='article_horizontal'>Article - horizontal</option>
										<option value='big_button'>Big button</option>
										<option value='single_button'>Single button</option>
									</select>
								</td>
								<td>
									<select name='format' class='format_choice' id='postsFormat' data-location='Posts'>
										<option value='article_style'>Article - vertical</option>
										<option value='article_horizontal'>Article - horizontal</option>
										<option value='big_button'>Big button</option>
										<option value='single_button'>Single button</option>
									</select>
								</td>
							</tr>
							<tr>
								<td class='kwp-label'>Placement</td>
								<td class='kwp-placement-wrapper'>
									<input type='radio' name='page_placement' value='top' />
									<label>Top of page</label><br />
									<input type='radio' name='page_placement' value='bottom' />
									<label>Bottom of page</label><br />
									<input type='radio' name='page_placement' value='both' />
									<label>Top and bottom</label>
								</td>
								<td class='kwp-placement-wrapper'>
									<input type='radio' name='post_placement' value='top' />
									<label>Top of post</label><br />
									<input type='radio' name='post_placement' value='bottom' />
									<label>Bottom of post</label><br />
									<input type='radio' name='post_placement' value='both' />
									<label>Top and bottom</label>
								</td>
							</tr>
							<tr>
								<td class='kwp-label'>Preview</td>
								<td class='widget-container' id='widgetContainerPages'>
									<div class="krux_social" data-format="article_style"></div>
									<div class="krux_social" data-format="article_horizontal"></div>
									<div class="krux_social" data-format="big_button"></div>
									<div class="krux_social" data-format="single_button"></div>
								</td>
								<td class='widget-container' id='widgetContainerPosts'>
									<div class="krux_social" data-format="article_style"></div>
									<div class="krux_social" data-format="article_horizontal"></div>
									<div class="krux_social" data-format="big_button"></div>
									<div class="krux_social" data-format="single_button"></div>
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div><!-- .kwp-input-seciton -->
	</div>

</div>

<script>
	window.KWP = window.KWP || {};
	window.KWP.confid = '<?php echo $kx_confid; ?>';
	window.KWP.pubid = '<?php echo $kx_pubid; ?>';
	jQuery('document').ready(function(){
		window.kwpRouter = new window.KWP.router;
		Backbone.history.start();
	});
</script>