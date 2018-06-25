<?php
namespace App\Controller\Admin;

use App\Entity\RecruitmentUserStatus;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Form\RecruitmentUserStatusType;

class RecruitmentUserStatusController extends Controller
{
    /**
     * @var Session
     */
    private $session;

    /**
     * RecruitmentUserStatusController constructor.
     */
    public function __construct()
    {
        $this->session = new Session();
    }

    /**
     * @return Response
     */
    public function index()
    {
        $recruitmentUserStatuses = $this->getDoctrine()
            ->getRepository(RecruitmentUserStatus::class)
            ->findAll();

        return $this->render('back/recruitment_user_statuses.html.twig',array(
            'recruitmentUserStatuses'=> $recruitmentUserStatuses
        ));
    }

    /**
     * @param int $id
     * @return Response
     */
    public function show(int $id)
    {
        $recruitmentUserStatus = $this->getDoctrine()
            ->getRepository(RecruitmentUserStatus::class)
            ->find($id);

        return $this->render('back/recruitment_user_status_show.html.twig',array(
            'recruitmentUserStatus'=> $recruitmentUserStatus
        ));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function new(Request $request)
    {
        $recruitmentUserStatus = new RecruitmentUserStatus();
        $form = $this->createForm(RecruitmentUserStatusType::class, $recruitmentUserStatus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($recruitmentUserStatus);
            $em->flush();

            $this->session->getFlashBag()->add('success', 'Status uczestnika inwestycji został zmieniony');

            return $this->redirectToRoute('admin_recruitment_user_status_edit',array('id'=>$recruitmentUserStatus->getId()));
        }

        return $this->render('back/recruitment_user_status_new.html.twig',array(
            'form'=> $form->createView()
        ));
    }

    /**
     * @param int $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function edit(int $id, Request $request)    {
        $recruitmentUserStatus = $this->getDoctrine()
            ->getRepository(RecruitmentUserStatus::class)
            ->find($id);
        if($recruitmentUserStatus){
            $form = $this->createForm(RecruitmentUserStatusType::class, $recruitmentUserStatus);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $recruitmentUserStatus = $form->getData();

                $em = $this->getDoctrine()->getManager();
                $em->persist($recruitmentUserStatus);
                $em->flush();

                $this->session->getFlashBag()->add('success', 'Status uczestnika inwestycji został zmieniony');

                return $this->render('back/recruitment_user_status_edit.html.twig',array(
                    'recruitmentUserStatus'=> $recruitmentUserStatus,
                    'form'=> $form->createView()
                ));
            }

            return $this->render('back/recruitment_user_status_edit.html.twig',array(
                'recruitmentUserStatus'=> $recruitmentUserStatus,
                'form'=> $form->createView()
            ));
        }else {

            $this->session->getFlashBag()->add('danger', 'Status uczestnika inwestycji nie został znaleziony');

            return $this->redirectToRoute('admin_recruitment_user_statuses');
        }
    }

    /**
     * @param int $id
     * @param int $status
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function disable(int $id, int $status)    {
        $recruitmentUserStatus = $this->getDoctrine()
            ->getRepository(RecruitmentUserStatus::class)
            ->find($id);
        $recruitmentUserStatus->setIsActive($status);

        $em = $this->getDoctrine()->getManager();
        $em->persist($recruitmentUserStatus);
        $em->flush();

        $this->session->getFlashBag()->add('success', 'Status uczestnika inwestycji został wyłączony');

        return $this->redirectToRoute('admin_recruitment_user_statuses');
    }

    /**
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(int $id)    {
        $recruitmentUserStatus = $this->getDoctrine()
            ->getRepository(RecruitmentUserStatus::class)
            ->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($recruitmentUserStatus);
        $em->flush();

        $this->session->getFlashBag()->add('success', 'Status uczestnika inwestycji został usunięty');

        return $this->redirectToRoute('admin_recruitmentUserStatuses');
    }
}
