<?php
/**
*@package  Joomla.plugin
*@subpackage Content.joomla
*
*/



defined('_JEXEC') or die;

class LinkprotectHelper
{
	public $params = null;
	public function __construct($params = null)
	{
		$this->params = $params;
	}



	public function replaceLink($matches)
	{

		$link = $matches[2];

		
		if (strpos($link, JURI::root())) {
			return $link;
		}else
		{
			$warningPage = $this->params->get('warning_page');
			$external = base64_encode($link);
			$newlink = 'href="'.JRoute::_(ContentHelperRoute::getArticleRoute($warningPage).'&external='.$external).'"';
			return $newlink;
		}

		
	}

	public function leaveSite($article,$external)
	{
		$target = $this->params->get('new_window') ? 'target="_blank"' : '' ;
		$link = base64_decode($external);
		$article->text = str_ireplace('{linkprotecturl}', '<a href="'.$link.'" '.$target.'>'.$link.'</a>', $article->text);
	}
}
?>