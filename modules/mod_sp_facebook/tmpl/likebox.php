<?php
/*---------------------------------------------------------------
# SP Facebook - All in one facebook module for joomla
# ---------------------------------------------------------------
# Author - JoomShaper http://www.joomshaper.com
# Copyright (C) 2010 - 2013 JoomShaper.com. All Rights Reserved.
# license - PHP files are licensed under  GNU/GPL V2
# Websites: http://www.joomshaper.com
-----------------------------------------------------------------*/
// no direct access
defined('_JEXEC') or die('Restricted access');

echo '<div id="fb-root"></div>';
echo '<div class="fb-like-box" data-href="'.$likebox_url.'" data-width="'.$likebox_width.'" data-height="'.$likebox_height.'" data-show-faces="'.$likebox_showfaces.'" colorscheme="'.$likebox_colorscheme.'" data-stream="'.$likebox_stream.'" data-show-border="'.$likebox_show_border.'" data-header="'.$likebox_header.'"></div>';