<?php

/**
 * accueil actions.
 *
 * @package    sonor
 * @subpackage accueil
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class accueilActions extends sfActions
{
  private $user_id;
  
  public function preExecute() 
  {
    $this->user_id = $this->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser');
  }
  
  public function executeIndex(sfWebRequest $request)
  {
  }

  public function executeSearch(sfWebRequest $request)
  {
    $this->forward404unless($request->isXmlHttpRequest());
    $type = $request->getParameter('type');
    $this->getResponse()->setContentType('application/json');
    $choices = array();
    $chansons = Doctrine::getTable('Chanson')->searchEverything($request->getParameter('q'), $request->getParameter('limit'));
    foreach($chansons as $c)
    {
      $choices['c_'.$c->slug] = '(C) '.$c->titre;
    }
//    if($type == "album")
//    {
//      $choices = array();
//    }
    $albums = Doctrine::getTable('Album')->searchEverything($request->getParameter('q'), $request->getParameter('limit'));
    foreach($albums as $a)
    {
      $choices['a_'.$a->slug] = $a->titre;
    }
    if(count($choices) == 0)
    {
      $choices[] = 'Aucun résultat';
    }
    return $this->renderText(json_encode($choices));
  }

  public function executeJavascript(sfWebRequest $request)
  {
  }
  
  public function executeAjaxLecture(sfWebRequest $request)
  {
    $slug = $request->getParameter('slug');
    $type = $request->getParameter('type');
    if($type == "chanson")
    {
      $chanson = Doctrine_Core::getTable('Chanson')->findOneBy('slug', $slug);
//      $path = $chanson->getAlbumDirectory().$chanson->audio_file.".".$request->getAudioFileType();
      $path = $chanson->getAlbumDirectory().$chanson->audio_file;
//      $filename = sfConfig::get('app_files_storage_path_list').$path;
      $file = $request->getAudioPath().$path;
      return $this->renderText($file);
    }
    if($type == "album")
    {
      $ids = array();
      // TODO ajouter un order
      $album = Doctrine_Core::getTable('Album')->findOneBy('slug', $slug);
      foreach(($chansons = $album->getChanson()) as $chanson)
      {
        $path = $chanson->getAlbumDirectory().$chanson->audio_file;
        $file = $request->getAudioPath().$path;
        $ids[] = $file;
      }
      return $this->renderText(json_encode($ids));
    }
  }
  
  public function executeAjaxListeChansons(sfWebRequest $request)
  {
    $type = $request->getParameter('type');
    $slug = $request->getParameter('slug');
    if($type == 'chanson')
    {
      $chansons = Doctrine_Core::getTable('Chanson')->findForType($type, $slug);
    }
    else
    {
      $chansons = Doctrine_Core::getTable('Chanson')->findForType($type, $slug);
    }
    $relation = $chansons[0][ucfirst($type)];
    $in_user_list = false;
    foreach($relation['Users'] as $user)
    {
      if($user['id'] == $this->user_id)
      {
        $in_user_list = true;
      }
    }
    $files = array();
    $files_data = array();
    $i = 0;
    foreach($chansons as $chanson)
    {
      $path = $chanson->getAlbumDirectory().$chanson->audio_file;
      $file = $request->getAudioPath().$path;
      $files[] = $file;
      $files_data[] = "\n".$i++.": { artist: \"".$chanson->Album->Artiste->nom."\", title: \"".$chanson->titre."\" }";
    }
    return $this->renderPartial('accueil/content', array(
        'chansons' => $chansons, 
        'type' => $type, 
        'relation' => $relation, 
        'slug' => $slug,
        'in_list' => $in_user_list,
        'files'  => $files,
        'files_data'  => join(",", $files_data)
    ));
  }
  
  public function executeAjaxUpdateInList(sfWebRequest $request)
  {
    $acte = $request->getParameter('acte');
    $type = $request->getParameter('type');
    $slug = $request->getParameter('slug');
    $slug = (($new_slug = strchr($slug, "_", true)) !== false) ? $new_slug: $slug;
    if($type == "playlist")
    {
      $relation = Doctrine_Core::getTable('Playlist')->findOneBy('slug', $slug, Doctrine_Core::HYDRATE_ARRAY);
    }
    else
    {
      $relation = Doctrine_Core::getTable('Album')->findOneBy('slug', $slug, Doctrine_Core::HYDRATE_ARRAY);
    }
    return $this->renderPartial('accueil/album_add_remove', array('relation' => $relation, 'in_list' => (($acte == 'ajouter') ? true: false)));
  }
  
  public function executeAjaxRemove(sfWebRequest $request)
  {
    $id = substr(strrchr($request->getParameter('slug'), "_"), 1);
    $type = $request->getParameter('type');
    if($type == "playlist")
    {
      $delete = Doctrine_Core::getTable('Playlist')->findOneBy('id', $id);
      $delete->delete();
    }
    else
    {
//      $user_id = $this->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser');
      $delete = Doctrine_Core::getTable('AlbumsUsers')->remove($id, $this->user_id);
    }
    return $this->renderText('');
  }
  
  public function executeAjaxAdd(sfWebRequest $request)
  {
    $type = $request->getParameter('type');
    $titre = $request->getParameter('titre');
//    $user_id = $this->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser');
    if($type == "playlist")
    {
      $new = new Playlist();
      $new->titre = $titre;
      $new->id_user = $this->user_id;
      $new->save();
      return $this->renderPartial('accueil/playlist_li', array('playlist' => $new, 'count_chansons' => 0));
    }
    else
    {
      $new = new AlbumsUsers();
      $new->id_album = Doctrine_Core::getTable('Album')->findOneBy('slug', $titre, Doctrine_Core::HYDRATE_SINGLE_SCALAR);
      $new->id_user = $this->user_id;
      $new->save();
      $album = $new->getAlbum();
      return $this->renderPartial('accueil/album_li', array('album' => $album, 'count_chansons' => $album->countChansons()));
    }
  }
  
  public function executeAjaxGetChampAlbumField(sfWebRequest $request)
  {
    $form = new AlbumFieldForm();
    return $this->renderPartial('accueil/album_field', array('form' => $form));
  }
}
