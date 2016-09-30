<?php

namespace FTV\ApiBundle\Controller;

use Hateoas\HateoasBuilder;
use Hateoas\Representation\Factory\PagerfantaFactory;
use JMS\Serializer\SerializationContext;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiArticlesController extends Controller
{

    /**
     * @Route("/api/articles/{slug}", name="api_show_article")
     * @Method("GET")
     */
    public function showAction($slug)
    {
        $article = $this->getDoctrine()->getRepository('FTVApiBundle:Article')->findOneBy(array(
            'slug' => $slug
        ));
        if (!is_object($article)) {
            throw $this->createNotFoundException(sprintf('
                  there is no article with slug', $slug));
        }

        $response = $this->createResponse($article, 200);

        return $response;
    }


    /**
     * @Route("/api/articles", name="api_list_articles")
     * @Method("GET")
     */
    public function listAction()
    {
        $articles = $this->getDoctrine()->getRepository('FTVApiBundle:Article')->findAll();
        $adapter = new ArrayAdapter($articles);
        $pager = new Pagerfanta($adapter);

        $pagerfantaFactory = new PagerfantaFactory();
        $paginatedCollection = $pagerfantaFactory->createRepresentation(
            $pager,
            new \Hateoas\Configuration\Route('api_list_articles', array())
        );


        return $this->createResponse($paginatedCollection);
    }


    protected function createResponse($data, $statusCode = 200)
    {
        $json = $this->serialize($data);

        return new Response($json, $statusCode, array(
            'Content-Type' => 'application/json'
        ));
    }

    protected function serialize($data, $format = 'json')
    {
        $context = new SerializationContext();
        $context->setSerializeNull(true);


        return $this->container->get('jms_serializer')
            ->serialize($data, $format, $context);
    }


}
