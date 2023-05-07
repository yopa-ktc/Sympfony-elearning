<?php

namespace App\Controller;
use App\Entity\Course;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CourseController extends AbstractController
{
    #[Route('/course', name: 'create_course')]
    public function createCourse(EntityManagerInterface $entityManager): Response
    {
        $course = new Course();
        $course->setNom('medumba');
        $course->setDescription('learn medumba easuly in 2 months');
        $course->setTeacherId(2);
        $course->setStartDate(new \DateTime());

        $entityManager->persist($course);

        $entityManager->flush();

        $errors = $validator->validate($product);
        if (count($errors) > 0) {
            return new Response((string) $errors, 400);
        }
        
        return new Response('Saved new courses with id :'.$course->getId());
        
    }

    
    public function index(): Response
    {
        return $this->render('course/index.html.twig', [
            'controller_name' => 'CourseController',
        ]);
    }
}
