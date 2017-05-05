<?php

namespace AppBundle\Query;

/**
 * Description of QueryTemplating
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class QueryTemplating
{

    /**
     *
     * @var \Twig_Environment
     */
    private $twig;

    /**
     *
     * @var QueryBuilder
     */
    private $builder;

    public function __construct ($twig, $builder)
    {
        $this->twig = $twig;
        $this->builder = $builder;
    }

    public function render (QueryInput $input)
    {
        $query = $this->builder->getQuery($input->getClauses());
        $cards = $query->getResult();

        if (count($cards) === 1) {
            return $this->renderZoom($cards[0]);
        }

        $context = [
            "cards" => $cards
        ];

        $template = "cards/view-" . $input->getView() . ".html.twig";

        return $this->twig->render($template, $context);
    }

    public function renderZoom (\AppBundle\Entity\Card $card)
    {
        $context = [
            "card" => $card
        ];
        
        return $this->twig->render("cards/view-zoom.html.twig", $context);
    }

}
