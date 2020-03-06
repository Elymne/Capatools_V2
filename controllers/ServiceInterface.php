<?php

namespace app\controllers;

interface ServiceInterface
{

    public static  function getIndicator($user);

    /**
     * Use to create sub-menu in the LeftMenuBar widget.
     * 
     * @param User $user : Not used anymore.
     * @return Array All data about sub menu links. Used in LeftMenuBar widget.
     */
    public static  function getActionUser($user);
}
