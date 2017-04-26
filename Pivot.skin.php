<?php

/**
 * Skin file for Pivot 
 *
 * @file
 * @ingroup Skins
 */
 

class SkinPivot extends SkinTemplate {
	public $skinname = 'pivot', $stylename = 'pivot', $template = 'pivotTemplate', $useHeadElement = true;

	public function setupSkinUserCss(OutputPage $out) {
		parent::setupSkinUserCss($out);
		global $wgPivotFeatures;
		$wgPivotFeaturesDefaults = array(
			'showActionsForAnon' => true,
			'fixedNavBar' => false,
			'usePivotTabs' => false,
			'showHelpUnderTools' => true,
			'showRecentChangesUnderTools' => true,
			'wikiName' => &$GLOBALS['wgSitename'],
			'wikiNameDesktop' => &$GLOBALS['wgSitename'],
			'navbarIcon' => false,
			'IeEdgeCode' => 1,
			'showFooterIcons' => false,
			'addThisPUBID' => '',
			'useAddThisShare' => '',
			'useAddThisFollow' => ''
		);
		foreach ($wgPivotFeaturesDefaults as $fgOption => $fgOptionValue) {
			if ( !isset($wgPivotFeatures[$fgOption]) ) {
				$wgPivotFeatures[$fgOption] = $fgOptionValue;
			}
		}
		switch ($wgPivotFeatures['IeEdgeCode']) {
			case 1:
				$out->addHeadItem('ie-meta', '<meta http-equiv="X-UA-Compatible" content="IE=edge" />');
				break;
			case 2:
				if (isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false))
					header('X-UA-Compatible: IE=edge');
				break;
		}
		$out->addModuleStyles('skins.pivot.styles');
	}

	public function initPage(OutputPage $out) {
		global $wgLocalStylePath;
		parent::initPage($out);

		$viewport_meta = 'width=device-width, user-scalable=yes, initial-scale=1.0';
		$out->addMeta('viewport', $viewport_meta);
		$out->addModuleScripts('skins.pivot.js');
	}

}


