<?php

namespace AppBundle\Query;

use AppBundle\Entity\Card;
use Twig_Environment;

/**
 * Description of QueryTemplating
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class QueryTemplating
{

    /**
     *
     * @var Twig_Environment
     */
    private $twig;

    /**
     *
     * @var QueryBuilder
     */
    private $builder;

    /**
     *
     * @var QueryFormatter
     */
    private $formatter;

    /**
     *
     * @var array
     */
    static $pagesizes;

    public function __construct (Twig_Environment $twig, QueryBuilder $builder, QueryFormatter $formatter)
    {
        $this->twig = $twig;
        $this->builder = $builder;
        $this->formatter = $formatter;
        self::$pagesizes = [
            QueryInput::VIEW_FULL => 20,
            QueryInput::VIEW_IMAGES => 20,
            QueryInput::VIEW_LIST => 100,
            QueryInput::VIEW_TEXT => 100,
            QueryInput::VIEW_ZOOM => 1,
        ];
    }

    public function render (QueryInput $input)
    {
        $query = $this->builder->getQuery($input);
        $cards = $query->getResult();

        if (count($cards) === 1) {
            return $this->renderOne($cards[0]);
        } else {
            return $this->renderMany($input, $cards);
        }
    }

    private function renderOne (Card $card)
    {
        $context = [
            "card" => $card
        ];

        return $this->twig->render("cards/view-one.html.twig", $context);
    }

    private function renderMany (QueryInput $input, array $cards)
    {
        $perPage = self::$pagesizes[$input->getView()];
        $totalRows = count($cards);
        
        $data = [
            "cards" => array_slice($cards, ($input->getPage() - 1) * $perPage, $perPage),
            "query" => $this->formatter->stringify($input->getClauses()),
            "view" => $input->getView(),
            "sort" => $input->getSort(),
            "page" => $input->getPage(),
            "perPage" => $perPage,
            "totalRows" => $totalRows,
        ];

        $template = "cards/view-" . $input->getView() . ".html.twig";

        return $this->twig->render($template, $data);
    }

}
