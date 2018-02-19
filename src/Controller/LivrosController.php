<?php

namespace App\Controller;

use App\Entity\Livro;
use App\Form\LivroType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LivrosController extends Controller
{
    /**
     * @Route("/livros", name="listar_livros")
     * @Template("livros/index.html.twig")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();

        $livros = $em->getRepository(Livro::class)->findAll();

        return [
            'livros' => $livros
        ];
    }

    /**
     * @param Request $request
     * @Route("/livros/cadastrar", name="cadastrar_livro")
     * @Template("livros/create.html.twig")
     * @return array
     */
    public function create(Request $request)
    {
        $livro = new Livro();
        $form = $this->createForm(LivroType::class, $livro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $ebook = $livro->getEbook();
            $nome_ebook = md5(time()) . "." . $ebook->guessExtension();

            $ebook->move($this->getParameter('caminho_ebook'), $nome_ebook);
            $livro->setEbook($nome_ebook);

            $capa = $livro->getCapa();
            $nome_capa = md5(time()) . "." . $capa->guessExtension();
            $capa->move($this->getParameter('caminho_capa'), $nome_capa);
            $livro->setCapa($nome_capa);

            $em = $this->getDoctrine()->getManager();
            $em->persist($livro);
            $em->flush();

            $this->addFlash('success', "Livro foi salvo com sucesso!");
            return $this->redirectToRoute("listar_livros");

        }

        return [
            'form' => $form->createView()
        ];
    }

    /**
     * @Route("/livros/download/{id}", name="download_livro")
     * @param Livro $livro
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download(Livro $livro)
    {
        $pdf = $this->getParameter("caminho_ebook") . "/" . $livro->getEbook();
        return $this->file($pdf);
    }
}
