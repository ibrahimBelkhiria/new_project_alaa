<?php
/**
 * Created by PhpStorm.
 * User: Logidee
 * Date: 24/01/2019
 * Time: 19:48
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Article;
use FOS\RestBundle\Controller\AbstractFOSRestController;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationList;

class ArticleController   extends AbstractFOSRestController
{

    // get all articles from the database

    /**
     * @ApiDoc(
     *     resource=true,
     *     description="get All articles",
     *     section="articles"
     * )
     *
     * @Rest\Get("/api/get_all_articles")
     */
    public function getAllArticles()
    {
        $entiyManger = $this->getDoctrine()->getManager();

        $articles = $entiyManger->getRepository(Article::class)->findAll();


        return View::create($articles,Response::HTTP_OK);

    }


    // get one single ressource


    /**
     *  @ApiDoc(
     *     resource=true,
     *     description="get_one_single_article",
     *     section="articles",
     *     requirements={
    *        {
     *      "name"="id",
     *      "dataType"="integer",
     *     "requirements"="\d+",
     *       "description"="The article unique identifier."
     *     }
*     }
     * )
     * @param $id
     * @Rest\Get("/api/articles/{id}",name="get_one_article_by_id")
     * @return View
     */
    public function getArticleById($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $article = $entityManager->getRepository(Article::class)->find($id);

        if (empty($article)){
            return View::create("article not found",Response::HTTP_NOT_FOUND);
        }


        return View::create($article,Response::HTTP_OK);
    }



    /**
     * @Rest\Post("/api/articles",name="create_article")
     *
     * @param Article $article
     * @param ConstraintViolationList $violations
     * @return View
     * @ParamConverter("article",converter="fos_rest.request_body")
     */

    public function createArticle(Article $article,ConstraintViolationList $violations)
    {


        $entityManager = $this->getDoctrine()->getManager();

        if (count($violations)){
            return View::create($violations,Response::HTTP_BAD_REQUEST);
        }


        $entityManager->persist($article);
        $entityManager->flush();

        return View::create($article,Response::HTTP_CREATED);

    }


    /**
     * @Rest\Put("/api/articles/{article_id}",name="update_article")
     * @param Request $request
     * @param $article_id
     * @return View
     */
    public  function updateArticle(Request $request,$article_id)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $articleRepo = $entityManager->getRepository(Article::class);

        $article = $articleRepo->find($article_id);

        if (empty($article)){
            return View::create("article you want to update is  not found",Response::HTTP_NOT_FOUND);
        }

        $article->setName($request->get('name'));
        $article->setDescription($request->get('description'));

        // $entityManager->persist($article);
        $entityManager->flush();

        return View::create($article,Response::HTTP_OK);
    }



    /**
     * @Rest\Delete("/api/articles/{id}",name="remove_article")
     * @param $id
     * @return View
     */
    public function removeArticle($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $articleRepo = $entityManager->getRepository(Article::class);
        $article = $articleRepo->find($id);

        if (empty($article)){
            return View::create("article you want to delete is not found",Response::HTTP_NOT_FOUND);
        }

        $entityManager->remove($article);
        $entityManager->flush();


        return View::create([],Response::HTTP_NO_CONTENT);
    }














}