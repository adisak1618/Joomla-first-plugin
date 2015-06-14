<?php
/**
*@package Joomla.Plugin
*@subpackage Content.joomla
*
*@copyright Copyright (C) 2013 Adisak Chaiyakul. All right reserved.
*/


defined('_JEXEC') or die;


/**
* Linkprotect Content Plugin
*
*@package Joomla.Plugin
*@subpackage Content.joomla
*/
class PlgContentLinkprotect extends Jplugin
{
	private $callbackFunction;
	public function __construct(&$subject, $config = array())
	{
		parent::__construct($subject,$config);
		require_once  '/helper/helper.php';
		$helper = new LinkProtectHelper($this->params);
		$this->callbackFunction =  array($helper,'replaceLink' );
	}

	public function onContentBeforeDisplay($context,$article,$params)
	{
		$parts = explode(".", $context);
		if($parts[0] != "com_content")
		{
			return;
		}

	

		$app = JFactory::getApplication();
		$external = $app->input->get('external',NULL);

		if($external)
		{
			LinkProtectHelper::leaveSite($article,$external);
		}else
		{
			
			$pattern = '@href=("|\')(https?://([-\w\.]+)+(:\d+)?(/([\w/_\.]*(\?\S+)?)?)?)("|\')@';
			
			$article->text = preg_replace_callback($pattern, $this->callbackFunction, $article->text);
		}
		
		//$article->text =$article->text.base64_decode($external).$pattern[1].JUri::root();
		//$article->text = JURI::root()."oat".var_dump(get_object_vars($app->input));
	}

}

?>