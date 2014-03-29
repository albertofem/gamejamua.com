<?php

/*
 * Copyright (c) 2013 Certadia, SL
 * All rights reserved
 */

namespace GJA\GameJam\CompoBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/")
 */
class FrontendController extends Controller
{
    /**
     * @Route("/", name="gamejam_compo_frontend")
     * @Template()
     */
    public function indexAction()
    {
        return [];
    }

    /**
     * @Route("/normas", name="gamejam_compo_frontend_rules")
     * @Template()
     */
    public function rulesAction()
    {
        return [];
    }

    /**
     * @Route("/_partial/login", name="gamejam_compo_frontend_partial_login")
     * @Template("GameJamCompoBundle:Frontend:_login.html.twig")
     */
    public function partialLoginAction()
    {
        $csrfToken = $this->container->has('form.csrf_provider')
            ? $this->container->get('form.csrf_provider')->generateCsrfToken('authenticate')
            : null;

        return ['csrf_token' => $csrfToken];
    }
}