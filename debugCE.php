<?php

# get correct id for plugin
$debugCE = basename(__FILE__, ".php");

# add in this plugin's language file
i18n_merge($debugCE) || i18n_merge($debugCE, 'en_US');

# register plugin
register_plugin(
	$debugCE, 								# ID of plugin, should be filename minus php
	i18n_r($debugCE.'/lang_Menu_Title'), 	# Title of plugin
	'1.0', 									# Plugin version
	'islander',								# Plugin author
	'https://getsimple-ce.ovh/ce-plugins/', # Author URL
	i18n_r($debugCE.'/lang_Description'),	# Plugin Description
	'settings',								# Page type of plugin
	'debugCEmain' 							# Function that displays content
);

# Back-End Hooks
add_action('settings-sidebar', 'createSideMenu', array($debugCE, i18n_r($debugCE.'/lang_Menu_Title')));

# ===== Main Plugin Function =====
function debugCEmain(){
	global $SITEURL;
	global $USR;

	if (file_exists(GSDATAOTHERPATH . 'debugCE.json')) {
		$file = GSDATAOTHERPATH . 'debugCE.json';
		$fileData = json_decode(file_get_contents($file), true);
		$debug_toggle_ON = $fileData['debug_toggle_ON'];
	}

	echo '
	<link rel="stylesheet" href="'.$SITEURL.'plugins/debugCE/assets/w3.css">
	
	<style>
		/* The switch - the box around the slider */
		.switch {
		position: relative;
		display: inline-block;
		width: 60px;
		height: 34px;
		left: 0;
		}

		/* Hide default HTML checkbox */
		.switch input {
		opacity: 0;
		width: 0;
		height: 0;
		}

		/* The slider */
		.slider {
		position: absolute;
		cursor: pointer;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		background-color: #ccc;
		-webkit-transition: .4s;
		transition: .4s;
		}

		.slider:before {
		position: absolute;
		content: "";
		height: 26px;
		width: 26px;
		left: 4px;
		bottom: 4px;
		background-color: white;
		-webkit-transition: .4s;
		transition: .4s;
		}

		input:checked + .slider {background-color: #2196F3;}
		input:focus + .slider {box-shadow: 0 0 1px #2196F3;}
		input:checked + .slider:before {-webkit-transform: translateX(26px); -ms-transform: translateX(26px);transform: translateX(26px);}

		/* Rounded sliders */
		.slider.round {border-radius: 34px;}
		.slider.round:before {border-radius: 50%;} 
		ul li svg {vertical-align:middle;}
	</style>
	
	<div class="w3-parent w3-container">
		<h3>'.i18n_r("debugCE/lang_Page_Title").'</h3>
		<p>'.i18n_r("debugCE/lang_Description").'</p>
		
		<hr>

		<div class="w3-container">
			
			<form class="w3-container w3-padding-32" method="POST">
				
				<div class="w3-cell-row" >
					<div class="w3-cell w3-container w3-right-align"><h3 class="w3-text-grey"><b>'.i18n_r("debugCE/lang_Off").'</b></h3></div>
					
					<div class="w3-cell w3-container w3-center" style="width:60px;">
						<label class="switch">
							 <input type="checkbox" name="debug_toggle_ON" value="true" ' . (@$debug_toggle_ON == "true" ? 'checked' : '') . '> <span class="slider round"></span>
						</label>
					</div>
					
					<div class="w3-cell w3-container w3-left-align"><h3 class="w3-text-blue"><b>'.i18n_r("debugCE/lang_On").'</b></h3></div>
					
					<div class="w3-cell w3-container">
						<span style="margin-left: 15%;">
							<button class="w3-btn w3-large w3-round-large w3-green" xstyle="width:66.6%" name="savedebugCE">'.i18n_r("debugCE/lang_Save").'</button>
						</span>
					</div>
				</div>
				
			</form>
		</div>
		
		<div class="w3-opacity">
			<h4>'.i18n_r('SUPPORT').':</h4>
			<ul class="w3-ul w3-hoverable">
				<li> <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 24 24"><path fill="#333" d="M10 3L8 5v2H5C3.85 7 3.12 8 3 9L2 19c-.12 1 .54 2 2 2h16c1.46 0 2.12-1 2-2L21 9c-.12-1-.94-2-2-2h-3V5l-2-2zm0 2h4v2h-4zm1 5h2v3h3v2h-3v3h-2v-3H8v-2h3z"/></svg> <a href="health-check.php">'.i18n_r('WEB_HEALTH_CHECK').'</a></li>
				<li> <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 24 24"><path fill="#333" d="M13 8a4 4 0 0 1-4 4a4 4 0 0 1-4-4a4 4 0 0 1 4-4a4 4 0 0 1 4 4m4 10v2H1v-2c0-2.21 3.58-4 8-4s8 1.79 8 4m3.5-3.5V16H19v-1.5zm-2-5H17V9a3 3 0 0 1 3-3a3 3 0 0 1 3 3c0 .97-.5 1.88-1.29 2.41l-.3.19c-.57.4-.91 1.01-.91 1.7v.2H19v-.2c0-1.19.6-2.3 1.59-2.95l.29-.19c.39-.26.62-.69.62-1.16A1.5 1.5 0 0 0 20 7.5A1.5 1.5 0 0 0 18.5 9z"/></svg> <a href="log.php?log=failedlogins.log">'.i18n_r('VIEW_FAILED_LOGIN').'</a></li>
				<li> <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 24 24"><path fill="#333" d="M13 14h-2V9h2m0 9h-2v-2h2M1 21h22L12 2z"/></svg> <a href="log-error.php?log=errorlog.txt">'.i18n_r('VIEW').' ErrorLog</a></li>
				<li> <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 24 24"><path fill="#333" d="M13 9h-2V7h2m0 10h-2v-6h2m-1-9A10 10 0 0 0 2 12a10 10 0 0 0 10 10a10 10 0 0 0 10-10A10 10 0 0 0 12 2"/></svg> <a href="phpinfo.php">'.i18n_r('VIEW').' phpInfo</a></p></li>
			</ul>
		</div>
		
		<hr>
		
		<!-- Footer Start -->
		<div class="w3-opacity">
			<p>Made with <span class="credit-icon">❤️</span> especially for "<b>'.$USR.'</b>".<br>
			Is this plugin useful for you? <a href="https://www.paypal.com/donate/?hosted_button_id=C3FTNQ78HH8BE" target="_blank">Consider buying me a <span class="credit-icon">☕</span></a>.</p>
		</div>
	</div>
	';
	
	if (isset($_POST['savedebugCE'])) {
		$data = [];
		$data['debug_toggle_ON'] = isset($_POST['debug_toggle_ON']) ? "true" : "false";

		$finalData = json_encode($data);
		file_put_contents(GSDATAOTHERPATH . 'debugCE.json', $finalData);
		echo "<meta http-equiv='refresh' content='0'>";
	}
}

function rundebug() {
	$file = GSDATAOTHERPATH . 'debugCE.json';
	if (file_exists($file)) {
		$fileData = json_decode(file_get_contents($file), true);
		if (isset($fileData['debug_toggle_ON']) && $fileData['debug_toggle_ON'] == "true") {
			debug_show();
		}
	}
}

function debug_show() {
	define('GSDEBUG', TRUE);
	error_reporting(E_ALL | E_STRICT);
	ini_set('display_errors', 1);
}

add_action('header', 'rundebug', array());
add_action('index-pretemplate', 'rundebug', array());

/* ----------------
  (\ /)
  (^.^) -{hola)
 C(")(")
---------------- */