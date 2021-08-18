<?php declare(strict_types = 1);

    function getUserActions(string $userId) : string
   {
      $methods = ['profile', 'update', 'delete', 'ban'];
      $icons = [];
      $returnString = '';
      foreach ($methods as $method)
      {
         $returnString .= '<a href=' . URL_ROOT . '/' . $method . '/' . $userId . '>ICON</a>';
      }      

      return $returnString;
   }