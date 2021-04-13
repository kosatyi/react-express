<?php

    namespace App\Controller;

    use ReactExpress\Core\Controller;

    class Dashboard extends Controller {
        /**
         * @app.method get
         * @app.route /
         */
        public function index(): void
        {
            $this->next();
        }
        /**
         * @app.method get
         * @app.route /my/:category
         */
        public function categorySetter(): void
        {
            print_r($this->app->route->all());
            $this->next();
        }
    }