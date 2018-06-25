<?php
namespace App\Controller\Admin;

use App\Entity\RecruitmentStatus;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Form\RecruitmentStatusType;

class RecruitmentStatusController extends Controller
{
    /**
     * @var Session
     */
    private $session;

    /**
     * RecruitmentStatusController constructor.
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
        $recruitmentStatuses = $this->getDoctrine()
            ->getRepository(RecruitmentStatus::class)
            ->findAll();

        return $this->render('back/recruitment_statuses.html.twig',array(
            'recruitmentStatuses'=> $recruitmentStatuses
        ));
    }

    /**
     * @param int $id
     * @return Response
     */
    public function show(int $id)
    {
        $recruitmentStatus = $this->getDoctrine()
            ->getRepository(RecruitmentStatus::class)
            ->find($id);

        return $this->render('back/recruitment_status_show.html.twig',array(
            'recruitmentStatus'=> $recruitmentStatus
        ));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function new(Request $request)
    {
        $recruitmentStatus = new RecruitmentStatus();
        $form = $this->createForm(RecruitmentStatusType::class, $recruitmentStatus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($recruitmentStatus);
            $em->flush();

            $this->session->getFlashBag()->add('success', 'Status inwestycji został zmieniony');

            return $this->redirectToRoute('admin_recruitment_status_edit',array('id'=>$recruitmentStatus->getId()));
        }

        return $this->render('back/recruitment_status_new.html.twig',array(
            'form'=> $form->createView()
        ));
    }

    /**
     * @param int $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function edit(int $id, Request $request)    {
        $recruitmentStatus = $this->getDoctrine()
            ->getRepository(RecruitmentStatus::class)
            ->find($id);
        if($recruitmentStatus){
            $form = $this->createForm(RecruitmentStatusType::class, $recruitmentStatus);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $recruitmentStatus = $form->getData();

                $em = $this->getDoctrine()->getManager();
                $em->persist($recruitmentStatus);
                $em->flush();

                $this->session->getFlashBag()->add('success', 'Status inwestycji został zmieniony');

                return $this->render('back/recruitment_status_edit.html.twig',array(
                    'recruitmentStatus'=> $recruitmentStatus,
                    'form'=> $form->createView()
                ));
            }

            return $this->render('back/recruitment_status_edit.html.twig',array(
                'recruitmentStatus'=> $recruitmentStatus,
                'form'=> $form->createView()
            ));
        }else {

            $this->session->getFlashBag()->add('danger', 'Status inwestycji nie został znaleziony');

            return $this->redirectToRoute('admin_recruitmentStatuses');
        }
    }

    /**
     * @param int $id
     * @param int $status
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function disable(int $id, int $status)    {
        $recruitmentStatus = $this->getDoctrine()
            ->getRepository(RecruitmentStatus::class)
            ->find($id);
        $recruitmentStatus->setIsActive($status);

        $em = $this->getDoctrine()->getManager();
        $em->persist($recruitmentStatus);
        $em->flush();

        $this->session->getFlashBag()->add('success', 'Status inwestycji został wyłączony');

        return $this->redirectToRoute('admin_recruitmentStatuses');
    }

    /**
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(int $id)    {
        $recruitmentStatus = $this->getDoctrine()
            ->getRepository(RecruitmentStatus::class)
            ->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($recruitmentStatus);
        $em->flush();

        $this->session->getFlashBag()->add('success', 'Status inwestycji został usunięty');

        return $this->redirectToRoute('admin_recruitmentStatuses');
    }
}
