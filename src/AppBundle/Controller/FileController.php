<?php

namespace AppBundle\Controller;

use AppBundle\Entity\File;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;


class FileController extends Controller
{


    /**
     * @param Request $request
     * @return View
     * @Rest\Post("api/upload",name="upload_image")
     *
     */
    public function uploadImage(Request $request)
    {
        $file= new File();
        $uploadedImage=$request->files->get('file');
        /**
         * @var UploadedFile $image
         */
        $image=$uploadedImage;
        $imageName=md5(uniqid()).'.'.$image->guessExtension();

        $image->move($this->getParameter('image_directory'),$imageName);

        $file->setImage($imageName);
        $em=$this->getDoctrine()->getManager();
        $em->persist($file);
        $em->flush();

        return View::create('File uploaded succefully!',Response::HTTP_CREATED);
    }
















}
