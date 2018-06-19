<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserUpdateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('phone',TelType::class,['label'=>'phone','required' => true])
        ->add('firstName',TextType::class,['label'=>'first_name','required' => true])
        ->add('lastName',TextType::class,['label'=>'last_name','required' => true])
        ->add('gender',ChoiceType::class, [
                'label'=>'gender',
                'multiple' => false,
                'expanded' => true,
                'choices' => [
                    'Pani' => 'f',
                    'Pan' => 'm'
                ]])
        ->add('birthDate',BirthdayType::class,[
                'label'=>'birth_date',
                'placeholder' => 'Wybierz datę'
        ])
        ->add('pesel',NumberType::class,['label'=>'pesel','required' => false])
        ->add('idNumber',TextType::class,['label'=>'id_number','required' => false])
        ->add('zipCode',TextType::class,['label'=>'zip_code','required' => false])
        ->add('address',TextType::class,['label'=>'address','required' => false])
        ->add('city',TextType::class,['label'=>'city','required' => false])
        ->add('bankAccount',TextType::class,['label'=>'bank_account','required' => false])
        ->add('regulationFromRegister',CheckboxType::class, ['label'=>'Wyrażam zgodę na przetwarzanie moich danych osobowych w rozumieniu Rozporządzenia Parlamentu Europejskiego i Rady (UE) 2016/679 z dnia 27 kwietnia 2016 r. w sprawie ochrony osób fizycznych w związku z przetwarzaniem danych osobowych i w sprawie swobodnego przepływu takich danych oraz uchylenia dyrektywy 95/46/WE (ogólne rozporządzenie o ochronie danych), oraz ustawy z dnia 16 lipca 2004 roku Prawo telekomunikacyjne w celu złożenia oferty przez 4 Elite Investments sp z o.o. 44-240 Żory, Szeroka 1 i oświadczam, iż podanie przeze mnie danych osobowych jest dobrowolne oraz iż zostałem poinformowany o prawie żądania dostępu do moich danych osobowych, ich zmiany, usunięcia, oraz wycofania zgody w dowolnym momencie.','required' => true ])
        ->add('marketingRegulations',CheckboxType::class, ['label'=>'Wyrażam zgodę na przetwarzanie moich danych osobowych w rozumieniu Rozporządzenia Parlamentu Europejskiego i Rady (UE) 2016/679 z dnia 27 kwietnia 2016 r. w sprawie ochrony osób fizycznych w związku z przetwarzaniem danych osobowych i w sprawie swobodnego przepływu takich danych oraz uchylenia dyrektywy 95/46/WE (ogólne rozporządzenie o ochronie danych), oraz ustawy z dnia 16 lipca 2004 roku Prawo telekomunikacyjne w celach marketingowych przez 4 Elite Investments sp z o.o. 44-240 Żory, Szeroka 1 i oświadczam, iż podanie przeze mnie danych osobowych jest dobrowolne oraz iż zostałem poinformowany o prawie żądania dostępu do moich danych osobowych, ich zmiany, usunięcia, oraz wycofania zgody w dowolnym momencie.','required' => false ])

        ->add('save', SubmitType::class);
    }
}