class pivotTemplate extends BaseTemplate {
	public function execute() {
		global $wgUser;
		global $wgPivotFeatures;
		wfSuppressWarnings();
		$this->html('headelement');
		switch ($wgPivotFeatures['usePivotTabs']) {
			case true:
			    ob_start();
				$this->html('bodytext');
				$out = ob_get_contents();
				ob_end_clean();
				$markers = array("&lt;a", "&lt;/a", "&gt;");
				$tags = array("<a", "</a", ">");
				$body = str_replace($markers, $tags, $out);
				break;	
			default:
				$body = '';
				break;
		}
		switch ($wgPivotFeatures['showFooterIcons']) {
			case true:
				$poweredbyType = "icononly";
				$poweredbyMakeType = 'withImage';
				break;
			default:
				$poweredbyType = "nocopyright";
				$poweredbyMakeType = 'withoutImage';
				break;	
		}

?>
<!-- START PIVOTTEMPLATE -->
		<div class="off-canvas-wrap docs-wrap" data-offcanvas="">
			<div class="inner-wrap">
				<?php if ($wgPivotFeatures['fixedNavBar'] != false) echo "<div class='fixed'>"; ?>
				<nav class="tab-bar hide-for-print">
					<section id="left-nav-aside" class="left-small show-for-small">
						<a class="left-off-canvas-toggle"><span id="menu-user"><i class="fa fa-navicon fa-lg"></i></span></a>
					</section>
					
					<section id="middle-nav" class="middle tab-bar-section">
						<h1 class="title"><a href="<?php echo $this->data['nav_urls']['mainpage']['href']; ?>">
					<span class="show-for-medium-up"><?php echo $wgPivotFeatures['wikiNameDesktop']; ?></span>
						<span class="show-for-small-only">
						<?php if ($wgPivotFeatures['navbarIcon'] != false) { ?>
							<img alt="<?php echo $this->text('sitename'); ?>" src="<?php echo $this->text('logopath'); ?>" style="max-width: 64px;height:auto; max-height:36px; display: inline-block; vertical-align:middle;">
								<?php } ?>
						<?php echo $wgPivotFeatures['wikiName']; ?></span></a></h1>
					</section>
					
					<section id="right-nav-aside" class="right-small">
					<a class="right-off-canvas-toggle"><span id="menu-user"><i class="fa <?php if ($wgUser->isLoggedIn()): ?>fa-user<?php else: ?>fa-navicon<?php endif; ?> fa-lg"></i></span></a>
					</section>
				</nav>
				<?php if ($wgPivotFeatures['fixedNavBar'] != false) echo "</div>"; ?>
				    <aside class="left-off-canvas-menu">
      					<ul class="off-canvas-list">
						
								<li class="has-form">
									<form action="/w/index.php" id="searchform-offcanvas" class="mw-search">
										<div class="row collapse">
											<div class="small-12 columns">
												<input type="search" name="search" placeholder="Search" title="Search [alt-shift-f]" accesskey="f" id="searchInput-offcanvas" autocomplete="off">
											</div>
										</div>
									</form>
								</li>
								
							<?php $this->renderSidebar() ?>
						</ul>
					</aside>
					
					<aside class="right-off-canvas-menu">
					  <ul class="off-canvas-list">
					<?php if ($wgUser->isLoggedIn()): ?>
						<li id="personal-tools"><label>Personal</label></li>
						<?php foreach ($this->getPersonalTools() as $key => $item) { echo $this->makeListItem($key, $item); } ?>
							<?php else: ?>
								<?php if (isset($this->data['personal_urls']['anonlogin'])): ?>
									<li><a href="<?php echo $this->data['personal_urls']['anonlogin']['href']; ?>"><?php echo wfMessage( 'login' )->text() ?></a></li>
								<?php elseif (isset($this->data['personal_urls']['login'])): ?>
									<li><a href="<?php echo htmlspecialchars($this->data['personal_urls']['login']['href']); ?>"><?php echo wfMessage( 'login' )->text() ?></a></li>
										<?php else: ?>
											<li><?php echo Linker::link(Title::newFromText('Special:UserLogin'), wfMessage( 'login' )->text()); ?></li>
								<?php endif; ?>
							<?php endif; ?>
					  </ul>
					</aside>

					<section id="main-section" class="main-section" <?php if ($wgPivotFeatures['fixedNavBar'] != false) echo "style='margin-top:2.8125em'"; ?>>
					
						<div id="page-content">
							
							<div id="mw-js-message" style="display:none;"></div>

							<div class="row">
								
								<div id="sidebar" class="large-2 medium-3 columns hide-for-small hide-for-print">
										<ul class="side-nav">
											<li class="name logo">
											<a href="<?php echo $this->data['nav_urls']['mainpage']['href']; ?>">
												<img alt="<?php echo $this->text('sitename'); ?>" src="<?php echo $this->text('logopath') ?>" style="max-width: 100%;height: auto;display: inline-block; vertical-align: middle;"></a>		
											</li>
											<li class="has-form">
												<form action="/w/index.php" id="searchform" class="mw-search">
													<div class="row collapse">
														<div class="small-12 columns">
															<input type="search" name="search" placeholder="Search" title="Search [alt-shift-f]" accesskey="f" id="searchInput" autocomplete="off">
														</div>
													</div>
												</form>
											</li>
								
											<?php $this->renderSidebar() ?>
										</ul>
								</div>
								
								<div id="p-cactions" class="large-10 medium-9 columns">
								
									<div class="row">
										<div class="large-12 columns">
												<!-- Output page indicators -->
												<?php echo $this->getIndicators(); ?>
												<!-- If user is logged in output echo location -->
												<?php if ($wgUser->isLoggedIn()): ?>
												<div id="echo-notifications">
												<div id="echo-notifications-alerts"></div>
												<div id="echo-notifications-messages"></div>
												<div id="echo-notifications-notice"></div>
												</div>
												<?php endif; ?>
												<!--[if lt IE 9]>
												<div id="siteNotice" class="sitenotice"><?php echo $this->text('sitename') . ' '. wfMessage( 'pivot-browsermsg' )->text(); ?></div>
												<![endif]-->

												<?php if ( $this->data['sitenotice'] ) { ?><div id="siteNotice" class="sitenotice"><?php $this->html( 'sitenotice' ); ?></div><?php } ?>
												<?php if ( $this->data['newtalk'] ) { ?><div id="usermessage" class="newtalk"><?php $this->html( 'newtalk' ); ?></div><?php } ?>
										</div>
									</div>
								
									<?php if ($wgUser->isLoggedIn() || $wgPivotFeatures['showActionsForAnon']): ?>
										<a href="#" data-options="align:left" data-dropdown="drop1" class="button secondary small radius pull-right hide-for-print" id="drop"><i class="fa fa-navicon fa-lg"><span id="page-actions" class="show-for-medium-up">&nbsp;<?php echo wfMessage( 'actions' )->text() ?></span></i></a>
										<ul id="drop1" class="tiny content f-dropdown" data-dropdown-content>
											<?php foreach($this->data['content_actions'] as $key => $tab) { echo preg_replace(array('/\sprimary="1"/', '/\scontext="[a-z]+"/', '/\srel="archives"/'),'',$this->makeListItem($key, $tab)); } ?>
											<?php wfRunHooks( 'SkinTemplateToolboxEnd', array( &$this, true ));  ?>
										</ul>

									<?php endif;
									$namespace = str_replace('_', ' ', $this->getSkin()->getTitle()->getNsText());
									$displaytitle = $this->data['title'];
									if (!empty($namespace)) {
										$pagetitle = $this->getSkin()->getTitle();
										$newtitle = str_replace($namespace.':', '', $pagetitle);
										$displaytitle = str_replace($pagetitle, $newtitle, $displaytitle);
									?><h4 class="namespace label"><?php print $namespace; ?></h4><?php } ?>
									<div id="content">
									<h2 class="title"><?php print $displaytitle; ?></h2>
											<?php if ($wgPivotFeatures['useAddThisShare'] !== '') { ?>
											<!-- Go to www.addthis.com/dashboard to customize your tools -->
											<div class="<?php echo $wgPivotFeatures['useAddThisShare']; ?> hide-for-print"></div>
											<!-- Go to www.addthis.com/dashboard to customize your tools -->
											<?php } ?>
									<?php if ( $this->data['isarticle'] ) { ?><h3 id="tagline"><?php $this->msg( 'tagline' ) ?></h3><?php } ?>
									<h5 id="sitesub" class="subtitle"><?php $this->html('subtitle') ?></h5>
									<div id="contentSub" class="clear_both"></div>
									<div id="bodyContent" class="mw-bodytext">
									<?php 
									switch ($wgPivotFeatures['usePivotTabs']) {
										case true:
											echo $body;
											break;
										default:
										$this->html('bodytext');
											break;
											}
									?>
									<div class="clear_both"></div>
									</div>
									</div>
									<div id="categories" class="row">
										<div class="small-12 columns">
											<div class="group"><?php $this->html('catlinks'); ?></div>
											<?php $this->html('dataAfterContent'); ?>
										</div>
									</div>	
													
									<footer class="row">

										<div id="footer">
											<div id="footer-left" class="small-12 medium-8 large-9 columns">
											<ul id="footer-left">
												<?php foreach ($this->getFooterLinks("flat") as $key) { ?>
													<li id="footer-<?php echo $key ?>"><?php $this->html($key) ?></li>
												<?php } ?>									
											</ul>
											</div>	
											<div id="footer-right-icons" class="small-12 medium-4 large-3 columns hide-for-print">
											<ul id="footer-right">
												<li class="social-follow hide-for-print">
													<?php if ($wgPivotFeatures['useAddThisFollow'] !== '') { ?>
														<div class="social-links">
															<!-- Go to www.addthis.com/dashboard to customize your tools -->
															<div class="<?php echo $wgPivotFeatures['useAddThisFollow']; ?> hide-for-print"></div>
														</div>
													<?php } ?>
												</li>
												<?php foreach ($this->getFooterIcons($poweredbyType) as $blockName => $footerIcons) { ?>
													<li class="<?php echo $blockName ?>"><?php foreach ($footerIcons as $icon) { ?>
														<?php echo $this->getSkin()->makeFooterIcon($icon, $poweredbyMakeType); ?>
														<?php } ?>
													</li>
												<?php } ?>
											</ul>
											</div>		
										</div>			
									</footer>
								
								</div>
						</div>
					</div>
						
				</section>
				
			</div>
			</div>
			<a class="exit-off-canvas"></a>	
		</div>

		
		<?php $this->printTrail(); ?>

			<?php if ($this->data['isarticle'] && $wgPivotFeatures['addThisPUBID'] !== '') { ?>
				<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=<?php echo $wgPivotFeatures['addThisPUBID']; ?>" async="async">></script>
			<?php } ?>	
		</body>
		</html>

<?php
		wfRestoreWarnings();
		
	}
	
	function renderSidebar() { 
		$sidebar = $this->getSidebar();
		$toolbox = $this->getToolbox();
		foreach ($sidebar as $boxName => $box) { if ( ($box['header'] != wfMessage( 'toolbox' )->text()) ) { 
			echo '<li id='.Sanitizer::escapeId( $box['id'] ); Linker::tooltip( $box['id'] ).'>';
			echo '<li><label>'.htmlspecialchars( $box['header'] ).'</label></li>';
					if ( is_array( $box['content'] ) ) {
							foreach ($box['content'] as $key => $item) { echo $this->makeListItem($key, $item); }
								} }
									}
			echo '<li><label>Toolbox</label></li>';
					foreach ($toolbox as $key => $tbitem) { echo $this->makeListItem($key, $tbitem); }
		}	
}
?>
