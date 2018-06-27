<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('email',TextType::class,['label'=>'email','required' => true])
        ->add('password',PasswordType::class,['label'=>'password.password','required' => true])
        ->add('firstName',TextType::class,['label'=>'first_name','required' => true])
        ->add('lastName',TextType::class,['label'=>'last_name','required' => true])
        ->add('phone',TelType::class,['label'=>'phone','required' => true])
        ->add('gender',ChoiceType::class, [
                'label'=>'gender',
                'multiple' => false,
                'expanded' => true,
                'choices' => [
                    'Pani' => 'f',
                    'Pan' => 'm'
                ],
                'required' => true
        ])
        ->add('birthDate',BirthdayType::class,[
            'label'=>'birth_date',
            'placeholder' => 'Wybierz datę',
            'required' => true
        ])
        ->add('regulations',CheckboxType::class, ['label'=>'regulations','required' => true ])
        ->add('regulationFromRegister',CheckboxType::class, ['label'=>'Wyrażam zgodę na przetwarzanie moich danych osobowych w rozumieniu Rozporządzenia Parlamentu Europejskiego i Rady (UE) 2016/679 z dnia 27 kwietnia 2016 r. w sprawie ochrony osób fizycznych w związku z przetwarzaniem danych osobowych i w sprawie swobodnego przepływu takich danych oraz uchylenia dyrektywy 95/46/WE (ogólne rozporządzenie o ochronie danych), oraz ustawy z dnia 16 lipca 2004 roku Prawo telekomunikacyjne w celach założenia konta przez 4 Elite Investments sp z o.o. 44-240 Żory, Szeroka 1 i oświadczam, iż podanie przeze mnie danych osobowych jest dobrowolne oraz iż zostałem poinformowany o prawie żądania dostępu do moich danych osobowych, ich zmiany, usunięcia, oraz wycofania zgody w dowolnym momencie.','required' => true ])
        ->add('marketingRegulations',CheckboxType::class, ['label'=>'Wyrażam zgodę na przetwarzanie moich danych osobowych w rozumieniu Rozporządzenia Parlamentu Europejskiego i Rady (UE) 2016/679 z dnia 27 kwietnia 2016 r. w sprawie ochrony osób fizycznych w związku z przetwarzaniem danych osobowych i w sprawie swobodnego przepływu takich danych oraz uchylenia dyrektywy 95/46/WE (ogólne rozporządzenie o ochronie danych), oraz ustawy z dnia 16 lipca 2004 roku Prawo telekomunikacyjne w celach marketingowych przez 4 Elite Investments sp z o.o. 44-240 Żory, Szeroka 1 i oświadczam, iż podanie przeze mnie danych osobowych jest dobrowolne oraz iż zostałem poinformowany o prawie żądania dostępu do moich danych osobowych, ich zmiany, usunięcia, oraz wycofania zgody w dowolnym momencie.','required' => true ])

        ->add('save', SubmitType::class, ['label' => 'register']);
    }
}
