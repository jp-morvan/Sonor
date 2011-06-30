<?php
/**
 * Description of components
 *
 * @author JP-MORVAN
 */
class accueilComponents extends sfComponents
{
  public function executeSearch(sfWebRequest $request)
  {
    $this->form = new SearchForm(null, array());
  }

  public function executeSidebar(sfWebRequest $request)
  {
    if($this->getUser()->isAuthenticated())
    {
      $user_id = $this->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser');
      $this->playlists = Doctrine_Core::getTable('Playlist')->getPlaylistsFormUser($user_id);
      $this->albums = Doctrine_Core::getTable('Album')->getAlbumsFormUser($user_id);
    }
  }
}
?>
