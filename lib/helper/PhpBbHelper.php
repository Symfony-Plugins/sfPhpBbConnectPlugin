<?php
use_helper('Date');
use_stylesheet('/sfPhpBbConnectPlugin/css/sf_phpbb_connect_plugin.css');
include_stylesheets();


/**
 * View last topics from the phpBB forum
 *
 * @param $maxTopics Number of topics to display
 * @return string HTML code
 * 
 * @package    sfPhpBbConnectPlugin
 * @subpackage helper
 * @author     Fabrizio Pucci <fabrizio.pucci.ge@gmail.com>
 * @version    SVN: $Id$
 */
function lastTopics($maxTopics)
{

  $topics =  Doctrine::getTable('PhpbbTopics')->lastTopics($maxTopics);

  $html = '<div class="sfPhpBbBox sfPhpBbBoxTopics">';
  $html .= '<div class="sfPhpBbBoxTitle sfPhpBbBoxTitleTopics">'.__('Ultimi argomenti dal forum').'</div>';

  foreach ($topics as $i => $topic)
  {
    $html .= '<div class="sfPhpBbTitle sfPhpBbTopicTitle">';
    $html .= '<a class="sfPhpBbTopicTitleLink" target="_BLANK" href="http://'.sfConfig::get('app_url_phpbb').'/viewtopic.php?f='.$topic->forum_id.'&t='.$topic->topic_id.'#p'.$topic->topic_last_post_id.'">'.$topic->topic_title.'</a>';
    $html .= '</div>';

    $html .= '<div class="sfPhpBbAuthorTitle sfPhpBbTopicAuthorTitle">';
    $html .= __('Inviato da %name%', array('%name%' => '<a class="sfPhpBbAuthorLink sfPhpBbTopicAuthorLink" target="_BLANK" href="http://'.sfConfig::get('app_url_phpbb').'/memberlist.php?mode=viewprofile&un='.$topic->topic_last_poster_name.'"><span class="sfPhpBbTopicAuthorName">'.$topic->topic_last_poster_name.'</span></a>')).' ';
    $html .= ', '.__('il %date%', array('%date%' => format_date($topic->topic_last_post_time)));
    $html .= '</div>';

  }
  $html .= '</div>';
  return $html;

}

/**
 *  View last posts from the phpBB forum
 * 
 * @param $maxPosts Number of posts to display
 * @return string HTML code
 * 
 * @package    sfPhpBbConnectPlugin
 * @subpackage helper
 * @author     Fabrizio Pucci <fabrizio.pucci.ge@gmail.com>
 * @version    SVN: $Id$
 */
function lastPosts($maxPosts)
{
  $posts =  Doctrine::getTable('PhpbbTopics')->lastPosts($maxPosts);

  $html = '<div class="sfPhpBbBox sfPhpBbBoxPosts">';
  $html .= '<div class="sfPhpBbBoxTitle">'.__('Ultimi post dal forum').'</div>';

  foreach ($posts as $i => $post)
  {
    $html .= '<div class="sfPhpBbTitle sfPhpBbPostTitle">';
    $html .= '<a target="_BLANK" href="http://'.sfConfig::get('app_url_phpbb').'/viewtopic.php?f='.$post->forum_id.'&t='.$post->topic_id.'#p'.$post->post_id.'">'.$post->post_subject.'</a>';
    $html .= '</div>';

    $html .= '<div class="sfPhpBbAuthorTitle sfPhpBbPostAuthorTitle">';
    $html .= __('Inviato da %name% ', array('%name%' => '<a class="sfPhpBbAuthorLink sfPhpBbPostAuthorLink" target="_BLANK" href="http://'.sfConfig::get('app_url_phpbb').'/memberlist.php?mode=viewprofile&un='.$post->PhpbbUsers->username.'"><span class="sfPhpBbAuthorName sfPhpBbPostAuthorName">'.$post->PhpbbUsers->username.'</span></a>'));
    $html .= ', '.__('il %date%', array('%date%' => format_date($post->post_time)));
    $html .= '</div>';

  }

  $html .= '</div>';
  return $html;
}