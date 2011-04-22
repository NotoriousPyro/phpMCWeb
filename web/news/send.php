<?php

/**
 * Tell a friend feature
 *
 * @package FusionNews
 * @copyright (c) 2006 - 2010, FusionNews.net
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL 3.0 License
 * @version $Id: send.php 340 2010-12-07 11:44:16Z xycaleth $
 *
 * This file is part of Fusion News.
 *
 * Fusion News is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.

 * Fusion News is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Fusion News.  If not, see <http://www.gnu.org/licenses/>.
 */

if ( !defined ('FNEWS_ROOT_PATH') )
{
	/**@ignore*/
	define ('FNEWS_ROOT_PATH', str_replace ('\\', '/', dirname (__FILE__)) . '/');
	include_once FNEWS_ROOT_PATH . 'common.php';
}

$id = ( isset ($VARS['fn_id']) ) ? (int)$VARS['fn_id'] : 0;
$action = ( isset ($VARS['fn_action']) ) ? $VARS['fn_action'] : '';

ob_start();

if ( !file_exists (FNEWS_ROOT_PATH . 'news/news.' . $id . '.php') )
{
    echo $com11;
    exit;
}

if ( !$action )
{
    $session_id = create_security_id();

    $file = file (FNEWS_ROOT_PATH."news/news.".$id.".php");
    $news_info = parse_news_to_view ($file[1]);

    //replace user variables
    $tem = get_template('sendtofriend_temp.php', TRUE);
    $tem = '<script src="' . $furl . '/jsfunc.js" type="text/javascript"></script>' . "\n" . $tem;
    $tem = replace_masks ($tem, array (
        'post_id'	=> $news_info['post_id'],
        'subject'	=> $news_info['subject'],
        'user'	=> $news_info['writer'],
        'date'	=> $news_info['date'],
        'news'	=> $news_info['news'],
        'icon'	=> $news_info['icon'],
        'nrc'		=> $news_info['nrc'],
        'com'		=> $news_info['link_comments'],
        'fullstory'	=> $news_info['fullnews'],
        'cat_name'	=> $news_info['cat_name'],
        'cat_id'	=> $news_info['cat_id'],
        'cat_icon'	=> $news_info['cat_icon'],
    ));

    $qs = clean_query_string();

    $tem = str_replace ('[form]', '<form action="?fn_mode=send&amp;fn_action=send&amp;fn_id=' . $id . $qs . '" method="post" id="newsposting">', $tem);
    $tem = str_replace ('[/form]', '</form>', $tem);
    $tem = str_replace ('[buttons]', '<input type="hidden" name="confirm_id" value="' . $session_id . '" />
<input type="submit" value="' . $ind125 . '">&nbsp;<input type="reset" value="' . $ind16 . '">', $tem);
    $tem = preg_replace ('/\[sendnamefld,\s*([0-9]+)\]/', '<input type="text" size="\\1" name="sender_name" />', $tem);
    $tem = preg_replace ('/\[recnamefld,\s*([0-9]+)\]/', '<input type="text" size="\\1" name="friend_name" />', $tem);
    $tem = preg_replace ('/\[sendmailfld,\s*([0-9]+)\]/', '<input type="text" size="\\1" name="sender_email" />', $tem);
    $tem = preg_replace ('/\[recmailfld,\s*([0-9]+)\]/', '<input type="text" size="\\1" name="friend_email" />', $tem);
    
    if ( !isset ($stf_captcha) || $stf_captcha )
	{
        generate_captcha_code ($session_id, $id, get_ip(), 'send');
		$tem = str_replace ('[securityimg]', '<img src="' . $furl . '/captcha.php?fn_type=send&amp;fn_id=' . $id . '&amp;fn_sid=' . $session_id . '&amp;t=' . time() . '" alt="CAPTCHA" id="captcha" />', $tem);
		$tem = str_replace ('[securityfld]', '<input type="text" name="code" size="5" maxlength="5" />', $tem);
	}
	else
	{
		$tem = str_replace ('[securityimg]', '', $tem);
		$tem = str_replace ('[securityfld]', '', $tem);
	}

    $tem = preg_replace ('/\[mesfld,\s*([0-9]+),\s*([0-9]+)\]/', '<textarea name="message" cols="\\1" rows="\\2"></textarea>', $tem);

    echo $tem;
}

//send mail
else if ( $action == 'send' )
{
	$name = ( isset ($VARS['sender_name']) ) ? ltrim ($VARS['sender_name']) : '';
	$friend_name = ( isset ($VARS['friend_name']) ) ? ltrim ($VARS['friend_name']) : '';
	$email = ( isset ($VARS['sender_email']) ) ? ltrim ($VARS['sender_email']) : '';
	$friend_email = ( isset ($VARS['friend_email']) ) ? ltrim ($VARS['friend_email']) : '';
	$message = ( isset ($VARS['message']) ) ? html_entity_decode ($VARS['message']) : '';
    $captcha_code = (isset ($VARS['code']) ) ? $VARS['code'] : '';
    $confirm_id	= ( isset ($VARS['confirm_id']) ) ? $VARS['confirm_id'] : '';

	if ( (!isset ($stf_captcha) || $stf_captcha) && !is_valid_captcha_code ($captcha_code, $confirm_id, $id, 'send') )
    {
        echo $com13;
    }
    else if ( !$name || !$friend_name || !$email || !$friend_email || !$message )
	{
		echo $error23;
	}
	else if ( !is_valid_email ($email) || !is_valid_email ($friend_email) )
	{
		echo $snd7;
	}
	else
	{
		$file = file (FNEWS_ROOT_PATH . 'news/news.' . $id . '.php');
		$news_info = get_line_data ('news', $file[1]);

		$subject = "$snd0 $friend_name, $snd1";
		$message =
<<< html
$friend_name,

========================================
$message
========================================

$name $snd2 {$news_info['headline']}.
$snd3 {$furl}/fullnews.php?fn_id=$id

========================================
$snd8 {$hurl}

html;

        $message = prepare_string_for_mail ($message);

		$headers = 'From: ' . $email . "\n";
		$headers .= 'Reply-To: ' . $email . "\n";
		$headers .= 'Content-Type: text/plain' . "\n";
		$headers .= 'Mime-Version: 1.0' . "\n";
		$headers .= 'X-Mailer: PHP/' . phpversion() . "\n";
		$headers .= 'X-AntiAbuse: Sent From - ' . $site . "\n";
		$headers .= 'X-AntiAbuse: Sender IP - ' . get_ip() . "\n";

		if ( @mail ($friend_email, $subject, $message, $headers) )
		{
			echo $snd4 . ' ' . $friend_email . '.<br /><a href="javascript:history.go (-2)">' . $snd5 . '</a>';
		}
		else
		{
			echo $snd6;
		}
	}
}

ob_end_flush();

?>