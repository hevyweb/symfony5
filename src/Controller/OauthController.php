<?php

namespace App\Controller;

use App\Entity\ImageLog;
use App\Entity\Oauth;
use App\Repository\ImageLogRepository;
use App\Service\Google;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class OauthController extends AbstractController
{
    /**
     * @var Google
     */
    private $google;

    public function __construct(Google $google)
    {
        $this->google = $google;
    }
    /**
     * @Route("/oauth", name="oauth_php")
     */
    public function index()
    {
        $oauth = $this->getDoctrine()->getRepository(Oauth::class)->findOneBy(['user' => $this->getUser()->getId()]);

        return $this->render('oauth/index.html.twig', [
            'title' => 'Отримання доступу',
            'oauth' => $oauth,
            'current_date' => new \DateTime(),
            'request_url' => $this->getRequestUrl(),
        ]);
    }

    /**
     * @Route("oauth/code", name="get_token")
     * @param Request $request
     * @throws \App\Exception\InvalidTokenException
     */
    public function getToken(Request $request)
    {
        $code = $request->get('code');
        if (!empty($code)) {
            $this->log('Отримано новий код доступу.', ['code' => $code]);
            try {
                $tokens = $this->google->getToken(
                    $code,
                    $this->getParameter('google_client_id'),
                    $this->getParameter('google_client_secret'),
                    $this->generateUrl('get_token', [], UrlGeneratorInterface::ABSOLUTE_URL)
                );

                $this->getDoctrine()->getRepository(Oauth::class)->upsert($tokens, $this->getUser(), $code);

                $this->log('Отримано новий токен.', $tokens);
            } catch (\Exception $exception) {
                $this->log('Не вдалось отримати токен.', ['error' => $exception->getMessage()]);
            }
        }
        return $this->redirect($this->generateUrl('oauth_php'));
    }

    /**
     * @Route("oauth/log", name="oauth_log")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function imageLog(Request $request)
    {
        /**
         * @var ImageLogRepository $imageLogRepository
         */
        $page = (int) $request->get('page', 1);
        $limit = (int) $request->get('limit', 30);
        $imageLogRepository = $this->getDoctrine()->getRepository(ImageLog::class);

        $totalCount = (int) $imageLogRepository->getTotalCount();
        $list = $imageLogRepository->paginate($page, $limit);
        return $this->render('oauth/list.html.twig', [
            'title' => 'Історія запитів',
            'list' => $list,
            'totalPages' => ceil($totalCount/$limit),
            'page' => $page,
            'limit' => $limit
            ]);
    }

    private function log($message, $description)
    {
        $em = $this->getDoctrine()->getManager();
        $imageLog = new ImageLog();
        $imageLog->setMessage($message)
            ->setUser($this->getUser())
            ->setCreatedAt(new \DateTime())
            ->setDescription($description);
        $em->persist($imageLog);
        $em->flush($imageLog);
    }

    private function getRequestUrl()
    {
        return "https://accounts.google.com/o/oauth2/v2/auth?" .
            "client_id=" . $this->getParameter('google_client_id') .
            "&response_type=code" .
            "&scope=https://www.googleapis.com/auth/photoslibrary" .
            "&redirect_uri=" . $this->generateUrl('get_token', [], UrlGeneratorInterface::ABSOLUTE_URL) .
            "&access_type=offline";
    }
}
