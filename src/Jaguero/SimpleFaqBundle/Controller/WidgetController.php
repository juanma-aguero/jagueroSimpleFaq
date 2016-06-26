<?php

namespace Jaguero\SimpleFaqBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Jaguero\SimpleFaqBundle\Entity\Question;
use Jaguero\SimpleFaqBundle\Form\Type\QuestionType;
use Doctrine\ORM\QueryBuilder;

/**
 * Question controller.
 */
class WidgetController extends Controller
{
    /**
     * Lists all Question entities.
     * @Template()
     */
    public function allEnabledAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $questions = $em->getRepository('JagueroSimpleFaqBundle:Question')->findBy(array(
            'enabled' => true,
        ), array(
            'position' => 'ASC',
        ));

        return array(
            'questions' => $questions,
        );
    }

}
