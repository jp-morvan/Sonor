<?php

/**
 * ChansonTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class ChansonTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object ChansonTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Chanson');
    }

  public function retrieveNoMedatada(Doctrine_Query $dq)
  {
    return $dq->where($dq->getRootAlias().'.has_metadata=0');
  }
  
  public function findForType($type, $slug)
  {
    $r = substr($type, 1);
    $relation = ucfirst($type);
    $dq = self::createQuery('c')
          ->select('c.*, '.$r.'.*')
          ->leftJoin('c.'.$relation.' '.$r)
          ->where($r.'.slug = ?', $slug);
    return $dq->execute(array(), Doctrine_Core::HYDRATE_ARRAY);
  }
}