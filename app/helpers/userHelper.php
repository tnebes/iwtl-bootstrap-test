<?php declare(strict_types = 1);

   function getUserActionsAdmin(int $userId) : string
   {
      $methods = ['profile', 'update', 'delete', 'ban'];
      $icons = [];
      $returnString = '';
      foreach ($methods as $method)
      {
         $returnString .= '<a href=' . URL_ROOT . '/users/' . $method . '/' . $userId . '>' . $method . '</a>';
      }
      return $returnString;
   }

   function getUserActions(string $userId) : string
   {
      $methods = ['profile'];
      $icons = [];
      $returnString = '';
      foreach ($methods as $method)
      {
         $returnString .= '<a href=' . URL_ROOT . '/users/' . $method . '/' . $userId . '>' . $method . '</a>';
      }
      return $returnString;

   }