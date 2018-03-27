<?php
namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\Admin;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $admin = new Admin();
        $admin->setUsername('admin');
        $password = $this->passwordEncoder->encodePassword($admin, 'admin');
        $admin->setPassword($password);
        $admin->setEmail('admin@yourownaddress.pl');
        $admin->setFirstName('Luke');
        $admin->setlastName('Skywalker');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setIsActive(1);

        $manager->persist($admin);
        $manager->flush();
    }
}
