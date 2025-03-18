<?php

namespace App\Traits;

use App\Repository\RepositoryInterface;
use App\SideBar\SideBar;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Service\Attribute\Required;

trait ControllerTrait
{
    protected SideBar $sideBarButtons;

    #[Required]
    public function setSideBar(SideBar $sideBarButtons): void
    {
        $this->sideBarButtons = $sideBarButtons;
    }

    protected function renderWithSideBarItems(
        string $template,
        ?Pagerfanta $pagerfanta = null,
        ?FormInterface $form = null,
        ?array $parameters = null): Response
    {
        $buttons = $this->sideBarButtons->buttons();
        if (!$parameters) $parameters = [];
        return $this->render($template, array_merge($parameters, [
            'page' => $pagerfanta,
            'dataForm' => $form?->createView(),
            'sideBarButtons' => $buttons
        ]));
    }

    protected function createPagination(RepositoryInterface $repository, int $page, int $limit): Pagerfanta
    {
        $findAllQB = $repository->createFindAllQueryBuilder();

        $pagerFanta = new Pagerfanta(new QueryAdapter($findAllQB));
        $pagerFanta->setMaxPerPage($limit);
        $pagerFanta->setCurrentPage($page);

        return $pagerFanta;
    }
}