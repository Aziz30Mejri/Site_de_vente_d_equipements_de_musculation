<?php
include_once "functions.php";
$categories = getAllCategories(); 
?>
<style>
  .notification-container {
    position: relative;
    display: inline-block;
    margin-left: 5px;
  }
  .notification-badge {
    background-color: #e31836;
    color: white;
    border-radius: 50%;
    padding: 2px 6px;
    font-size: 12px;
    font-weight: bold;
    position: absolute;
    top: -10px;
    right: -10px;
    transform: translate(50%, -50%);
    transition: transform 0.3s ease;
  }
  .navbar {
    display: flex;
    justify-content: space-between;
  }
  .form button {
    border: none;
    background: none;
    color: #8b8ba7;
  }
  .form {
    --timing: 0.3s;
    --width-of-input: 200px;
    --height-of-input: 40px;
    --border-height: 2px;
    --input-bg: #f0f0f0;
    --border-color: #e31836;
    --border-radius: 30px;
    --after-border-radius: 1px;
    position: relative;
    width: var(--width-of-input);
    height: var(--height-of-input);
    display: flex;
    align-items: center;
    padding-inline: 0.8em;
    border-radius: var(--border-radius);
    transition: border-radius 0.5s ease;
    background: var(--input-bg);
  }
  .input {
    font-size: 16px;
    font-weight: 600;
    background-color: transparent;
    width: 100%;
    height: 100%;
    padding-inline: 0.5em;
    padding-block: 0.7em;
    border: none;
  }
  .form:before {
    content: "";
    position: absolute;
    background: var(--border-color);
    transform: scaleX(0);
    transform-origin: center;
    width: 100%;
    height: var(--border-height);
    left: 0;
    bottom: 0;
    border-radius: 1px;
    transition: transform var(--timing) ease;
  }
  .form:focus-within {
    border-radius: var(--after-border-radius);
  }
  input:focus {
    outline: none;
  }
  .form:focus-within:before {
    transform: scale(1);
  }
  .reset {
    border: none;
    background: none;
    opacity: 0;
    visibility: hidden;
  }
  input:not(:placeholder-shown) ~ .reset {
    opacity: 1;
    visibility: visible;
  }
  .form:focus-within .reset svg path {
    color: #e31836; /* Couleur rouge de la croix lorsqu'il y a du texte */
  }
  .form:focus-within button {
  color: #e31836; /* Rouge lors de la saisie */
}
  .form svg {
    width: 17px;
    margin-top: 3px;
  }
  input[type="search"]::-webkit-search-cancel-button {
    -webkit-appearance: none;
    appearance: none;
  }
  .Btndec {
  display: flex;
  align-items: center;
  justify-content: flex-start;
  width: 40px;
  height: 40px;
  border: none;
  border-radius: 50%;
  cursor: pointer;
  position: relative;
  overflow: hidden;
  transition-duration: .3s;
  box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.199);
  background-color: #e31836;
}
.signdec {
  width: 100%;
  transition-duration: .3s;
  display: flex;
  align-items: center;
  justify-content: center;
}
.signdec svg {
  width: 17px;
}
.signdec svg path {
  fill: white;
}
.textdec {
  position: absolute;
  right: 0%;
  width: 0%;
  opacity: 0;
  color: white;
  font-weight: 600;
  transition-duration: .3s;
}
.Btndec:hover {
  width: 180px;
  border-radius: 40px;
  transition-duration: .3s;
}
.Btndec:hover .signdec {
  width: 30%;
  transition-duration: .3s;
  padding-left: 10px;
}
.Btndec:hover .textdec {
  opacity: 1;
  width: 70%;
  transition-duration: .3s;
  padding-right: 10px;
}
.Btndec:active {
  transform: translate(2px ,2px);
}
.navbar-nav .nav-item .nav-link:hover {
  color: #e31836;
  font-weight: bold;
  text-decoration: underline;
}
.dropdown-item:active {
  background-color: #e31836;
}
</style>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" style="color: #e31836; font-weight: bold;" href="index.php"><?php echo htmlspecialchars(getNomSociete()); ?></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Catégories
          </a>
          <ul class="dropdown-menu">
          <?php foreach($categories as $categorie): ?>
            <a href="categorie.php?categorie_id=<?php echo htmlspecialchars($categorie['id']); ?>" class="dropdown-item">
                <?php echo htmlspecialchars(ucwords($categorie['nom'])); ?>
            </a>
          <?php endforeach; ?>
          </ul>
        </li>
        <?php 
          if (isset($_SESSION['nom'])) {
            /*print'<li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="profile.php">Profile</a>
                  </li>';*/
            if (isset($_SESSION['panier']) && is_array($_SESSION['panier'][3])) {
              print'<li class="nav-item">
                      <a class="nav-link active" aria-current="page" href="panier.php">
                      Panier
                        <div class="notification-container">
                          <span class="notification-badge">'. count($_SESSION['panier'][3]) .'</span>
                        </div>
                      </a>
                    </li>';
            } else {
              print'<li class="nav-item">
                      <a class="nav-link active" aria-current="page" href="panier.php">
                      Panier
                        <div class="notification-container">
                          <span class="notification-badge">0</span>
                        </div>
                      </a>
                    </li>';
            }
          } else {
            print'<li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="connexion.php">Connexion</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="register.php">S&rsquo;inscrire</a>
                  </li>';
          }
        ?>
      </ul>
      <!-- Formulaire de recherche -->
      <form class="form" action="index.php" method="POST">
        <button>
            <svg width="20" height="20" fill="none" xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="search">
                <path d="M7.667 12.667A5.333 5.333 0 107.667 2a5.333 5.333 0 000 10.667zM14.334 14l-2.9-2.9" stroke="currentColor" stroke-width="1.333" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
        </button>
        <input class="input" placeholder="Recherche" type="search" aria-label="Search" name="search">
        <button class="reset" type="reset">
            <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
      </form>
      <?php
        if (isset($_SESSION['nom'])) {
          print '<a href="deconnexion.php" class="Btndec">
                  <div class="signdec">
                    <svg viewBox="0 0 512 512"><path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"></path></svg>
                  </div>
                  <div class="textdec">Déconnexion</div>
                </a>';
        }
      ?>
    </div>
  </div>
</nav>