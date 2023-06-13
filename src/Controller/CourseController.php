<?php

namespace App\Controller;
use App\Entity\Course;
use App\Entity\Language;
use App\Form\LanguageFormType;
use App\Repository\CourseRepository;
use App\Repository\LanguageRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class CourseController extends AbstractController
{
    #[Route('/course', name: 'create_course', methods:'POST')]
    public function createCourse(Request $request, CourseRepository $courseR, ValidatorInterface $validator): Response
    {

        $requestData = json_decode($request->getContent(), true);

        $course = new Course();
        $course->setNom($requestData['langue']);
        $course->setDescription($requestData['description']);
        $course->setTeacherId($requestData['teacher']);
        $newdate = new \DateTime($requestData['date_ajout']);
        $course->setStartDate($newdate);

        $errors = $validator->validate($course);
        if (count($errors) > 0) {
            return new Response((string) $errors, 400);
        }

        $courseR->save($course, true);

        
        return new Response('Saved new courses with id :'.$course->getId());
        
    }

    #[route('/api/courses', name:'all_coures', methods: 'GET')]
    public function getAllCourses(EntityManagerInterface $entityManager): Response
    {
        $newLanguage = new Language();
        $form = $this->createForm(LanguageFormType::class, $newLanguage);
        $courses = $entityManager->getRepository(Language::class)->findAll();
        // return $this->json($courses);
        return $this->render('index.html.twig', ['allCourses' => $courses, 'languageForm' => $form->createView()]);
    }



    #[route('post_language', name:'post-language', methods: 'POST')]
    public function postLanguage(LanguageRepository $languageR, Request $request){

        $newLanguage = new Language();
        $form = $this->createForm(LanguageFormType::class, $newLanguage);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Traitez les données du formulaire ici
            // Vous pouvez accéder aux valeurs du formulaire à l'aide de $yourEntity
            $languageR->save($newLanguage, true);

            // Redirigez ou effectuez toute autre action après la soumission réussie du formulaire
            return $this->redirectToRoute('all_coures');
        }else{
            return -1;
        }
    }

    public function index(): JsonResponse
    {
        $courses = $this->getDoctrine()->getRepository(Course::class)->findAll();
        return $this->json($courses);

        // return $this->render('course/index.html.twig', [
        //     'controller_name' => 'CourseController',
        // ]);
    }
}
