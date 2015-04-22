<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $webDir = $this->container->getParameter('kernel.root_dir').'/../web/';
        $file = new File($webDir.'favicon.ico');

        // This works
        $fileConstraint1 = new Constraints\File(['maxSize' => '1M']);

        // This works too
        $fileConstraint2 = new Constraints\File();
        $fileConstraint2->maxSize = '1000000';

        // This used to work in 2.5.x but crashes since 2.6.0
        $fileConstraint3 = new Constraints\File();
        $fileConstraint3->maxSize = '1M';

        $validator = $this->get('validator');

        return $this->render(
            'default/index.html.twig',
            [
                'errors1' => $validator->validate($file, $fileConstraint1),
                'errors2' => $validator->validate($file, $fileConstraint2),
                'errors3' => $validator->validate($file, $fileConstraint3)
            ]
        );
    }
}
