<?php

namespace Application\UserBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends EntityRepository
{
	public function getOtherUser($name)
	{
		 return $this->createQueryBuilder('u')
            ->select('u')
            ->where('u.name != :name')
            ->setParameter('name', $name)
			->getQuery()
            ->getResult();

	}
	public function getAllUserAndLastComment()
    {
 //    	return  $this>createNativeQuery('SELECT t.name, t.text FROM (SELECT  users.name, comments.text  
 // FROM `users` JOIN comments ON users.id = comments.user_id 
 // ORDER BY comments.id DESC) t group by t.name')->getQuery()
 //        ->getResult();
    }
}