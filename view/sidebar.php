<?php

/**
 * Pivot Skin
 *
 * @file Builds the Sidebar reducing code duplication
 * @since Version 1.0
 * @ingroup Skins
 * @author Tom Hutchison
 * @license 2-clause BSD
 */

if ( ! defined('MEDIAWIKI'))
{
	die("Not Directly Called So What Are You Doing?");
}
		
	foreach ($this->getSidebar() as $boxName => $box) { if (($box['header'] != wfMessage('toolbox')->text())) { ?>
		<li id='<?php echo Sanitizer::escapeId($box['id']) ?>'<?php echo Linker::tooltip($box['id']) ?>>
			<li><label><?php echo htmlspecialchars($box['header']); ?></label></li>
				<?php if (is_array($box['content'])) { ?>
						<?php foreach ($box['content'] as $key => $item) { echo $this->makeListItem($key, $item); } ?>
							<?php } } ?>
								<?php } ?>
			<li><label>Toolbox</label></li>
				<?php foreach ($this->getToolbox() as $key => $item) { echo $this->makeListItem($key, $item); } ?>