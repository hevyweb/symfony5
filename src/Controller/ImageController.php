<?php

namespace App\Controller;

use App\Entity\Image;
use App\Repository\ImageRepository;
use App\Service\DownloaderService;
use App\Service\RemoveImageService;
use Doctrine\Common\Collections\Criteria;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ImageController extends AbstractController
{
    const MAX_LOCKING_TIME = 10; //seconds

    /**
     * @var DownloaderService
     */
    private $downloaderService;

    /**
     * @var RemoveImageService
     */
    private $removeImageService;

    public function __construct(DownloaderService $downloaderService, RemoveImageService $removeImageService)
    {
        $this->downloaderService = $downloaderService;
        $this->removeImageService = $removeImageService;
    }

    /**
     * List of all users
     *
     * @Route("/images", name="images")
     */
    public function index(Request $request): Response
    {
        /**
         * @var ImageRepository $imagesRepository
         */
        $imagesRepository = $this->getDoctrine()->getRepository(Image::class);
        $perPage = $request->get('per_page', 100);
        $page = (int) $request->get('page', 1);
        $search = $request->get('q');
        $filters = ['q' => $search];

        if ($page < 1) {
            $page = 1;
        }
        $criteria = Criteria::create();
        $criteria->where(Criteria::expr()->eq("deleted", 0));

        if (!empty($search)) {
            $criteria->andWhere(Criteria::expr()->contains("description", $search));
        }
        $totalCount = $imagesRepository->total($criteria);

        $maxPage = ceil($totalCount/$perPage);

        if ($maxPage) {
            if ($page > $maxPage) {
                $page = $maxPage;
            }
            $images = $imagesRepository->getImagesPerPage($page, $perPage, $criteria);
        } else {
            $images = [];
        }
        return $this->render(
            'images/index.html.twig',
            [
                'title' => 'Фотографії',
                'images' => $images,
                'total' => $totalCount,
                'filtervariables' => $filters,
                'page' => $page,
                'perPage' => $perPage,
                'totalPages' => $maxPage
            ]
        );
    }

    /**
     * Edit Image
     *
     * @Route("/images/{id}", requirements={"id"="\d+"}, name="image-edit", methods={"POST"})
     */
    public function edit(Request $request): JsonResponse
    {
        $imageId = $request->get('id');
        $image = $this->getDoctrine()->getRepository(Image::class)->find($imageId);
        if (empty($image)) {
            throw new NotFoundHttpException('Фото не існує, або було видалене.');
        }

        $description = $request->get('description');

        if (!empty($description)) {
            $image->setDescription($description);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($image);
        $em->flush();
        return new JsonResponse(['ok']);
    }

    /**
     * Edit Image
     *
     * @Route("/images/delete/{id}", requirements={"id"="\d+"}, name="image-delete")
     */
    public function softDelete(Request $request): JsonResponse
    {
        $imageId = $request->get('id');
        /**
         * @var Image $image
         */
        $image = $this->getDoctrine()->getRepository(Image::class)->find($imageId);
        if (empty($image)) {
            throw new NotFoundHttpException('Фото не існує, або було видалене.');
        }

        $this->removeImageService->remove($image);

        $image->setDeleted(true);

        $em = $this->getDoctrine()->getManager();
        $em->persist($image);
        $em->flush();
        return new JsonResponse(['ok']);
    }
}
