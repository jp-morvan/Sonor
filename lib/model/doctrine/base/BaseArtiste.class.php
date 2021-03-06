<?php

/**
 * BaseArtiste
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $nom
 * @property Doctrine_Collection $Album
 * 
 * @method string              getNom()   Returns the current record's "nom" value
 * @method Doctrine_Collection getAlbum() Returns the current record's "Album" collection
 * @method Artiste             setNom()   Sets the current record's "nom" value
 * @method Artiste             setAlbum() Sets the current record's "Album" collection
 * 
 * @package    sonor
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseArtiste extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('artiste');
        $this->hasColumn('nom', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));

        $this->option('collate', 'utf8_general_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Album', array(
             'local' => 'id',
             'foreign' => 'id_artiste'));

        $sluggable0 = new Doctrine_Template_Sluggable(array(
             'fields' => 
             array(
              0 => 'nom',
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