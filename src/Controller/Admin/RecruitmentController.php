<?php
namespace App\Controller\Admin;

use App\Entity\Recruitment;
use App\Entity\RecruitmentUsers;
use App\Entity\RecruitmentUserStatus;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Form\RecruitmentType;

class RecruitmentController extends Controller
{
    /**
     * @var Session
     */
    private $session;

    /**
     * RecruitmentController constructor.
     */
    public function __construct()
    {
        $this->session = new Session();
    }

    /**
     * @param int $id
     * @return Response
     */
    public function show(int $id)
    {
        $recruitment = $this->getDoctrine()
            ->getRepository(Recruitment::class)
            ->find($id);

        $recruitmentUsers = $this->getDoctrine()
            ->getRepository(RecruitmentUsers::class)
            ->findByRecruitment($recruitment);

        $recruitmentUserStatus = $this->getDoctrine()
            ->getRepository(RecruitmentUserStatus::class)
            ->findBy(['isActive'=>1]);

        return $this->render('back/recruitment_show.html.twig',array(
            'recruitment'=> $recruitment,
            'recruitmentUsers' => $recruitmentUsers,
            'recruitmentUserStatus' => $recruitmentUserStatus
        ));
    }

    /**
     * @param int $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function edit(int $id, Request $request)
    {
        $recruitment = $this->getDoctrine()
            ->getRepository(Recruitment::class)
            ->find($id);
        if($recruitment){
            $form = $this->createForm(RecruitmentType::class, $recruitment);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $recruitment = $form->getData();

                $em = $this->getDoctrine()->getManager();
                $em->persist($recruitment);
                $em->flush();

                $this->session->getFlashBag()->add('success', 'Nabór został zmieniony');

                return $this->redirectToRoute('admin_recruitment_edit',['id'=> $id]);
            }

            return $this->render('back/recruitment_edit.html.twig',array(
                'recruitment'=> $recruitment,
                'form'=> $form->createView()
            ));
        }else {
            $this->session->getFlashBag()->add('danger', 'Nabór nie została znaleziona');

            return $this->redirectToRoute('admin_recruitments');
        }

    }

    /**
     * @param $id
     * @param $status
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editStatus($id, $status)
    {
        $recruitmentUser = $this->getDoctrine()
            ->getRepository(RecruitmentUsers::class)
            ->find($id);
        if($recruitmentUser){
            $recruitmentUserStatus = $this->getDoctrine()
                ->getRepository(RecruitmentUserStatus::class)
                ->find($status);
            if($recruitmentUserStatus){
                $recruitmentUser->setStatus($recruitmentUserStatus);

                $em = $this->getDoctrine()->getManager();
                $em->persist($recruitmentUser);
                $em->flush();

                $this->session->getFlashBag()->add('success', 'Status oferty został zmieniony');

            }else {
                $this->session->getFlashBag()->add('danger', 'Status oferty nie został zmieniony');
            }
        }else {
            $this->session->getFlashBag()->add('danger', 'Status oferty nie został zmieniony');
        }

        return $this->redirectToRoute('admin_recruitment_show',['id' => $recruitmentUser->getRecruitment()->getId()]);
    }
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function new(Request $request)
    {
        $recruitment = new Recruitment;
        $form = $this->createForm(RecruitmentType::class, $recruitment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $recruitment = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($recruitment);
            $em->flush();

            $this->session->getFlashBag()->add('success', 'Oferta została dodana');

            return $this->redirectToRoute('admin_recruitment_edit',['id'=> $recruitment->getId()]);
        }

        return $this->render('back/recruitment_new.html.twig',array(
            'recruitment'=> $recruitment,
            'form'=> $form->createView()
        ));
    }

    /**
     * @return Response
     */
    public function disable(int $id, int $status)
    {
        $recruitment = $this->getDoctrine()
            ->getRepository(Recruitment::class)
            ->find($id);
        $recruitment->setIsActive($status);

        $em = $this->getDoctrine()->getManager();
        $em->persist($recruitment);
        $em->flush();

        $this->session->getFlashBag()->add('success', 'Oferta została wyłączona');

        return $this->redirectToRoute('admin_recruitments');
    }

    /**
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(int $id)    {
        $recruitment = $this->getDoctrine()
            ->getRepository(Recruitment::class)
            ->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($recruitment);
        $em->flush();

        $this->session->getFlashBag()->add('success', 'Nabór został usunięta');

        return $this->redirectToRoute('admin_recruitments');
    }

    /**
     * @return Response
     */
    public function index()
    {
        $recruitment = $this->getDoctrine()
            ->getRepository(Recruitment::class)
            ->getRecruitmentWithCount();

        return $this->render('back/recruitments.html.twig',array(
            'recruitments' => $recruitment
        ));
    }
}
