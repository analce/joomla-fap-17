<?php
/**
* @version      $Id: accesskey_helper.php 113 2010-05-31 15:40:33Z elpaso $
* @package      JoomlaFAP
* @copyright    Copyright (C) 2008 Alessandro Pasotti
* @license      GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/


// no direct access
defined('_JEXEC') or die('Restricted access');


if ( ! defined('modMainMenuXMLCallbackDefinedAK') )
{
    function modMainMenuXMLCallbackAK(&$node, $args)
    {
        $user   = &JFactory::getUser();
        $menu   = &JSite::getMenu();
        $active = $menu->getActive();
        $path   = isset($active) ? array_reverse($active->tree) : null;

        if (($args['end']) && ($node->attributes('level') >= $args['end']))
        {
            $children = $node->children();
            foreach ($node->children() as $child)
            {
                if ($child->name() == 'ul') {
                    $node->removeChild($child);
                }
            }
        }

        if ($node->name() == 'ul') {
            foreach ($node->children() as $child)
            {
                if ($child->attributes('access') > $user->get('aid', 0)) {
                    $node->removeChild($child);
                }
            }
        }

        if (($node->name() == 'li') && isset($node->ul)) {
            $node->addAttribute('class', 'parent');
        }

        if (isset($path) && in_array($node->attributes('id'), $path))
        {
            if ($node->attributes('class')) {
                $node->addAttribute('class', $node->attributes('class').' active');
            } else {
                $node->addAttribute('class', 'active');
            }
        }
        else
        {
            if (isset($args['children']) && !$args['children'])
            {
                $children = $node->children();
                foreach ($node->children() as $child)
                {
                    if ($child->name() == 'ul') {
                        $node->removeChild($child);
                    }
                }
            }
        }


        // ABP: FAP access key
        if (array_key_exists($node->attributes('id'), $menu->_items)) {
            $accesskey = $menu->_items[$node->attributes('id')]->accesskey;
            $title = $menu->_items[$node->attributes('id')]->title;
        }

        if (($node->name() == 'li') && ($id = $node->attributes('id'))) {
            if ($node->attributes('class')) {
                $node->addAttribute('class', $node->attributes('class').' item'.$id);
            } else {
                $node->addAttribute('class', 'item'.$id);
            }
        }

        if (isset($path) && $node->attributes('id') == $path[0]) {
            $node->addAttribute('id', 'current');
        } else {
            $node->removeAttribute('id');
        }
        $node->removeAttribute('level');
        $node->removeAttribute('access');

        //ABP: accesskey
        if ($node->name() == 'li'){
            foreach ($node->children() as   $c){
                // ABP: FAP access key, Fix #20542
                if((isset($accesskey)) && ($c->name()!='ul')){
                    $c->addAttribute('accesskey', $accesskey);
                }
                if((isset($title)) && ($c->name()!='ul')){
                    $c->addAttribute('title', $title);
                }
             }
            $node->removeAttribute('rel');
        }
		//ABP: Remove blank
		if($node->attributes('target') == '_blank'){
			$node->removeAttribute('target');
			$node->addAttribute('onclick', 'window.open(this.href, \'_blank\');return false;');
			$node->addAttribute('onkeypress', 'window.open(this.href, \'_blank\');return false;');
		}

    }

    define('modMainMenuXMLCallbackDefinedAK', true);
}
modMainMenuHelper::render($params,'modMainMenuXMLCallbackAK' );
?>