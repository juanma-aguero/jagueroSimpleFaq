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
 *
 * @Route("/admin/question")
 */
class AdminQuestionController extends Controller
{
    /**
     * Lists all Question entities.
     *
     * @Route("/", name="admin_question")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $qb = $em->getRepository('JagueroSimpleFaqBundle:Question')->createQueryBuilder('q');
        $paginator = $this->get('knp_paginator')->paginate($qb, $request->query->get('page', 1), 20);
        return array(
            'paginator' => $paginator,
        );
    }

    /**
     * Finds and displays a Question entity.
     *
     * @Route("/{id}/show", name="admin_question_show", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     */
    public function showAction(Question $question)
    {
        $editForm = $this->createForm(new QuestionType(), $question, array(
            'action' => $this->generateUrl('admin_question_update', array('id' => $question->getid())),
            'method' => 'PUT',
        ));
        $deleteForm = $this->createDeleteForm($question->getId(), 'admin_question_delete');

        return array(

            'question' => $question, 'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),

        );
    }

    /**
     * Displays a form to create a new Question entity.
     *
     * @Route("/new", name="admin_question_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $question = new Question();
        $form = $this->createForm(new QuestionType(), $question);

        return array(
            'question' => $question,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a new Question entity.
     *
     * @Route("/create", name="admin_question_create")
     * @Method("POST")
     * @Template("JagueroSimpleFaqBundle:Question:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $question = new Question();
        $form = $this->createForm(new QuestionType(), $question);
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($question);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_question_show', array('id' => $question->getId())));
        }

        return array(
            'question' => $question,
            'form' => $form->createView(),
        );
    }

    /**
     * Edits an existing Question entity.
     *
     * @Route("/{id}/update", name="admin_question_update", requirements={"id"="\d+"})
     * @Method("PUT")
     * @Template("JagueroSimpleFaqBundle:Question:edit.html.twig")
     */
    public function updateAction(Question $question, Request $request)
    {
        $editForm = $this->createForm(new QuestionType(), $question, array(
            'action' => $this->generateUrl('admin_question_update', array('id' => $question->getid())),
            'method' => 'PUT',
        ));
        if ($editForm->handleRequest($request)->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirect($this->generateUrl('admin_question_show', array('id' => $question->getId())));
        }
        $deleteForm = $this->createDeleteForm($question->getId(), 'admin_question_delete');

        return array(
            'question' => $question,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Question entity.
     *
     * @Route("/{id}/delete", name="admin_question_delete", requirements={"id"="\d+"})
     * @Method("DELETE")
     */
    public function deleteAction(Question $question, Request $request)
    {
        $form = $this->createDeleteForm($question->getId(), 'admin_question_delete');
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($question);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_question'));
    }

    /**
     * Create Delete form
     *
     * @param integer $id
     * @param string $route
     * @return \Symfony\Component\Form\Form
     */
    protected function createDeleteForm($id, $route)
    {
        return $this->createFormBuilder(null, array('attr' => array('id' => 'delete')))
            ->setAction($this->generateUrl($route, array('id' => $id)))
            ->setMethod('DELETE')
            ->getForm();
    }

}
