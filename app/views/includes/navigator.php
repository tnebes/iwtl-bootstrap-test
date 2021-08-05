<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="/">Navbar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
       <!-- TODO: somehow make it print active if this is the current URL. -->
      <li class="nav-item active">
        <a class="nav-link" href="/">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/topics/index">Questions</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/suggestions/index">Suggestions</a>
      </li>
      <?php if(isLoggedIn()): ?>
         <li class="nav-item">
            <a class="nav-link" href="/users/index">Users</a>
         </li>
         <li class="nav-item">
            <a class="nav-link" href="/users/profile">My Profile</a>
         </li>
         <li class="nav-item">
            <a class="nav-link btn btn-outline-success mx-1" href="/er/index">ER diagram</a>
         </li>
         <li class="nav-item">
            <a class="nav-link btn btn-outline-info mx-1" href="/users/logout">Logout <span style="font-weight: bold;"><?php echo($_SESSION['username']);?></span></a>
         </li>
      <?php else: ?>
         <li class="nav-item">
            <a class="nav-link btn btn-outline-info mx-1" href="/users/login">Login</a>
         </li>
         <li class="nav-item">
            <a class="nav-link btn btn-info mx-1" href="/users/register">Register</a>
         </li>
      <?php endif; ?>
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>