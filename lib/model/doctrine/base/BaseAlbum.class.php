<?php

/**
 * BaseAlbum
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $titre
 * @property integer $id_artiste
 * @property Artiste $Artiste
 * @property Doctrine_Collection $Users
 * @property Doctrine_Collection $Chanson
 * @property Doctrine_Collection $AlbumsUsers
 * 
 * @method string              getTitre()       Returns the current record's "titre" value
 * @method integer             getIdArtiste()   Returns the current record's "id_artiste" value
 * @method Artiste             getArtiste()     Returns the current record's "Artiste" value
 * @method Doctrine_Collection getUsers()       Returns the current record's "Users" collection
 * @method Doctrine_Collection getChanson()     Returns the current record's "Chanson" collection
 * @method Doctrine_Collection getAlbumsUsers() Returns the current record's "AlbumsUsers" collection
 * @method Album               setTitre()       Sets the current record's "titre" value
 * @method Album               setIdArtiste()   Sets the current record's "id_artiste" value
 * @method Album               setArtiste()     Sets the current record's "Artiste" value
 * @method Album               setUsers()       Sets the current record's "Users" collection
 * @method Album               setChanson()     Sets the current record's "Chanson" collection
 * @method Album               setAlbumsUsers() Sets the current record's "AlbumsUsers" collection
 * 
 * @package    sonor
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseAlbum extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('album');
        $this->hasColumn('titre', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('id_artiste', 'integer', null, array(
             'type' => 'integer',
             ));

        $this->option('collate', 'utf8_general_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Artiste', array(
             'local' => 'id_artiste',
             'foreign' => 'id',
             'onDelete' => 'CASCADE',
             'onUpdate' => 'CASCADE'));

        $this->hasMany('sfGuardUser as Users', array(
             'refClass' => 'AlbumsUsers',
             'local' => 'id_album',
             'foreign' => 'id_user'));

        $this->hasMany('Chanson', array(
             'local' => 'id',
             'foreign' => 'id_album'));

        $this->hasMany('AlbumsUsers', array(
             'local' => 'id',
             'foreign' => 'id_album'));

        $sluggable0 = new Doctrine_Template_Sluggable(array(
             'fields' => 
             array(
              0 => 'titre',
             ),
             'name' => 'slug',
             'type' => 'string',
             'length' => 255,
             'unique' => true,
             'canUpdate' => true,
             ));
        $this->actAs($sluggable0);
    }
}