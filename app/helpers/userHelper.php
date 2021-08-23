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

   function roleToString(int $role) : string
   {
      $roles = ['user', 'admin'];
      return $roles[$role];
   }

   function bannedToString(int $banned) : string
   {
      return $banned ? 'yes' : 'no';
   }

   function bannedToCheckbox(int $banned, bool $disabled = false) : string
   {
      return '<input class="form-check-input mx-auto" type="checkbox" id="banned" name="banned" value="" ' . ($disabled ? 'disabled' : '') . ' ' . ($banned ? 'checked' : '') . '>';
   }