<?php

namespace App\Controller;
use App\Entity\Course;
use App\Entity\Language;
use App\Repository\CourseRepository;
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
    public function getAllCourses(EntityManagerInterface $entityManager): JsonResponse
    {
        $courses = $entityManager->getRepository(Language::class)->findAll();
        return $this->json($courses);
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
