<?php

namespace Application\UserBundle\Controller;

use Application\UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
    	$sql = "SELECT t.name, t.text, t.balance, t.id FROM (SELECT user.id, user.name, comment.text, user.balance FROM user JOIN comment ON user.id = comment.user_id ORDER BY comment.id DESC) t group by t.name";
    	$entity = $this->getDoctrine()->getManager();
    	$stmt = $entity->getConnection()->prepare($sql);
		$stmt->execute();
		$results = $stmt->fetchAll();
        //Используем первого пользователя в качестве авторизованного
        $user = $results[0];
        
        $otherUsers = $entity->getRepository('ApplicationUserBundle:User')->getOtherUser($user["name"]);

        if ($request->request->get('user'))
        {
            $sum = $request->request->get('sum');
            $userId = $request->request->get('user');
            if ($sum<=0 || $sum > $user['balance'])
                 $this->get('session')->getFlashBag()->add('error', "Сумма введена неверно");
            else{
                $entity->getConnection()->beginTransaction();
                try {
                    $sql = 'UPDATE user SET balance = balance + '.$sum.' WHERE id ='.$userId;
                    $stmt =  $entity->getConnection()->prepare($sql);
                    $stmt ->execute();
                    $sql ='UPDATE user SET balance = balance - '.$sum.' WHERE id ='.$user['id'];
                    $stm =  $entity->getConnection()->prepare($sql);
                    $stm ->execute();
                    $entity->getConnection()->commit();
                    $this->get('session')->getFlashBag()->add('succes', "Успешно");
                } 
                catch (Exception $e) {
                    // Rollback the failed transaction attempt
                    $entity->getConnection()->rollback();
                    $this->get('session')->getFlashBag()->add('error', "Операция завершилась неудачей");
                    // throw $e;
                }
            }
        }
        $stmt =  $entity->getConnection()->prepare('Select name, balance from user');
        $stmt ->execute();
        $allUser= $stmt->fetchAll();
        $user = $entity->getRepository('ApplicationUserBundle:User')->find($user["id"]);
        return $this->render('ApplicationUserBundle:Default:index.html.twig', array(
        	'results'=> $results,
            'user' => $user,
            'otherUsers'=> $otherUsers,
            'allUser'=> $allUser
             ));
    }
}
