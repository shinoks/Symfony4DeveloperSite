<?php
namespace App\Service;

use App\Entity\Module;
use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Menu as Men;

class Menu
{
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * Menu constructor.
     * @param EntityManagerInterface $em
     * @param RequestStack $requestStack
     */
    public function __construct(EntityManagerinterface $em, RequestStack $requestStack)
    {
        $this->em = $em;
        $this->requestStack = $requestStack;
    }

    /**
     * @return array|null
     */
    public function getActiveMenu(): ?array
    {
        $url = $this->requestStack->getCurrentRequest()->getPathInfo();
        if($url =='/'){$url = '/index';};
        $active = $this->em
            ->getRepository(Men::class)
            ->findOneByActiveUrl($url);
        if($active){
            $activeMenu = $active;
        }else {
            $activeMenu = false;
        }

        return $activeMenu;
    }

    /**
     * @return array|null
     */
    public function getMenu(): ?array
    {
        $menu = $this->em->getRepository(Men::class)->findBy(['isActive' => 1, 'parent' => null],['position' => 'ASC', 'id' => 'DESC']);

        return $menu;
    }

    /**
     * @return array
     */
    public function modulesForActivePage(): array
    {
        $menu = $this->getActiveMenu();
        $modules = [];
        $modules['top']=[];
        $modules['bottom']=[];
        $i = 0;

        if($menu){
            foreach($menu->getModules() as $module){
                    if($module->getIsActive() == 1){
                    if($module->getPosition()->getPosition() == 'top'){
                        $modules['top'][$i] = ['position' =>$module->getPosition()->getPosition(), 'id'=>$module->getId(),'content' => $module->getGenus()->getContent(), 'template' => $module->getGenus()->getTemplate(), 'sequence' => $module->getSequence()];
                    }elseif($module->getPosition()->getPosition() == 'bottom'){
                        $modules['bottom'][$i] = ['position' =>$module->getPosition()->getPosition(), 'id'=>$module->getId(),'content' => $module->getGenus()->getContent(), 'template' => $module->getGenus()->getTemplate(), 'sequence' => $module->getSequence()];
                    }
                    $i = $i+1;
                }
            }
            usort($modules['top'], function ($a, $b){return strcmp($a["sequence"], $b["sequence"]);});
            usort($modules['bottom'], function ($a, $b){return strcmp($a["sequence"], $b["sequence"]);});
        }

        return $modules;
    }
}
