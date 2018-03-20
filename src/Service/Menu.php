<?php
namespace App\Service;

use App\Entity\Module;
use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Menu as Men;

class Menu
{
    private $em;
    protected $requestStack;

    public function __construct(EntityManagerinterface $em, RequestStack $requestStack)
    {
        $this->em = $em;
        $this->requestStack = $requestStack;
    }

    public function getActiveMenu() {
        $url = $this->requestStack->getCurrentRequest()->getPathInfo();
        $active = $this->em
            ->getRepository(Men::class)
            ->findOneByActiveUrl($url);
        if($active){
            $activeMenu = $active->getId();
        }else {
            $activeMenu = 0;
        }

        return $activeMenu;
    }

    public function getMenu() {
        $menu = $this->em->getRepository(Men::class)->findBy(['isActive' => 1, 'parent' => null],['position' => 'ASC', 'id' => 'DESC']);

        return $menu;
    }

    public function modulesForActivePage(){
        $active = $this->getActiveMenu();
        $menu = $this->em
            ->getRepository(Men::class)
            ->find($active);
        $modules = [];
        $modules['top']=[];
        $modules['bottom']=[];
        $i = 0;

        if($menu){
            foreach($menu->getModules() as $module){
                if($module->getPosition()->getPosition() == 'top'){
                    $modules['top'][$i] = ['position' =>$module->getPosition()->getPosition(), 'id'=>$module->getId(),'content' => $module->getGenus()->getContent(), 'template' => $module->getGenus()->getTemplate()];
                }elseif($module->getPosition()->getPosition() == 'bottom'){
                    $modules['bottom'][$i] = ['position' =>$module->getPosition()->getPosition(), 'id'=>$module->getId(),'content' => $module->getGenus()->getContent(), 'template' => $module->getGenus()->getTemplate()];
                }
                $i = $i+1;
            }
        }

        return $modules;
    }
}
