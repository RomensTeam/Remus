<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author Roman
 */
interface ViewCoreInterface {
    public function render();
    public function setView(View $view);
    public function clear();
}
