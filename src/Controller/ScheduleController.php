<?php

namespace App\Controller;

use App\Entity\Boat;
use App\Entity\Lunch;
use App\Entity\Schedule;
use App\Entity\TimeSlot;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ScheduleController extends AbstractController
{
    /**
     * @Route("/", name="schedule")
     */
    public function index(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $ts = $entityManager->getRepository(TimeSlot::class)->findAll();
        $boats = $entityManager->getRepository(Boat::class)->findAll();
        $lunches = $entityManager->getRepository(Lunch::class)->findAll();
        $schedules= $entityManager->getRepository(Schedule::class)->findAll();
        $allSchedules = $entityManager->getRepository(Schedule::class)->findAll();

        if (isset( $_POST['send']) )
        {
            if (!empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['phone']))
            {
                if (is_numeric($_POST['phone']))
                {

                    foreach ($schedules as $sch)
                    {
                        if ($sch->getPhoneNumber() != $_POST['phone'])
                        {
                            $phone = $_POST['phone'];

                        }
                        else {
                            $phone= "";
                            break;
                        }
                    }
                    if (!empty($phone))
                    {
                        $boat = $entityManager->getRepository(Boat::class)->findOneBy(['type' => $_POST['boat']]);
                        $lunch = $entityManager->getRepository(Lunch::class)->findOneBy(['type' => $_POST['lunch']]);
                        $timeSlot = $entityManager->getRepository(TimeSlot::class)->findOneBy(['period'  => $_POST['timeSlot']]);
                        $schedule = new Schedule($_POST['username'],$_POST['email'],$phone,$boat,$lunch,$timeSlot);
                        $entityManager->persist($schedule);
                        $entityManager->flush();

                        return $this->render('schedule/show.html.twig',
                            [
                                'schedule' => $schedule,
                                'allSchedules' => $allSchedules
                            ]
                        );
                    }
                    else
                    {
                        echo "This phone already exist in our schedules!";
                    }
                    }


                else
                {
                    echo "Phone number must be numeric!";

                }
            }
            else
            {
                echo "You have to fill in every field!!!";
            }

        }




        return $this->render('schedule/index.html.twig', [
            'timeSlots' => $ts,
            'schedules' =>  $schedules,
            'boats' => $boats,
            'lunches' => $lunches
        ]);
    }

    /**
     * @Route("/showall", name="showall")
     */
    public function showall()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $allSchedules = $entityManager->getRepository(Schedule::class)->findAll();


        return $this->render('schedule/show.html.twig',
            [
                'allSchedules' => $allSchedules
            ]
        );
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(Request $request,Schedule $schedule)
    {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($schedule);
            $entityManager->flush();


        return $this->redirectToRoute('showall');
    }
}
