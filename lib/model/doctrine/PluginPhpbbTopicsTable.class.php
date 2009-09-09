<?php
/**
 * Query for retrieve data from phpBB forum
 *
 * @package    sfPhpBbConnectPlugin
 * @author     Fabrizio Pucci <fabrizio.pucci.ge@gmail.com>
 * @version    SVN: $Id$
 */
class PluginPhpbbTopicsTable extends Doctrine_Table
{

  /**
   * @param $topics Number of topics to view
   * @return Doctrine_Collection
   */
  public function lastTopics($topics = 5)
  {
    $q = Doctrine_Query::create()
    ->select('t.topic_id, t.forum_id, t.topic_title')
    ->from('PhpbbTopics t')
    ->orderBy('t.topic_last_post_time DESC')
    ->limit($topics);

    return $q->execute();
  }

  /**
   * @param $posts Number of posts to view
   * @return Doctrine_Collection
   */
  public function lastPosts($posts = 5)
  {
    $q = Doctrine_Query::create()
    ->select('p.post_id, p.topic_id, p.forum_id, p.post_time, p.post_subject, p.poster_id')
    ->addSelect('u.user_id, u.username')
    ->from('PhpbbPosts p')
    ->innerJoin('p.PhpbbUsers u WITH p.poster_id = u.user_id')
    ->orderBy('p.post_time DESC')
    ->limit($posts);

    return $q->execute();
  }

  /**
   * @return Doctrine_Collection
   */
  public function onlineGuests()
  {
    $q = Doctrine_Query::create()
    ->select('COUNT(DISTINCT s.session_ip) as guests')
    ->from('PhpbbSessions s')
    ->where('s.session_user_id = ?')
    ->addWhere('s.session_time >= ?', array(sfConfig::get('app_anonymous_user_id'), time() - (1 * 60)))
    ;

    return $q->execute();
  }
}